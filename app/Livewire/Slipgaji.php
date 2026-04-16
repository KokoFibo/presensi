<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Carbon\Carbon;



class Slipgaji extends Component
{
    public $month;
    public $months;
    public $selectedMonth;
    public $year;
    public $id_karyawan;
    public $id_pengganti_kokonacci = 110; // ID pengganti untuk karyawan dengan id_karyawan 80000

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }

    public function mount()
    {


        Carbon::setLocale('id');

        $this->months = collect();

        for ($i = 1; $i <= 3; $i++) {
            $date = Carbon::now()->subMonths($i);

            $this->months->push([
                'value' => $date->format('Y-m'), // buat value select
                'label' => $date->translatedFormat('F Y') // contoh: Januari 2026
            ]);
        }
        $date = Carbon::now()->subMonth();
        $this->year = $date->year;   // 2026
        $this->month = $date->month; // 3
    }

    public function updatedSelectedMonth()
    {
        $date = Carbon::createFromFormat('Y-m', $this->selectedMonth);

        $this->year = $date->year;   // 2026
        $this->month = $date->month; // 3
    }

    public function render()
    {
        if (auth()->user()->outsource == 1) {
            return view('livewire.slipgaji', [
                'datas' => null,
                'errors' => ['Anda tidak memiliki akses untuk melihat slip gaji.'],
            ]);
        }
        $this->id_karyawan  = Auth::user()->id_karyawan;

        // ganti ini untuk cek presensi
        if ($this->id_karyawan == 80000) $this->id_karyawan = $this->id_pengganti_kokonacci;

        $db_code = Auth::user()->db_code;
        // $this->month = 3;
        // $this->year = 2026;
        $datas = [];
        $errors = [];
        $endpoint = 'https://' . $db_code . '.yifang.co.id/api/get-payroll/' . $this->id_karyawan . '/' . $this->month . '/' . $this->year;
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
        // dd($datas['data'], $errors);
        return view('livewire.slipgaji', [
            'datas' => $datas['data'] ?? null,
            'errors' => $errors ?? null,
        ]);
    }
}
