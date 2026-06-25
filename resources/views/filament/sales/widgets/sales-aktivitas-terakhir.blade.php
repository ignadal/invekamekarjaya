<x-filament-widgets::widget>
    <x-filament::card>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-red-600 dark:text-red-400">Aktivitas Terakhir</h2>
            <a href="#" class="text-sm font-medium text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">Lihat Semua</a>
        </div>
        
        <div class="space-y-4">
            @forelse($this->activities as $activity)
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900">
                            @svg($activity['icon'], 'w-5 h-5 text-' . $activity['color'] . '-600 dark:text-' . $activity['color'] . '-400')
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $activity['title'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['date']->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    @if($activity['amount'])
                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ $activity['amount'] }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    Belum ada aktivitas
                </div>
            @endforelse
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
