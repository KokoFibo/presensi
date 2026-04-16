<div>
    <x-layouts.app>

        <div class="p-4 space-y-4">

            <!-- Header -->
            <h1 class="text-xl font-bold text-gray-800">
                Slip Gaji - {{ \Carbon\Carbon::create()->month($month)->locale('id')->translatedFormat('F') }}
                {{ $year }}
            </h1>
            <select wire:model.live="selectedMonth" class="border border-gray-300 rounded px-3 py-2">

                @foreach ($months as $month)
                    <option value="{{ $month['value'] }}">
                        {{ $month['label'] }}
                    </option>
                @endforeach

            </select>

            <!-- Card Utama -->
            <div class="bg-white rounded-2xl shadow border border-gray-100 p-4 space-y-4">

                <!-- Ringkasan Jam (optional, nyambung ke presensi) -->
                <div class="bg-white rounded-xl border border-gray-100 shadow p-3">
                    <div class="grid grid-cols-3 text-center text-sm">

                        <div>
                            <div class="text-gray-500 text-[11px]">Jam Kerja</div>
                            <div class="font-semibold">{{ $datas['jam_kerja'] }} Jam</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-[11px]">Lembur</div>
                            <div class="font-semibold text-orange-600">{{ $datas['jam_lembur'] }} Jam</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-[11px]">Hari Kerja</div>
                            <div class="font-semibold text-purple-600">{{ $datas['hari_kerja'] }} Hari</div>
                        </div>

                    </div>
                </div>

                <!-- Nama & Info -->
                {{-- <div>
                    <div class="text-sm text-gray-500">Nama</div>
                    <div class="font-semibold text-gray-800">{{ $datas['nama'] }}</div>

                    <div class="text-sm text-gray-500 mt-2">Jabatan</div>
                    <div class="font-semibold text-gray-800">Operator Produksi</div>
                </div> --}}

                <!-- Divider -->
                {{-- <div class="border-t"></div> --}}

                <!-- Pendapatan -->
                {{-- <div>
                    <div class="text-sm font-semibold text-gray-700 mb-2">
                        Pendapatan
                    </div>

                    <div class="space-y-2 text-sm">

                        <div class="flex justify-between">
                            <span>Gaji Pokok</span>
                            <span class="font-medium">Rp 3.000.000</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Lembur</span>
                            <span class="font-medium text-orange-600">Rp 500.000</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Tunjangan</span>
                            <span class="font-medium text-green-600">Rp 300.000</span>
                        </div>

                    </div>
                </div> --}}

                <!-- Divider -->
                <div class="border-t"></div>

                <!-- Potongan -->
                {{-- <div>
                    <div class="text-sm font-semibold text-gray-700 mb-2">
                        Potongan
                    </div>

                    <div class="space-y-2 text-sm">

                        <div class="flex justify-between">
                            <span>BPJS</span>
                            <span class="font-medium text-red-500">Rp 150.000</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Keterlambatan</span>
                            <span class="font-medium text-red-500">Rp 50.000</span>
                        </div>

                    </div>
                </div> --}}




                {{-- yifang slip gaji style --}}
                <div>
                    <div class="text-sm font-semibold text-gray-700 mb-2">
                        {{-- Potongan --}}
                    </div>

                    <div class="space-y-2 text-sm">

                        <div class="flex justify-between">
                            <span>ID</span>
                            <span class="font-medium text-red-500">{{ $datas['id_karyawan'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total hari kerja</span>
                            <span class="font-medium text-red-500">{{ $datas['hari_kerja'] }} hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Jam kerja</span>
                            <span class="font-medium text-red-500">{{ $datas['jam_kerja'] }} Jam</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Jam Lembur</span>
                            <span class="font-medium text-red-500">{{ $datas['jam_lembur'] }} Jam</span>
                        </div>
                        <div class="flex justify-between">
                            <span>BPJS JHT</span>
                            <span class="font-medium text-red-500">Rp {{ number_format($datas['jht']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>BPJS JP</span>
                            <span class="font-medium text-red-500">Rp {{ number_format($datas['jp']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>PTKP</span>
                            <span class="font-medium text-red-500">{{ $datas['ptkp'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>PPh21</span>
                            <span class="font-medium text-red-500">Rp {{ number_format($datas['pph21']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Terima</span>
                            <span class="font-medium text-red-500">Rp {{ number_format($datas['total']) }}</span>
                        </div>


                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t"></div>

                <!-- Total -->
                <div class="flex justify-between items-center">
                    <span class="text-base font-semibold text-gray-800">
                        Total Diterima
                    </span>
                    <span class="text-lg font-bold text-blue-600">
                        Rp {{ number_format($datas['total']) }}
                    </span>
                </div>

            </div>



        </div>

        <!-- Spacer -->
        <div class="h-20"></div>

        <!-- Bottom Navbar (reuse dari kamu) -->
        <!-- Spacer supaya tidak ketutup navbar -->
        <div class="h-20"></div>

        <!-- 🔻 Bottom Navbar -->
        <div class="fixed bottom-0 left-0 right-0 z-50 
    bg-white/80 backdrop-blur-lg border-t border-gray-200">

            {{-- <div class="grid grid-cols-3 py-2 text-xs"> --}}
            <div class="flex justify-between p-10 py-2 text-xs">

                <!-- Presensi -->
                <a href="{{ route('presensi') }}"
                    class="flex flex-col items-center gap-1 transition active:scale-95
            {{ request()->routeIs('presensi') ? 'text-blue-600' : 'text-gray-400' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 6.75h15a1.5 1.5 0 011.5 1.5v10.5A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75V8.25a1.5 1.5 0 011.5-1.5z" />
                    </svg>

                    <span>Presensi</span>
                </a>

                <!-- Slip Gaji -->
                <a href="{{ route('slipgaji') }}"
                    class="flex flex-col items-center gap-1 transition active:scale-95
            {{ request()->routeIs('slipgaji') ? 'text-blue-600' : 'text-gray-400' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H7.875A3.375 3.375 0 004.5 11.625v2.625m15 0v2.25a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 16.5v-2.25m15 0H4.5" />
                    </svg>

                    <span>Slip Gaji</span>
                </a>

                <!-- Logout -->
                <button wire:click="logout"
                    class="flex flex-col items-center gap-1 text-gray-400 transition active:scale-95">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3-3l-3-3m0 0l-3 3m3-3v12" />
                    </svg>

                    <span>Logout</span>
                </button>

            </div>
        </div>

    </x-layouts.app>
</div>
