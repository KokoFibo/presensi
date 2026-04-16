<div>
    <x-layouts.app>
        <div class="p-4 space-y-4">

            <!-- Header -->
            <h1 class="text-xl font-bold text-gray-800">
                Presensi {{ $month_year }}
            </h1>

            <select name="" id="" wire:model.live="selectedMonth"
                class="border border-gray-300 rounded px-3 py-2">
                @foreach ($available_months as $key => $value)
                    <option value="{{ $key }}">{{ $value['month_year'] }}</option>
                @endforeach
            </select>

            <!-- List Data -->
            @foreach ($datas as $key => $value)
                <div class="bg-white rounded-2xl shadow p-4 space-y-2 border border-gray-100">

                    <!-- Tanggal -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Tanggal</span>
                        <span class="font-semibold text-gray-800">
                            {{ $value['date'] }}
                        </span>
                    </div>

                    <!-- Jam Kerja -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Jam Kerja</span>
                        <span class="font-medium text-blue-600">
                            {{ $value['total_jam_kerja'] }} jam
                        </span>
                    </div>

                    <!-- Lembur -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Lembur</span>
                        <span class="font-medium text-green-600">
                            {{ $value['total_jam_lembur'] }} jam
                        </span>
                    </div>

                    <!-- Shift Malam -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Shift Malam</span>
                        <span
                            class="font-medium 
                            {{ $value['shift_malam'] ? 'text-purple-600' : 'text-gray-400' }}">

                            {{ $value['shift_malam'] ? 'Ya 🌙' : 'Tidak' }}
                        </span>
                    </div>

                </div>
            @endforeach

        </div>
    </x-layouts.app>
</div>
