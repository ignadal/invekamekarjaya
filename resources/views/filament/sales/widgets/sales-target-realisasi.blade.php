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
        <h3 class="target-header">Target vs Realisasi (Bulan Ini)</h3>

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
