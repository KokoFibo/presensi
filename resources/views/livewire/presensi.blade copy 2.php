<div>
    <x-layouts.app>
        <div class="p-4 space-y-4">

            <!-- Header -->
            <h1 class="text-xl font-bold text-gray-800">
                Presensi {{ $month_year }}
            </h1>

            <!-- Dropdown -->
            <select wire:model.live="selectedMonth"
                class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500">
                @foreach ($available_months as $key => $value)
                    <option value="{{ $key }}">{{ $value['month_year'] }}</option>
                @endforeach
            </select>

            <!-- List -->
            @foreach ($datas as $value)
                <div class="bg-white rounded-2xl shadow border border-gray-100 p-4 space-y-4">

                    <!-- Tanggal -->
                    <div class="font-semibold text-gray-800">
                        {{ $value['date'] }}
                    </div>

                    <!-- 3 Kolom -->
                    <div class="grid grid-cols-3 gap-3">

                        <!-- Work Hours -->
                        <div class="bg-blue-50 rounded-xl p-3 text-center border border-blue-100">
                            <div class="text-blue-500 text-xl">👜</div>
                            <div class="text-xs text-gray-500">Work Hours</div>
                            <div class="font-bold text-gray-800">
                                {{ $value['total_jam_kerja'] }}h
                            </div>
                        </div>

                        <!-- Overtime -->
                        <div class="bg-orange-50 rounded-xl p-3 text-center border border-orange-100">
                            <div class="text-orange-500 text-xl">⏱</div>
                            <div class="text-xs text-gray-500">Overtime</div>
                            <div class="font-bold text-orange-600">
                                {{ $value['total_jam_lembur'] }}h
                            </div>
                        </div>

                        <!-- Night Shift -->
                        <div class="bg-purple-50 rounded-xl p-3 text-center border border-purple-100">
                            <div class="text-purple-500 text-xl">🌙</div>
                            <div class="text-xs text-gray-500">Night Shift</div>
                            <div
                                class="font-bold 
                                {{ $value['shift_malam'] ? 'text-purple-600' : 'text-gray-400' }}">
                                {{ $value['shift_malam'] ? 'Ya' : '0h' }}
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </x-layouts.app>
</div>
