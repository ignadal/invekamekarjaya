<x-filament-widgets::widget>
    <style>
        .piutang-card {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        .piutang-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .piutang-title-area {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .piutang-main-icon {
            background: #fef2f2;
            color: #ef4444;
            padding: 0.75rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .piutang-main-icon svg {
            width: 1.75rem;
            height: 1.75rem;
        }

        .piutang-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 0.25rem 0;
        }

        .piutang-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }

        .piutang-info-btn {
            color: #9ca3af;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            outline: none;
        }
        .piutang-info-btn:hover {
            color: #6b7280;
        }
        .piutang-info-btn svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        /* Doughnut Chart CSS */
        .piutang-chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
            flex: 1;
        }

        .piutang-doughnut {
            position: relative;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: conic-gradient(#111827  0% {{ $belumLunasPct }}%, #ef4444 {{ $belumLunasPct }}% 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* White separator line at 12 o'clock */
        .piutang-separator {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 20%; /* Exactly matches the 20% ring thickness (100% outer - 60% hole = 40% / 2 = 20%) */
            background: #fff;
            z-index: 5;
        }

        .piutang-hole {
            width: 60%;
            height: 60%;
            background: #fff;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            text-align: center;
        }

        .piutang-hole-icon {
            background: #fef2f2;
            color: #ef4444;
            padding: 0.5rem;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
        }
        .piutang-hole-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .piutang-hole-label-top {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0 0 0.25rem 0;
        }

        .piutang-hole-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111827;
            margin: 0 0 0.25rem 0;
        }

        .piutang-hole-label-bottom {
            font-size: 0.75rem;
            color: #9ca3af;
            margin: 0;
        }

        /* Legend CSS */
        .piutang-legend {
            background: #fdfdfd;
            border: 1px solid #f3f4f6;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            padding: 1rem;
        }

        .piutang-legend-item {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .piutang-legend-divider {
            width: 1px;
            height: 2rem;
            background: #e5e7eb;
        }

        .legend-dot {
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
        }
        .legend-dot.black { background: #111827; }
        .legend-dot.red { background: #ef4444; }

        .legend-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .legend-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #4b5563;
        }
        .legend-value {
            font-size: 0.875rem;
            font-weight: 700;
        }
        .legend-value.black { color: #111827; }
        .legend-value.red { color: #ef4444; }
        
        /* Mobile responsive adjustments */
        @media (max-width: 640px) {
            .piutang-doughnut {
                width: 220px;
                height: 220px;
            }
        }

        html.dark .piutang-card { background: #18181b; border-color: #3f3f46; }
        html.dark .piutang-title { color: #f4f4f5; }
        html.dark .piutang-hole { background: #18181b; }
        html.dark .piutang-separator { background: #18181b; }
        html.dark .piutang-legend { background: #27272a; border-color: #3f3f46; }
        html.dark .piutang-legend-divider { background: #3f3f46; }
        html.dark .legend-label { color: #a1a1aa; }
        html.dark .piutang-main-icon { background: #450a0a; color: #f87171; }
        html.dark .piutang-hole-value { color: #f4f4f5; }
        html.dark .piutang-hole-icon { background: #450a0a; color: #f87171; }
    </style>

    <div class="piutang-card">
        <!-- Header -->
        <div class="piutang-header">
            <div class="piutang-title-area">
                <div class="piutang-main-icon">
                    <!-- Pie chart icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h2 class="piutang-title">Rasio Status Piutang</h2>
                    <p class="piutang-subtitle">{{ $periodeLabel }}</p>
                </div>
            </div>
            
            <div x-data="{ open: false }" style="position: relative;">
                <button type="button" @click="open = !open" class="piutang-info-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; z-index: 50; width: 220px; background-color: #1f2937; color: #f9fafb; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; line-height: 1.4; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); top: 100%; right: 0;">
                    <div style="position: absolute; top: -4px; right: 8px; width: 8px; height: 8px; background-color: #1f2937; transform: rotate(45deg);"></div>
                    Melihat proporsi pesanan bulan ini yang sudah lunas berbanding yang masih belum dilunasi.
                </div>
            </div>
        </div>

        <!-- Doughnut Chart -->
        <div class="piutang-chart-container">
            <div class="piutang-doughnut">
                <div class="piutang-separator"></div>
                <div class="piutang-hole">
                </div>
            </div>
        </div>

        <!-- Legend -->
        <div class="piutang-legend">
            <div class="piutang-legend-item">
                <div class="legend-dot red"></div>
                <div class="legend-text">
                    <span class="legend-label">Lunas</span>
                    <span class="legend-value red">{{ $totalCount > 0 ? $lunasPct : 0 }}%</span>
                </div>
            </div>
            
            <div class="piutang-legend-divider"></div>
            
            <div class="piutang-legend-item">
                <div class="legend-dot black"></div>
                <div class="legend-text">
                    <span class="legend-label">Belum Lunas</span>
                    <span class="legend-value black">{{ $totalCount > 0 ? $belumLunasPct : 0 }}%</span>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
