<x-filament-widgets::widget>
    <style>
        .target-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .target-header {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 1.25rem 0;
        }
        .target-values {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }
        .target-label {
            font-size: 0.75rem;
            color: #9ca3af;
            margin: 0 0 0.25rem 0;
        }
        .target-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .target-amount-right {
            font-size: 1.25rem;
            font-weight: 700;
            color: #dc2626;
            margin: 0;
            text-align: right;
        }
        .target-percentage-badge {
            font-size: 0.75rem;
            color: #9ca3af;
            font-weight: 400;
        }
        .target-progress-bar {
            width: 100%;
            height: 0.625rem;
            background: #f3f4f6;
            border-radius: 9999px;
            overflow: hidden;
            margin-bottom: 0.375rem;
        }
        .target-progress-fill {
            height: 100%;
            background: #2563eb;
            border-radius: 9999px;
            transition: width 0.5s ease;
        }
        .target-progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.6875rem;
            color: #9ca3af;
            margin-bottom: 1.25rem;
        }
        .target-motivation {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-top: auto;
        }
        .target-motivation-icon {
            width: 1.75rem;
            height: 1.75rem;
            flex-shrink: 0;
        }
        .target-motivation-title {
            font-size: 0.8125rem;
            font-weight: 700;
            color: #dc2626;
            margin: 0;
        }
        .target-motivation-desc {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0.125rem 0 0 0;
            line-height: 1.4;
        }
    </style>

    @php
        $data = $this->target_realisasi;
        $motivationText = $data['percentage'] >= 100
            ? 'Target tercapai! Kerja yang luar biasa!'
            : ($data['percentage'] >= 75
                ? 'Hampir mencapai target! Sedikit lagi!'
                : 'Terus tingkatkan performa!');
    @endphp

    <div class="target-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin: 0 0 1.25rem 0;">
            <h3 class="target-header" style="margin: 0;">Target vs Realisasi (Bulan Ini)</h3>
            <div x-data="{ open: false }" style="position: relative; display: inline-flex; align-items: center;">
                <button type="button" @click.stop="open = !open" style="outline: none; background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af" style="width: 1.25rem; height: 1.25rem;">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; z-index: 9999; width: 220px; background-color: #1f2937; color: #f9fafb; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: normal; line-height: 1.4; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); top: 125%; right: 0; white-space: normal;">
                    <div style="position: absolute; top: -5px; right: 8px; width: 10px; height: 10px; background-color: #1f2937; transform: rotate(45deg);"></div>
                    Grafik ini menunjukkan sejauh mana Anda mencapai target bulanan (Rp 100 Juta) untuk mendapatkan bonus/komisi.
                </div>
            </div>
        </div>

        <div class="target-values">
            <div>
                <p class="target-label">Target Tagihan</p>
                <p class="target-amount">Rp {{ number_format($data['target'], 0, ',', '.') }}</p>
            </div>
            <div style="text-align: right;">
                <p class="target-label">Realisasi</p>
                <p class="target-amount-right">Rp {{ number_format($data['realisasi'], 0, ',', '.') }} <span class="target-percentage-badge">({{ $data['percentage'] }}%)</span></p>
            </div>
        </div>

        <div class="target-progress-bar">
            <div class="target-progress-fill" style="width: {{ $data['percentage'] }}%;"></div>
        </div>
        <div class="target-progress-labels">
            <span>{{ $data['percentage'] }}%</span>
            <span>100%</span>
        </div>

        <div class="target-motivation">
            <svg class="target-motivation-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="#ef4444" stroke-width="1.5"/>
                <path d="M8 12l2.5 2.5L16 9" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div>
                <p class="target-motivation-title">{{ $motivationText }}</p>
                <p class="target-motivation-desc">Anda telah mencapai {{ $data['percentage'] }}% dari target bulan ini.</p>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
