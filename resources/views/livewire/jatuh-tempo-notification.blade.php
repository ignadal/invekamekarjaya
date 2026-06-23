<div>
    <style>
        .jt-title { font-size: 0.75rem; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        html.dark .jt-title { color: #9ca3af; }
        
        .jt-name { font-size: 1.5rem; font-weight: 900; color: #111827; margin-bottom: 1.5rem; line-height: 1.2; }
        html.dark .jt-name { color: #f9fafb; }
        
        .jt-card { border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.25rem; margin-bottom: 1.5rem; width: 100%; background-color: #f9fafb; }
        html.dark .jt-card { border-color: #374151; background-color: #1f2937; }
        
        .jt-card-label { font-size: 0.75rem; font-weight: bold; color: #6b7280; text-transform: uppercase; margin-bottom: 0.25rem; }
        html.dark .jt-card-label { color: #9ca3af; }
        
        .jt-card-info-label { font-size: 0.75rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem; }
        html.dark .jt-card-info-label { color: #9ca3af; }
        
        .jt-card-info-val { font-size: 0.875rem; font-weight: bold; color: #1f2937; }
        html.dark .jt-card-info-val { color: #f3f4f6; }
        
        .jt-card-divider { border-top: 1px solid #e5e7eb; padding-top: 0.75rem; }
        html.dark .jt-card-divider { border-color: #374151; }
        
        .jt-footer-divider { border-top: 1px solid #e5e7eb; padding-top: 1rem; }
        html.dark .jt-footer-divider { border-color: #374151; }
        
        .jt-footer-text { font-size: 0.75rem; font-weight: 800; color: #6b7280; letter-spacing: 0.05em; }
        html.dark .jt-footer-text { color: #9ca3af; }
    </style>

    <x-filament::modal id="jatuh-tempo-modal" width="sm">
        <x-slot name="heading">
            <div style="text-align: center; width: 100%; font-weight: bold; font-size: 1.125rem;">
                Pemberitahuan Penting
            </div>
        </x-slot>

        @if(count($allNotifications) > 0)
            @php
                $notif = $allNotifications[$currentIndex];
                $color = $notif['color'];
            @endphp

            <div style="display: flex; flex-direction: column; align-items: center; text-align: center; width: 100%; padding-top: 0.5rem;">
                
                <div class="jt-title">
                    {{ $notif['title'] }}
                </div>
                
                <h2 class="jt-name">
                    {{ $notif['name'] }}
                </h2>
                
                <div class="jt-card">
                    <p class="jt-card-label">{{ $notif['amount_label'] }}</p>
                    <p style="font-size: 1.875rem; font-weight: 800; margin-bottom: 1rem; color: {{ $color === 'warning' ? '#d97706' : '#dc2626' }};">
                        Rp {{ number_format($notif['amount'], 0, ',', '.') }}
                    </p>

                    <div class="jt-card-divider">
                        <p class="jt-card-info-label">Keterangan:</p>
                        <p class="jt-card-info-val">{{ $notif['info'] }}</p>
                    </div>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 0.75rem; width: 100%; margin-bottom: 1.5rem;">
                    <x-filament::button tag="a" href="{{ $notif['url'] }}" color="{{ $color }}" style="width: 100%; justify-content: center;" size="lg">
                        Proses Sekarang
                    </x-filament::button>
                    
                    <x-filament::button wire:click="closeModal" color="gray" outlined style="width: 100%; justify-content: center;" size="lg">
                        Tutup & Ingatkan Nanti
                    </x-filament::button>
                </div>

                @if(count($allNotifications) > 1)
                <div class="jt-footer-divider" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                    <x-filament::button wire:click="prev" color="gray" size="sm" outlined :disabled="$currentIndex === 0" style="width: 6rem; justify-content: center;">
                        &laquo; Prev
                    </x-filament::button>
                    
                    <div class="jt-footer-text">
                        {{ $currentIndex + 1 }} / {{ count($allNotifications) }}
                    </div>
                    
                    <x-filament::button wire:click="next" color="gray" size="sm" outlined :disabled="$currentIndex === count($allNotifications) - 1" style="width: 6rem; justify-content: center;">
                        Next &raquo;
                    </x-filament::button>
                </div>
                @endif
            </div>
        @else
            <div style="padding: 1rem; text-align: center; color: #6b7280;">
                Tidak ada notifikasi saat ini.
            </div>
        @endif
    </x-filament::modal>

    @if($isOpen)
        <script>
            document.addEventListener('livewire:initialized', () => {
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: 'jatuh-tempo-modal' } }));
                }, 500);
            });
        </script>
    @endif
</div>
