<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;


// class Presensi extends Component
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
    public $is_filled = true; // ID pengganti untuk karyawan dengan id_karyawan 80000

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
            $response = Http::put(
                url('http://127.0.0.1:8080/api/karyawan/' . $this->id_karyawan . '/pendidikan'),
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
                $this->addError('pendidikan', 'Gagal menyimpan data. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
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
            // $response = Http::get(
            //     url('https://' . $this->db_code . '.yifang.co.id/api/karyawan/' . $this->id_karyawan . '/pendidikan')
            // );
            $response = Http::get(
                url('http://' . $this->db_code . '.yifang.co.id/api/karyawan/' . $this->id_karyawan . '/pendidikan')
            );
            if ($response->successful()) {
                $data = $response->json();

                $this->pendidikan = $data['pendidikan'] ?? '';
                $this->pendidikanSudahTerisi = $data['sudah_terisi'] ?? false;

                return $this->pendidikanSudahTerisi === true;
            }

            return false;
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            $this->pendidikan = '';
            $this->pendidikanSudahTerisi = false;

            return false;
        }
    }

    public function mount()
    {
        // Route::get('/latest-month-year/{user_id}', [AttendanceController::class, 'getLatestMonthYearByUser']);
        $this->is_slipgaji = true;
        $this->id_karyawan  = Auth::user()->id_karyawan;
        $this->db_code = Auth::user()->db_code;
        // $this->db_code = 'sti';

        // Cek  apakah karyawan sudah mengisi data pendidikan
        // $this->db_code = 'payroll';

        // $this->id_karyawan = 14669;
        $this->is_filled = true;
        if ($this->db_code == 'payroll' || $this->db_code == 'salary') {
            $this->is_filled =  $this->cekPendidikan();
            // dd($this->id_karyawan, $this->db_code, $is_filled);
        }

        if ($this->id_karyawan == 80000) $this->id_karyawan = $this->id_pengganti_kokonacci;
        $endpoint = 'https://' . $this->db_code . '.yifang.co.id/api/latest-month-year/' . $this->id_karyawan;
        try {
            $response = Http::timeout(30)->get($endpoint);

            if ($response->successful()) {
                $datas = $response->json();
                // $allDatas = array_merge($allData, $datas);
            } else {
                $errors[] = "Gagal mengambil data dari: $endpoint - Status: " . $response->status();
            }
        } catch (\Exception $e) {
            $errors[] = "Error mengambil data dari $endpoint: " . $e->getMessage();
        }
        // dd($datas['month']);
        // dd($datas);

        // $this->month = Carbon::now()->month;
        // $this->year = Carbon::now()->year;
        // $this->selectedMonth = $this->month . '-' . $this->year;

        $this->month = $datas['data']['month'];
        $this->year = $datas['data']['year'];
        $this->selectedMonth = $datas['data']['month_year'];
    }
    public function updatedSelectedMonth($key)
    {
        $selected = $this->available_months[$key];

        $this->month = $selected['month'];
        $this->year = $selected['year'];
        // dd($this->month, $this->year);
    }
    public function render()
    {
        // $this->db_code = Auth::user()->db_code;
        // $this->id_karyawan  = Auth::user()->id_karyawan;
        // dd($this->id_karyawan);
        // $this->month = 2;
        // $this->year = 2026;
        $allData = [];
        $errors = [];
        $datas = [];
        $endpoint = 'https://' . $this->db_code . '.yifang.co.id/api/attendance/' . $this->id_karyawan  . '/' . $this->month . '/' . $this->year;
        try {
            $response = Http::timeout(30)->get($endpoint);

            if ($response->successful()) {
                $datas = $response->json();
                // $allDatas = array_merge($allData, $datas);
            } else {
                $errors[] = "Gagal mengambil data dari: $endpoint - Status: " . $response->status();
            }
        } catch (\Exception $e) {
            $errors[] = "Error mengambil data dari $endpoint: " . $e->getMessage();
        }

        $this->available_months = $datas['available_months'] ?? [];
        // dd($datas);
        // dd($datas['data']);
        // dd($datas['available_months']);
        // dd($datas['summary']);
        // dd($datas['current_month_year']['month_year']);
        // dd($datas['message']);

        $this->total_hari_kerja = count($datas['data'] ?? []);
        // dd($datas['is_locked']);
        return view('livewire.presensi', [
            'datas' => $datas['data'] ?? [],
            'month_year' => $datas['current_month_year']['month_year'] ?? '',
            'summary' => $datas['summary'] ?? [],
            'is_locked' => $datas['is_locked'],
            // 'available_months' => $datas['available_months'] ?? [],
            // 'errors' => $errors,
            'apiErrors' => $errors,
        ]);
    }
}
