<div>
    <x-layouts.app>

        <div class="w-full max-w-[420px] mx-auto p-4 space-y-4 pb-24">
            @if (auth()->user()->outsource == 1 || $is_locked)

                <div class="p-4 pb-24">
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow border dark:border-gray-700 p-6 text-center space-y-3">

                        <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            Akses Ditolak
                        </div>

                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Anda tidak memiliki akses untuk melihat slip gaji.
                        </div>

                        <div class="text-3xl">🚫</div>

                    </div>
                </div>
            @else
                <!-- Header -->
                <div class="space-y-2">
                    <h1 class="text-lg font-bold text-gray-800 dark:text-gray-600">
                        Slip Gaji
                    </h1>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-600">
                            {{ \Carbon\Carbon::create()->month($month)->locale('id')->translatedFormat('F') }}
                            {{ $year }}
                        </div>

                        <select wire:model.live="selectedMonth"
                            class="text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 dark:text-gray-100 rounded-lg px-2 py-1 focus:ring-2 focus:ring-blue-500">

                            @foreach ($months as $month)
                                <option value="{{ $month['value'] }}">
                                    {{ $month['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- 💰 Total Highlight -->
                {{-- <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-2xl p-4 shadow">
                    <div class="text-xs opacity-80">Total Diterima</div>
                    <div class="text-2xl font-bold mt-1">
                        Rp {{ number_format($datas['total']) }}
                    </div>
                </div> --}}


                <!-- Summary -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700 shadow p-3">

                    <div class="grid grid-cols-4 gap-2 text-center">

                        <!-- Total Jam Kerja -->
                        <div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400">Jam</div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                {{ $summary['total_jam_kerja'] + $summary['total_jam_kerja_libur'] }}
                            </div>
                        </div>

                        <!-- Total Lembur -->
                        <div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400">Lembur</div>
                            <div class="text-lg font-semibold text-orange-600">
                                {{ $summary['total_jam_lembur'] + $summary['total_jam_lembur_libur'] }}
                            </div>
                        </div>

                        <!-- Total Shift Malam -->
                        <div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400">Shift</div>
                            <div class="text-lg font-semibold text-purple-600">
                                {{ $summary['total_shift_malam'] }}
                            </div>
                        </div>

                        <!-- Total Hari Kerja -->
                        <div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400">Hari</div>
                            <div class="text-lg font-semibold text-blue-600">
                                {{ $total_hari_kerja }}
                            </div>
                        </div>

                    </div>

                </div>


                <!-- 🧾 Detail -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border dark:border-gray-700 p-4 space-y-3">

                    <div class="text-sm font-semibold text-gray-700 dark:text-gray-100">
                        Detail Gaji
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500 dark:text-gray-400">ID</span>
                            <span
                                class="font-medium text-gray-800 dark:text-gray-100">{{ $datas['id_karyawan'] }}</span>
                        </div>

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500 dark:text-gray-400">Hari Kerja</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">{{ $datas['hari_kerja'] }}
                                hari</span>
                        </div>

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500 dark:text-gray-400">Jam Kerja</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">{{ $datas['jam_kerja'] }}
                                jam</span>
                        </div>

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500 dark:text-gray-400">Jam Lembur</span>
                            <span class="font-medium text-orange-500">{{ $datas['jam_lembur'] }} jam</span>
                        </div>

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500 dark:text-gray-400">BPJS JHT</span>
                            <span class="font-medium text-red-500">Rp {{ number_format($datas['jht']) }}</span>
                        </div>

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500 dark:text-gray-400">BPJS JP</span>
                            <span class="font-medium text-red-500">Rp {{ number_format($datas['jp']) }}</span>
                        </div>

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500 dark:text-gray-400">PTKP</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">{{ $datas['ptkp'] }}</span>
                        </div>

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500 dark:text-gray-400">PPh21</span>
                            <span class="font-medium text-red-500">Rp {{ number_format($datas['pph21']) }}</span>
                        </div>

                    </div>

                    <div class="border-t dark:border-gray-700 pt-3 flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-100">
                            Total Bersih
                        </span>
                        <span class="text-lg font-bold text-blue-600">
                            Rp {{ number_format($datas['total']) }}
                        </span>
                    </div>

                </div>

            @endif

        </div>

        <!-- 🔻 Navbar kamu (TIDAK DIUBAH SAMA SEKALI, hanya ditambah dark mode) -->
        <div {{-- class="fixed bottom-0 left-0 right-0 z-50 
            bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-t border-gray-200 dark:border-gray-700"> --}}
            class="w-full max-w-[420px] mx-auto fixed bottom-0 left-0 right-0 z-50 
            bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-t border-gray-200 dark:border-gray-700">

            <div class="flex justify-between p-10 py-2 text-xs">

                <a href="{{ route('presensi') }}"
                    class="flex flex-col items-center gap-1 transition active:scale-95
                    {{ request()->routeIs('presensi') ? 'text-blue-600' : 'text-gray-400 dark:text-gray-500' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 6.75h15a1.5 1.5 0 011.5 1.5v10.5A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75V8.25a1.5 1.5 0 011.5-1.5z" />
                    </svg>

                    <span>Presensi</span>
                </a>

                <a href="{{ route('slipgaji') }}"
                    class="flex flex-col items-center gap-1 transition active:scale-95
                    {{ request()->routeIs('slipgaji') ? 'text-blue-600' : 'text-gray-400 dark:text-gray-500' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H7.875A3.375 3.375 0 004.5 11.625v2.625m15 0v2.25a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 16.5v-2.25m15 0H4.5" />
                    </svg>

                    <span>Slip Gaji</span>
                </a>

                <button wire:click="logout"
                    class="flex flex-col items-center gap-1 text-gray-400 dark:text-gray-500 transition active:scale-95">

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
