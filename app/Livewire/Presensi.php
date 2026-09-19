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

    // Data attendance disimpan di property.
    // Dengan demikian render() tidak perlu melakukan HTTP request.
    public $attendanceData = [];
    public $attendanceMonthYear = '';
    public $attendanceSummary = [];
    public $attendanceLocked = true;
    public $apiErrors = [];

    protected function rules()
    {
        return [
            'pendidikan'  => 'required|string|max:100',
            'jurusan'     => 'nullable|string|max:100',
            'nama_kampus' => 'nullable|string|max:100',
        ];
    }

    protected $messages = [
        'pendidikan.required' => 'Pendidikan wajib diisi.',
    ];

    #[Computed]
    public function butuhDetailPendidikan(): bool
    {
        return in_array(
            $this->pendidikan,
            ['SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
            true
        );
    }

    /**
     * HTTP client untuk API internal Yifang.
     *
     * API yang sebelumnya dites hanya membutuhkan sekitar 0.08 detik.
     * Timeout dibuat lebih pendek agar PHP-FPM worker tidak tertahan
     * terlalu lama jika API sedang bermasalah.
     */
    protected function httpClient()
    {
        return Http::connectTimeout(3)
            ->timeout(5);
    }

    /**
     * Membuat URL API berdasarkan db_code.
     */
    protected function apiUrl(string $path): string
    {
        return 'https://' . $this->db_code . '.yifang.co.id' . $path;
    }

    /**
     * Simpan data pendidikan.
     */
    public function simpanPendidikan()
    {
        $pendidikanTanpaDetail = [
            'Tidak Bersekolah',
            'SD',
            'SMP',
        ];

        if (in_array($this->pendidikan, $pendidikanTanpaDetail, true)) {
            $this->jurusan = null;
            $this->nama_kampus = null;
        } else {
            $this->jurusan = $this->jurusan
                ? Str::title(trim($this->jurusan))
                : null;

            $this->nama_kampus = $this->nama_kampus
                ? Str::title(trim($this->nama_kampus))
                : null;
        }

        $this->validate();

        try {
            $response = $this->httpClient()->put(
                $this->apiUrl(
                    '/api/karyawan/' . $this->id_karyawan . '/pendidikan'
                ),
                [
                    'pendidikan'  => $this->pendidikan,
                    'jurusan'     => $this->jurusan,
                    'nama_kampus' => $this->nama_kampus,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();

                $this->is_filled = $data['sudah_terisi'] ?? true;

                session()->flash(
                    'message',
                    'Data pendidikan berhasil disimpan.'
                );

                return;
            }

            logger()->error('Presensi simpanPendidikan() gagal', [
                'status'      => $response->status(),
                'body'        => $response->body(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);

            $this->addError(
                'pendidikan',
                'Gagal menyimpan data. Silakan coba lagi.'
            );
        } catch (\Throwable $e) {
            logger()->error('Presensi simpanPendidikan() exception', [
                'message'     => $e->getMessage(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);

            $this->addError(
                'pendidikan',
                'Terjadi kesalahan koneksi. Silakan coba lagi.'
            );
        }
    }

    /**
     * Logout user.
     */
    public function logout()
    {
        auth()->logout();

        return redirect('/login');
    }

    /**
     * Cek apakah pendidikan sudah terisi.
     */
    public function cekPendidikan(): bool
    {
        try {
            $response = $this->httpClient()->get(
                $this->apiUrl(
                    '/api/karyawan/' . $this->id_karyawan . '/pendidikan'
                )
            );

            if ($response->successful()) {
                $data = $response->json();

                $this->pendidikan = $data['pendidikan'] ?? '';

                $this->is_filled = $data['sudah_terisi'] ?? false;

                return $this->is_filled === true;
            }

            logger()->error('Presensi cekPendidikan() gagal', [
                'status'      => $response->status(),
                'body'        => $response->body(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);

            return false;
        } catch (\Throwable $e) {
            logger()->error('Presensi cekPendidikan() exception', [
                'message'     => $e->getMessage(),
                'id_karyawan' => $this->id_karyawan,
                'db_code'     => $this->db_code,
            ]);

            $this->pendidikan = '';
            $this->is_filled = false;

            return false;
        }
    }

    /**
     * Mengambil bulan/tahun terbaru.
     */
    protected function loadLatestMonthYear(): void
    {
        $endpoint = $this->apiUrl(
            '/api/latest-month-year/' . $this->id_karyawan
        );

        try {
            $response = $this->httpClient()->get($endpoint);

            if ($response->successful()) {
                $datas = $response->json();

                $this->month = $datas['data']['month']
                    ?? Carbon::now()->month;

                $this->year = $datas['data']['year']
                    ?? Carbon::now()->year;

                $this->selectedMonth = $datas['data']['month_year']
                    ?? Carbon::now()->format('F Y');

                return;
            }

            logger()->error(
                'Presensi loadLatestMonthYear() gagal',
                [
                    'endpoint'    => $endpoint,
                    'status'      => $response->status(),
                    'body'        => $response->body(),
                    'id_karyawan' => $this->id_karyawan,
                    'db_code'     => $this->db_code,
                ]
            );
        } catch (\Throwable $e) {
            logger()->error(
                'Presensi loadLatestMonthYear() exception',
                [
                    'endpoint'    => $endpoint,
                    'message'     => $e->getMessage(),
                    'id_karyawan' => $this->id_karyawan,
                    'db_code'     => $this->db_code,
                ]
            );
        }

        // Fallback jika API gagal.
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
        $this->selectedMonth = Carbon::now()->format('F Y');
    }

    /**
     * Mengambil data attendance.
     *
     * Ini sengaja dipisahkan dari render().
     */
    public function loadAttendance(): void
    {
        // Pastikan month/year memiliki nilai.
        if (!$this->month) {
            $this->month = Carbon::now()->month;
        }

        if (!$this->year) {
            $this->year = Carbon::now()->year;
        }

        $endpoint = $this->apiUrl(
            '/api/attendance/' .
                $this->id_karyawan .
                '/' .
                $this->month .
                '/' .
                $this->year
        );

        try {
            $response = $this->httpClient()->get($endpoint);

            if ($response->successful()) {
                $datas = $response->json();

                $this->attendanceData =
                    $datas['data'] ?? [];

                $this->attendanceMonthYear =
                    $datas['current_month_year']['month_year']
                    ?? '';

                $this->attendanceSummary =
                    $datas['summary'] ?? [];

                $this->attendanceLocked =
                    $datas['is_locked'] ?? true;

                $this->available_months =
                    $datas['available_months'] ?? [];

                $this->total_hari_kerja =
                    count($this->attendanceData);

                $this->apiErrors = [];

                return;
            }

            $this->apiErrors = [
                'Data sedang tidak dapat dimuat. Silakan coba lagi.',
            ];

            logger()->error(
                'Presensi loadAttendance() gagal',
                [
                    'endpoint'    => $endpoint,
                    'status'      => $response->status(),
                    'body'        => $response->body(),
                    'id_karyawan' => $this->id_karyawan,
                    'db_code'     => $this->db_code,
                ]
            );
        } catch (\Throwable $e) {
            $this->apiErrors = [
                'Data sedang tidak dapat dimuat. Silakan coba lagi.',
            ];

            logger()->error(
                'Presensi loadAttendance() exception',
                [
                    'endpoint'    => $endpoint,
                    'message'     => $e->getMessage(),
                    'id_karyawan' => $this->id_karyawan,
                    'db_code'     => $this->db_code,
                ]
            );
        }
    }

    /**
     * Inisialisasi component.
     */
    public function mount()
    {
        $this->is_slipgaji = true;

        $this->id_karyawan = Auth::user()->id_karyawan;
        $this->db_code = Auth::user()->db_code;

        /*
         * Perbaikan:
         * Penggantian ID dilakukan SEBELUM API pendidikan dipanggil.
         */
        if ($this->id_karyawan == 80000) {
            $this->id_karyawan = $this->id_pengganti_kokonacci;
        }

        $this->is_filled = true;

        /*
         * Hanya payroll dan salary yang membutuhkan pengecekan pendidikan.
         */
        if (
            $this->db_code === 'payroll' ||
            $this->db_code === 'salary'
        ) {
            $this->is_filled = $this->cekPendidikan();
        }

        /*
         * Ambil bulan/tahun terbaru.
         */
        $this->loadLatestMonthYear();

        /*
         * Ambil attendance SATU KALI saat mount.
         */
        $this->loadAttendance();
    }

    /**
     * Ketika user mengganti bulan.
     */
    public function updatedSelectedMonth($key)
    {
        $selected = $this->available_months[$key] ?? null;

        if (!$selected) {
            return;
        }

        $this->month = $selected['month'];
        $this->year = $selected['year'];

        /*
         * Hanya ketika bulan berubah kita perlu
         * mengambil attendance lagi.
         */
        $this->loadAttendance();
    }

    /**
     * Render hanya bertugas menampilkan data.
     *
     * TIDAK ADA HTTP REQUEST DI SINI.
     */
    public function render()
    {
        return view('livewire.presensi', [
            'datas'      => $this->attendanceData,
            'month_year' => $this->attendanceMonthYear,
            'summary'    => $this->attendanceSummary,
            'is_locked'  => $this->attendanceLocked,
            'apiErrors'  => $this->apiErrors,
        ]);
    }
}
