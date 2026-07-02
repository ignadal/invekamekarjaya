<x-filament-widgets::widget>
    <style>
        .filter-widget-card {
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 50%, #b91c1c 100%);
            border-radius: 0.75rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            color: white;
        }
        
        /* Animated wave CSS */
        .parallax-dashboard > use {
            animation: move-forever-dashboard 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        @keyframes move-forever-dashboard {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }
        .parallax-dashboard > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; fill: rgba(127, 29, 29, 0.3); }
        .parallax-dashboard > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; fill: rgba(127, 29, 29, 0.5); }
        .parallax-dashboard > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; fill: rgba(127, 29, 29, 0.7); }
        .parallax-dashboard > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; fill: rgba(127, 29, 29, 0.9); }

        .filter-content-wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .filter-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .filter-icon-circle {
            width: 3.5rem;
            height: 3.5rem;
            background-color: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .filter-icon-circle svg {
            width: 1.5rem;
            height: 1.5rem;
            color: white;
            stroke-width: 1.5;
        }

        .filter-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
            color: white;
        }

        .filter-subtitle {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        .filter-controls-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: flex-end;
        }

        @media (max-width: 768px) {
            .filter-controls-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .filter-title {
                font-size: 1rem;
            }
            .filter-subtitle {
                font-size: 0.75rem;
            }
            .filter-icon-circle {
                width: 3rem;
                height: 3rem;
            }
            .filter-icon-circle svg {
                width: 1.25rem;
                height: 1.25rem;
            }
            .filter-header {
                gap: 0.75rem;
            }
        }

        .filter-input-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
        }

        .filter-select-wrapper {
            position: relative;
            background: white;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            padding: 0 0.75rem;
            height: 2.75rem;
        }

        .filter-select-icon {
            color: #ef4444; /* red icon */
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }

        .filter-select {
            appearance: none;
            background: transparent;
            border: none;
            width: 100%;
            height: 100%;
            padding: 0 2rem 0 0.75rem;
            color: #111827;
            font-size: 0.875rem;
            font-weight: 500;
            outline: none;
            cursor: pointer;
        }

        .filter-select-chevron {
            position: absolute;
            right: 0.75rem;
            pointer-events: none;
            color: #6b7280;
            width: 1.25rem;
            height: 1.25rem;
        }

        .filter-reset-btn {
            background-color: #1f2937; /* dark gray */
            color: white;
            border: none;
            border-radius: 0.5rem;
            height: 2.75rem;
            padding: 0 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .filter-reset-btn:hover {
            background-color: #111827;
        }
        .filter-reset-btn svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        /* Dark mode overrides if necessary */
        html.dark .filter-widget-card {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #7f1d1d 100%);
        }
        html.dark .filter-select-wrapper {
            background: #18181b;
            border: 1px solid #3f3f46;
        }
        html.dark .filter-select {
            color: #f4f4f5;
        }
        html.dark .filter-select-chevron {
            color: #a1a1aa;
        }
        html.dark .filter-reset-btn {
            background-color: #27272a;
            border: 1px solid #3f3f46;
            color: #f4f4f5;
        }
        html.dark .filter-reset-btn:hover {
            background-color: #3f3f46;
        }
    </style>

    <div class="filter-widget-card">
        <!-- Animated Wave Background (Top) -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; line-height: 0; z-index: 0; pointer-events: none; transform: scaleY(-1);">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto" style="position: relative; width: 100%; height: 60px; margin-top: -7px; min-height: 60px; max-height: 80px;">
                <defs>
                    <path id="gentle-wave-dashboard" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax-dashboard">
                    <use xlink:href="#gentle-wave-dashboard" x="48" y="0" />
                    <use xlink:href="#gentle-wave-dashboard" x="48" y="3" />
                    <use xlink:href="#gentle-wave-dashboard" x="48" y="5" />
                    <use xlink:href="#gentle-wave-dashboard" x="48" y="7" />
                </g>
            </svg>
        </div>

        <div class="filter-content-wrapper">
            <!-- Header Section -->
            <div class="filter-header">
                <div class="filter-icon-circle">
                    <!-- Funnel Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="filter-title">Selamat datang kembali, {{ auth()->user()->name ?? 'Sales' }}!</h2>
                    <p class="filter-subtitle">Gunakan filter di bawah untuk menampilkan data dashboard sesuai periode yang Anda pilih.</p>
                </div>
            </div>

            <!-- Controls Section -->
            <div class="filter-controls-grid">
                
                <div class="filter-input-group">
                    <label class="filter-label">Pilih Bulan</label>
                    <div class="filter-select-wrapper">
                        <!-- Red Calendar Icon -->
                        <svg class="filter-select-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        
                        <select wire:model.live="bulan" class="filter-select">
                            <option value="">Semua Bulan</option>
                            @foreach($this->getBulanOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        
                        <!-- Chevron Icon -->
                        <svg class="filter-select-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <div class="filter-input-group">
                    <label class="filter-label">Pilih Tahun</label>
                    <div class="filter-select-wrapper">
                        <!-- Red Calendar Icon -->
                        <svg class="filter-select-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        
                        <select wire:model.live="tahun" class="filter-select">
                            <option value="">Semua Tahun</option>
                            @foreach($this->getTahunOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        <!-- Chevron Icon -->
                        <svg class="filter-select-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <div>
                    <button type="button" wire:click="resetFilter" class="filter-reset-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Reset
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-filament-widgets::widget>
