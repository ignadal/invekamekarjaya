<x-filament-widgets::widget>
    <x-filament::card>
        <div class="mb-4">
            <h2 class="text-lg font-bold text-red-600 dark:text-red-400">Target vs Realisasi (Bulan Ini)</h2>
        </div>
        
        @php
            $data = $this->target_realisasi;
        @endphp

        <div class="space-y-4">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Target Tagihan</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($data['target'], 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Realisasi</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($data['realisasi'], 0, ',', '.') }} <span class="text-sm text-gray-500 font-normal">({{ $data['percentage'] }}%)</span></p>
                </div>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700 mt-2">
                <div class="bg-red-600 h-3 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
            </div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
