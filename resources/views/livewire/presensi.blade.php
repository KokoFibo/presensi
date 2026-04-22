<div>
    <x-layouts.app>

        <!-- CONTENT -->
        <div class="w-full max-w-[420px] mx-auto p-4 space-y-4">

            <!-- Header -->
            <h1>
                <div class="text-xl font-bold text-gray-800 dark:text-gray-600">
                    Presensi {{ $month_year }}
                </div>
                <div class="text-gray-800 dark:text-gray-600">
                    {{ auth()->user()->name }} / {{ auth()->user()->id_karyawan }}
                    {{ auth()->user()->outsource ? '' : ' / Non-OS' }}
                </div>
            </h1>

            <!-- Dropdown -->
            <select wire:model.live="selectedMonth"
                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 dark:text-gray-100 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500">

                @foreach ($available_months as $key => $value)
                    <option value="{{ $key }}">{{ $value['month_year'] }}</option>
                @endforeach
            </select>

            <!-- Summary -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700 shadow p-3">

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

            <!-- List Data -->
            @foreach ($datas as $value)
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow border border-gray-100 dark:border-gray-700 p-4 space-y-4">

                    <!-- Tanggal -->
                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                        {{ tgl_indo($value['date']) }}
                    </div>

                    <!-- Grid 3 Kolom -->
                    <div class="grid grid-cols-3 gap-2">

                        <!-- Jam Kerja -->
                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2 text-center border border-blue-100 dark:border-blue-800">
                            <div class="flex justify-center mb-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7.5l9-4.5 9 4.5M4.5 9.75v6.75A2.25 2.25 0 006.75 18.75h10.5A2.25 2.25 0 0019.5 16.5V9.75M9 12h6" />
                                </svg>
                            </div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 leading-tight">Jam Kerja</div>
                            <div class="font-semibold text-[12px] text-gray-800 dark:text-gray-100">
                                {{ $value['total_jam_kerja'] + $value['total_jam_kerja_libur'] }}
                            </div>
                        </div>

                        <!-- Lembur -->
                        <div
                            class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-2 text-center border border-orange-100 dark:border-orange-800">
                            <div class="flex justify-center mb-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-orange-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 leading-tight">Lembur</div>
                            <div class="font-semibold text-[12px] text-orange-600">
                                {{ $value['total_jam_lembur'] + $value['total_jam_lembur_libur'] }}
                            </div>
                        </div>

                        <!-- Shift Malam -->
                        <div
                            class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-2 text-center border border-purple-100 dark:border-purple-800">
                            <div class="flex justify-center mb-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-purple-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 15.002A9.718 9.718 0 0112 21a9.75 9.75 0 01-9.75-9.75c0-3.55 1.896-6.66 4.748-8.385a.75.75 0 01.98.98A7.5 7.5 0 0019.5 12c0 .686-.092 1.35-.264 1.998a.75.75 0 01.98.98z" />
                                    </path>
                                </svg>
                            </div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 leading-tight">Shift Malam</div>
                            <div
                                class="font-semibold text-[12px] {{ $value['shift_malam'] ? 'text-purple-600' : 'text-gray-400 dark:text-gray-500' }}">
                                {{ $value['shift_malam'] ? '✓' : '' }}
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        <!-- Spacer -->
        <div class="h-20"></div>

        <!-- Bottom Navbar -->
        <div {{-- class="fixed bottom-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-t border-gray-200 dark:border-gray-700"> --}}
            class="w-full max-w-[420px] mx-auto fixed bottom-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-t border-gray-200 dark:border-gray-700">

            <div class="flex justify-between p-10 py-2 text-xs">

                <!-- Presensi -->
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

                <!-- Slip Gaji -->

                @if (($is_slipgaji && !$is_locked && auth()->user()->outsource == 0) || auth()->user()->id_karyawan == 80000)
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
                @endif

                <!-- Logout -->
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
