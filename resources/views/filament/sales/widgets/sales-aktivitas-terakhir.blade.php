<x-filament-widgets::widget>
    <style>
        .aktivitas-card {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        
        .aktivitas-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .aktivitas-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }
        
        .aktivitas-list {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .aktivitas-list::before {
            content: '';
            position: absolute;
            top: 2rem;
            bottom: 2rem;
            left: 1.375rem;
            width: 1px;
            border-left: 1px dashed #e5e7eb;
            z-index: 0;
        }
        
        .aktivitas-item {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            z-index: 1;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .aktivitas-item:hover {
            opacity: 0.8;
        }
        
        .aktivitas-icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            z-index: 2;
        }
        
        .aktivitas-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }
        
        .aktivitas-content {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .aktivitas-item:last-child .aktivitas-content {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .aktivitas-info {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }
        
        .aktivitas-item-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        
        .aktivitas-item-date {
            font-size: 0.8125rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            margin: 0;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .aktivitas-item-date svg {
            width: 0.875rem;
            height: 0.875rem;
        }
        
        .aktivitas-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .aktivitas-amount {
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 700;
            white-space: nowrap;
        }
        
        .aktivitas-arrow-btn {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            background: #fff;
            flex-shrink: 0;
        }
        
        /* Variants */
        .variant-kunjungan .aktivitas-icon { background: #fef2f2; color: #ef4444; }
        .variant-kunjungan .aktivitas-arrow-btn { border-color: #fecaca; color: #ef4444; }
        
        .variant-penjualan .aktivitas-icon { background: #fef2f2; color: #ef4444; }
        .variant-penjualan .aktivitas-arrow-btn { border-color: #fecaca; color: #ef4444; }
        .variant-penjualan .aktivitas-amount { background: #fef2f2; color: #ef4444; }
        
        .variant-pembayaran .aktivitas-icon { background: #fef2f2; color: #ef4444; }
        .variant-pembayaran .aktivitas-arrow-btn { border-color: #fecaca; color: #ef4444; }
        .variant-pembayaran .aktivitas-amount { background: #fef2f2; color: #ef4444; }

        @media (max-width: 640px) {
            .aktivitas-card {
                padding: 1rem;
            }
            .aktivitas-item {
                gap: 0.75rem;
            }
            .aktivitas-icon {
                width: 2.25rem;
                height: 2.25rem;
            }
            .aktivitas-list::before {
                left: 1.125rem;
            }
            .aktivitas-right {
                gap: 0.5rem;
            }
            .aktivitas-arrow-btn {
                width: 1.5rem;
                height: 1.5rem;
            }
            .aktivitas-amount {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            .aktivitas-item-title {
                font-size: 0.875rem;
            }
        }

        html.dark .aktivitas-card { background: #18181b; border-color: #3f3f46; }
        html.dark .aktivitas-title { color: #f4f4f5; }
        html.dark .aktivitas-content { border-bottom-color: #3f3f46; }
        html.dark .aktivitas-item-title { color: #f4f4f5; }
        html.dark .aktivitas-list::before { border-left-color: #3f3f46; }
        html.dark .aktivitas-arrow-btn { background: transparent; }
        html.dark .variant-kunjungan .aktivitas-icon { background: #450a0a; color: #f87171; }
        html.dark .variant-kunjungan .aktivitas-arrow-btn { border-color: #7f1d1d; color: #f87171; }
        html.dark .variant-penjualan .aktivitas-icon { background: #450a0a; color: #f87171; }
        html.dark .variant-penjualan .aktivitas-arrow-btn { border-color: #7f1d1d; color: #f87171; }
        html.dark .variant-penjualan .aktivitas-amount { background: #450a0a; color: #f87171; }
        html.dark .variant-pembayaran .aktivitas-icon { background: #450a0a; color: #f87171; }
        html.dark .variant-pembayaran .aktivitas-arrow-btn { border-color: #7f1d1d; color: #f87171; }
        html.dark .variant-pembayaran .aktivitas-amount { background: #450a0a; color: #f87171; }
    </style>

    <div class="aktivitas-card">
        <div class="aktivitas-header">
            <div class="aktivitas-title">
                Aktivitas Terakhir
                <div x-data="{ open: false }" style="position: relative; display: inline-flex; align-items: center;">
                    <button type="button" @click.stop="open = !open" style="outline: none; background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af" style="width: 1.25rem; height: 1.25rem;">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; z-index: 9999; width: 220px; background-color: #1f2937; color: #f9fafb; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: normal; line-height: 1.4; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); top: 125%; left: 0; white-space: normal;">
                        <div style="position: absolute; top: -5px; left: 8px; width: 10px; height: 10px; background-color: #1f2937; transform: rotate(45deg);"></div>
                        Daftar riwayat aksi terbaru yang Anda lakukan, seperti kunjungan, order, dan pembayaran.
                    </div>
                </div>
            </div>
        </div>

        <div class="aktivitas-list">
            @forelse($this->activities as $activity)
                <a href="{{ $activity['url'] }}" class="aktivitas-item variant-{{ $activity['type'] }}">
                    <div class="aktivitas-icon">
                        @if($activity['type'] == 'kunjungan')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" /></svg>
                        @elseif($activity['type'] == 'penjualan')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" /><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" /></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" /><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.484-1.112 2.428 0 1.032.475 1.957 1.156 2.628a4.443 4.443 0 0 0 1.676.814v2.257c-.408-.096-.776-.275-1.077-.523a.75.75 0 0 0-.919 1.11 3.967 3.967 0 0 0 1.996.864V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.592 1.168-1.509 1.168-2.435 0-1.016-.456-1.93-1.115-2.583a4.159 4.159 0 0 0-1.874-.836V8.21c.465.114.89.314 1.25.596a.75.75 0 0 0 .93-1.166 3.921 3.921 0 0 0-2.18-.91V6Z" clip-rule="evenodd" /></svg>
                        @endif
                    </div>
                    
                    <div class="aktivitas-content">
                        <div class="aktivitas-info">
                            <p class="aktivitas-item-title">{{ $activity['title'] }}</p>
                            <p class="aktivitas-item-date">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                {{ $activity['date']->format('d F Y') }}
                            </p>
                        </div>
                        
                        <div class="aktivitas-right">
                            @if($activity['amount'])
                                <span class="aktivitas-amount">{{ $activity['amount'] }}</span>
                            @endif
                            <div class="aktivitas-arrow-btn">
                                <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div style="padding: 2rem; text-align: center; color: #9ca3af; font-size: 0.875rem;">
                    Belum ada aktivitas
                </div>
            @endforelse
        </div>
    </div>
</x-filament-widgets::widget>
