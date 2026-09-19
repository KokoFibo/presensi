<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Presensi extends Component
{
    public $month;
    public $year;
    public $selectedMonth = [];
    public $available_months = [];
    public $total_hari_kerja = 0;
    public $is_slipgaji = false;
    public $id_karyawan;
    public $db_code;
    public $id_pengganti_kokonacci = 1070;
    public $is_filled = true;

    public $pendidikan = '';
    public $jurusan = '';
    public $nama_kampus = '';

    protected function rules()
    {
        return [
            'pendidikan'  => 'required|string|max:100',
            'jurusan'     => 'nullable|string|max:100',
            'nama_kampus' => 'nullable|string|max:100',
        ];
    }

    #[Computed]
    public function butuhDetailPendidikan(): bool
    {
        return in_array($this->pendidikan, ['SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']);
    }

    protected $messages = [
        'pendidikan.required' => 'Pendidikan wajib diisi.',
    ];

    public function simpanPendidikan()
    {
        $pendidikanTanpaDetail = ['Tidak Bersekolah', 'SD', 'SMP'];

        if (in_array($this->pendidikan, $pendidikanTanpaDetail)) {
            $this->jurusan = null;
            $this->nama_kampus = null;
        } else {
            $this->jurusan = $this->jurusan ? Str::title(trim($this->jurusan)) : null;
            $this->nama_kampus = $this->nama_kampus ? Str::title(trim($this->nama_kampus)) : null;
        }

        $this->validate();

        try {
            $response = Http::timeout(30)
                ->retry(2, 200)
                ->put(
                    url('https://' . $this->db_code . '.yifang.co.id/api/karyawan/' . $this->id_karyawan . '/pendidikan'),
                    [
                        'pendidikan'  => $this->pendidikan,
                        'jurusan'     => $this->jurusan,
                        'nama_kampus' => $this->nama_kampus,
                    ]
                );

            if ($response->successful()) {
                $data = $response->json();
                $this->is_filled = $data['sudah_terisi'] ?? true;

                session()->flash('message', 'Data pendidikan berhasil disimpan.');
            } else {
                logger()->error('Presensi simpanPendidikan() gagal', [
                    'status'      => $response->status(),
                    'body'        => $response->body(),
                    'id_karyawan' => $this->id_karyawan,
                    'db_code'     => $this->db_code,
                ]);
                $this->addError('pendidikan', 'Gagal menyimpan data. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            logger()->error('Presensi simpanPendidikan() exception', [
                'message'     => $e->getMessage(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);
            $this->addError('pendidikan', 'Terjadi kesalahan koneksi. Silakan coba lagi.');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }

    public function cekPendidikan(): bool
    {
        try {
            $response = Http::timeout(30)
                ->retry(2, 200)
                ->get(
                    url('https://' . $this->db_code . '.yifang.co.id/api/karyawan/' . $this->id_karyawan . '/pendidikan')
                );

            if ($response->successful()) {
                $data = $response->json();

                $this->pendidikan = $data['pendidikan'] ?? '';
                $this->pendidikanSudahTerisi = $data['sudah_terisi'] ?? false;

                return $this->pendidikanSudahTerisi === true;
            }

            logger()->error('Presensi cekPendidikan() gagal', [
                'status'      => $response->status(),
                'body'        => $response->body(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);

            return false;
        } catch (\Exception $e) {
            logger()->error('Presensi cekPendidikan() exception', [
                'message'     => $e->getMessage(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);

            $this->pendidikan = '';
            $this->pendidikanSudahTerisi = false;

            return false;
        }
    }

    public function mount()
    {
        $this->is_slipgaji = true;
        $this->id_karyawan = Auth::user()->id_karyawan;
        $this->db_code = Auth::user()->db_code;

        $this->is_filled = true;
        if ($this->db_code == 'payroll' || $this->db_code == 'salary') {
            $this->is_filled = $this->cekPendidikan();
        }

        if ($this->id_karyawan == 80000) $this->id_karyawan = $this->id_pengganti_kokonacci;

        $datas = [];
        $endpoint = 'https://' . $this->db_code . '.yifang.co.id/api/latest-month-year/' . $this->id_karyawan;

        try {
            $response = Http::timeout(30)
                ->retry(2, 200)
                ->get($endpoint);

            if ($response->successful()) {
                $datas = $response->json();
            } else {
                logger()->error('Presensi mount() gagal ambil latest-month-year', [
                    'endpoint'    => $endpoint,
                    'status'      => $response->status(),
                    'body'        => $response->body(),
                    'id_karyawan' => $this->id_karyawan,
                    'db_code'     => $this->db_code,
                ]);
            }
        } catch (\Exception $e) {
            logger()->error('Presensi mount() exception latest-month-year', [
                'endpoint'    => $endpoint,
                'message'     => $e->getMessage(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);
        }

        // Fallback ke bulan/tahun saat ini kalau API gagal atau data tidak lengkap
        $this->month = $datas['data']['month'] ?? Carbon::now()->month;
        $this->year = $datas['data']['year'] ?? Carbon::now()->year;
        $this->selectedMonth = $datas['data']['month_year'] ?? Carbon::now()->format('F Y');
    }

    public function updatedSelectedMonth($key)
    {
        $selected = $this->available_months[$key] ?? null;

        if ($selected) {
            $this->month = $selected['month'];
            $this->year = $selected['year'];
        }
    }

    public function render()
    {
        $errors = [];
        $datas = [];
        $endpoint = 'https://' . $this->db_code . '.yifang.co.id/api/attendance/' . $this->id_karyawan . '/' . $this->month . '/' . $this->year;

        try {
            $response = Http::timeout(30)
                ->retry(2, 200)
                ->get($endpoint);

            if ($response->successful()) {
                $datas = $response->json();
            } else {
                $errors[] = 'Data sedang tidak dapat dimuat. Silakan coba lagi.';
                logger()->error('Presensi render() gagal ambil attendance', [
                    'endpoint'    => $endpoint,
                    'status'      => $response->status(),
                    'body'        => $response->body(),
                    'id_karyawan' => $this->id_karyawan,
                    'db_code'     => $this->db_code,
                ]);
            }
        } catch (\Exception $e) {
            $errors[] = 'Data sedang tidak dapat dimuat. Silakan coba lagi.';
            logger()->error('Presensi render() exception attendance', [
                'endpoint'    => $endpoint,
                'message'     => $e->getMessage(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);
        }

        $this->available_months = $datas['available_months'] ?? [];
        $this->total_hari_kerja = count($datas['data'] ?? []);

        return view('livewire.presensi', [
            'datas'       => $datas['data'] ?? [],
            'month_year'  => $datas['current_month_year']['month_year'] ?? '',
            'summary'     => $datas['summary'] ?? [],
            'is_locked'   => $datas['is_locked'] ?? true,
            'apiErrors'   => $errors,
        ]);
    }
}
