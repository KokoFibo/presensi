<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
    public $id_pengganti_kokonacci = 110; // ID pengganti untuk karyawan dengan id_karyawan 80000

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }

    public function mount()
    {
        // Route::get('/latest-month-year/{user_id}', [AttendanceController::class, 'getLatestMonthYearByUser']);
        $this->is_slipgaji = true;
        $this->id_karyawan  = Auth::user()->id_karyawan;
        $this->db_code = Auth::user()->db_code;
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
        // dd($endpoint);
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
            'errors' => $errors,
        ]);
    }
}
