<div>
    <x-layouts.app>
        @if ($is_filled != true)

            <div x-data="{ showConfirm: false }" class="w-full max-w-2xl mx-auto">

                {{-- ========================= --}}
                {{-- FORM CARD --}}
                {{-- ========================= --}}

                <div
                    class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-gray-800">

                    {{-- Header --}}
                    <div
                        class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 px-6 py-7">

                        {{-- Background Decoration --}}
                        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                        <div class="absolute -bottom-12 -left-8 h-36 w-36 rounded-full bg-white/5"></div>

                        <div class="relative flex items-center gap-4">

                            {{-- Icon --}}
                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">

                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5 12v4.5c0 1.5 3.13 3.5 7 3.5s7-2 7-3.5V12" />

                                </svg>

                            </div>

                            <div>
                                <h2 class="text-xl font-bold tracking-tight text-white">
                                    Lengkapi Pendidikan
                                </h2>

                                <p class="mt-1 text-sm text-blue-100">
                                    Data pendidikan Anda belum lengkap
                                </p>
                            </div>

                        </div>
                    </div>


                    {{-- Content --}}
                    <div class="px-6 py-6">

                        {{-- Information Alert --}}
                        <div
                            class="mb-6 flex gap-3 rounded-xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900/50 dark:bg-blue-950/30">

                            <div class="mt-0.5 shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />

                                </svg>

                            </div>

                            <p class="text-sm leading-relaxed text-blue-800 dark:text-blue-200">
                                Silakan lengkapi data pendidikan Anda sebelum mengakses fitur ini.
                            </p>

                        </div>


                        {{-- ========================= --}}
                        {{-- FORM --}}
                        {{-- ========================= --}}

                        <form class="space-y-5 text-left">

                            {{-- Pendidikan --}}
                            <div>

                                <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Pendidikan Terakhir
                                    <span class="ml-1 text-red-500">*</span>
                                </label>

                                <div class="relative">

                                    <select wire:model.live="pendidikan"
                                        class="w-full appearance-none rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 pr-10 text-sm text-gray-900 outline-none transition
                                focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10
                                dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-500 dark:focus:bg-gray-800">

                                        <option value="">-- Pilih Pendidikan --</option>
                                        <option value="Tidak Bersekolah">Tidak Bersekolah</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA/SMK">SMA/SMK</option>
                                        <option value="D1">D1</option>
                                        <option value="D2">D2</option>
                                        <option value="D3">D3</option>
                                        <option value="D4">D4</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>

                                    </select>

                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />

                                        </svg>

                                    </div>

                                </div>

                                @error('pendidikan')
                                    <span class="mt-1.5 block text-xs font-medium text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Detail Pendidikan --}}
                            @if ($this->butuhDetailPendidikan)
                                {{-- Jurusan --}}
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Jurusan
                                    </label>

                                    <input type="text" wire:model.live="jurusan"
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition
                                placeholder:text-gray-400
                                focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10
                                dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder:text-gray-500 dark:focus:border-blue-500 dark:focus:bg-gray-800"
                                        placeholder="Contoh: Teknik Informatika">

                                </div>


                                {{-- Nama Kampus --}}
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Nama Sekolah/Kampus
                                    </label>

                                    <input type="text" wire:model.live="nama_kampus"
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition
                                placeholder:text-gray-400
                                focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10
                                dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder:text-gray-500 dark:focus:border-blue-500 dark:focus:bg-gray-800"
                                        placeholder="Contoh: Universitas Indonesia">

                                </div>
                            @endif


                            {{-- ========================= --}}
                            {{-- BUTTON SIMPAN --}}
                            {{-- ========================= --}}

                            <button type="button" @click="showConfirm = true"
                                class="group mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition-all duration-200
                        hover:-translate-y-0.5 hover:from-blue-700 hover:to-indigo-700 hover:shadow-xl hover:shadow-blue-500/25
                        focus:outline-none focus:ring-4 focus:ring-blue-500/20">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 transition-transform group-hover:scale-110" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />

                                </svg>

                                Simpan Data Pendidikan

                            </button>


                            {{-- Required Info --}}
                            <p class="text-center text-xs text-gray-400 dark:text-gray-500">
                                <span class="text-red-500">*</span>
                                Wajib diisi
                            </p>

                        </form>

                    </div>
                </div>


                {{-- ================================================= --}}
                {{-- CUSTOM CONFIRMATION --}}
                {{-- ================================================= --}}

                <div x-show="showConfirm" x-cloak x-transition.opacity.duration.200ms
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm">

                    {{-- Dialog --}}
                    <div x-show="showConfirm" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                        @click.outside="showConfirm = false"
                        class="w-full max-w-sm overflow-hidden rounded-3xl bg-white shadow-2xl dark:bg-gray-900">

                        {{-- Top --}}
                        <div class="px-6 pt-7 text-center">

                            {{-- Confirmation Icon --}}
                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">

                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-600 shadow-lg shadow-blue-500/30">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                    </svg>

                                </div>

                            </div>


                            <h3 class="mt-5 text-xl font-bold text-gray-900 dark:text-white">
                                Simpan Data Pendidikan?
                            </h3>

                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                                Pastikan data pendidikan yang Anda masukkan sudah benar sebelum disimpan.
                            </p>

                        </div>


                        {{-- Data Preview --}}
                        <div
                            class="mx-6 mt-5 rounded-2xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/70">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    Pendidikan
                                </span>

                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $pendidikan ?: '-' }}
                                </span>

                            </div>

                            @if ($this->butuhDetailPendidikan)
                                <div class="my-3 border-t border-gray-200 dark:border-gray-700"></div>

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Jurusan
                                    </span>

                                    <span
                                        class="max-w-[60%] text-right text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $jurusan ?: '-' }}
                                    </span>

                                </div>

                                <div class="my-3 border-t border-gray-200 dark:border-gray-700"></div>

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Sekolah/Kampus
                                    </span>

                                    <span
                                        class="max-w-[60%] text-right text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $nama_kampus ?: '-' }}
                                    </span>

                                </div>
                            @endif

                        </div>


                        {{-- Buttons --}}
                        <div class="flex gap-3 px-6 pb-6 pt-5">

                            {{-- Batal --}}
                            <button type="button" @click="showConfirm = false"
                                class="flex-1 rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition
                        hover:bg-gray-50
                        focus:outline-none focus:ring-4 focus:ring-gray-100
                        dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                Batal
                            </button>


                            {{-- Konfirmasi --}}
                            <button type="button" wire:click="simpanPendidikan" wire:loading.attr="disabled"
                                wire:target="simpanPendidikan" @click="showConfirm = false"
                                class="flex-1 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition
                        hover:from-blue-700 hover:to-indigo-700
                        focus:outline-none focus:ring-4 focus:ring-blue-500/20
                        disabled:cursor-not-allowed disabled:opacity-50">

                                <span wire:loading.remove wire:target="simpanPendidikan">
                                    Ya, Simpan
                                </span>

                                <span wire:loading wire:target="simpanPendidikan"
                                    class="flex items-center justify-center gap-2">

                                    <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">

                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4">
                                        </circle>

                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                        </path>

                                    </svg>

                                    Menyimpan...

                                </span>

                            </button>

                        </div>

                    </div>
                </div>

            </div>
        @else
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
                                <div class="text-[10px] text-gray-500 dark:text-gray-400 leading-tight">Shift Malam
                                </div>
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

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
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

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H7.875A3.375 3.375 0 004.5 11.625v2.625m15 0v2.25a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 16.5v-2.25m15 0H4.5" />
                            </svg>

                            <span>Slip Gaji</span>
                        </a>
                    @endif

                    <!-- Logout -->
                    <button wire:click="logout"
                        class="flex flex-col items-center gap-1 text-gray-400 dark:text-gray-500 transition active:scale-95">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3-3l-3-3m0 0l-3 3m3-3v12" />
                        </svg>

                        <span>Logout</span>
                    </button>

                </div>
            </div>
        @endif
    </x-layouts.app>
</div>
