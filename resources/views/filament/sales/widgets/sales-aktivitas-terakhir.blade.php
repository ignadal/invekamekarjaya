<x-filament-widgets::widget>
    <style>
        .aktivitas-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .aktivitas-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .aktivitas-title {
            font-size: 1rem;
            font-weight: 700;
            color: #dc2626;
            margin: 0;
        }
        .aktivitas-btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #374151;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            text-decoration: none;
            cursor: pointer;
        }
        .aktivitas-btn:hover { background: #f9fafb; }
        .aktivitas-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .aktivitas-item:last-child { border-bottom: none; }
        .aktivitas-icon {
            width: 2.25rem;
            height: 2.25rem;
            background: #fef2f2;
            border-radius: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .aktivitas-icon svg {
            width: 1.125rem;
            height: 1.125rem;
            color: #ef4444;
        }
        .aktivitas-info { flex: 1; min-width: 0; }
        .aktivitas-info-title {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
            line-height: 1.3;
        }
        .aktivitas-info-date {
            font-size: 0.6875rem;
            color: #9ca3af;
            margin: 0;
        }
        .aktivitas-amount {
            font-size: 0.8125rem;
            font-weight: 700;
            color: #111827;
            white-space: nowrap;
        }
        .aktivitas-arrow {
            color: #d1d5db;
            flex-shrink: 0;
        }
        .aktivitas-footer {
            margin-top: auto;
            padding-top: 0.75rem;
            border-top: 1px solid #f3f4f6;
            text-align: center;
        }
        .aktivitas-footer a {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            color: #dc2626;
            font-size: 0.8125rem;
            font-weight: 600;
            text-decoration: none;
        }
        .aktivitas-footer a:hover { text-decoration: underline; }
        .aktivitas-empty {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            color: #9ca3af;
            font-size: 0.875rem;
        }
    </style>

    <div class="aktivitas-card">
        <div class="aktivitas-header">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <h3 class="aktivitas-title">Aktivitas Terakhir</h3>
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
            <button class="aktivitas-btn">Lihat semua</button>
        </div>

        @forelse($this->activities as $activity)
            <div class="aktivitas-item">
                <div class="aktivitas-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </div>
                <div class="aktivitas-info">
                    <p class="aktivitas-info-title">{{ $activity['title'] }}</p>
                    <p class="aktivitas-info-date">{{ $activity['date']->translatedFormat('d F Y') }}</p>
                </div>
                @if($activity['amount'])
                    <span class="aktivitas-amount">{{ $activity['amount'] }}</span>
                @endif
                <span class="aktivitas-arrow">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg>
                </span>
            </div>
        @empty
            <div class="aktivitas-empty">
                Belum ada aktivitas
            </div>
        @endforelse

        @if(count($this->activities) > 0)
            <div class="aktivitas-footer">
                <a href="#">
                    Lihat semua aktivitas
                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg>
                </a>
            </div>
        @endif
    </div>
</x-filament-widgets::widget>
