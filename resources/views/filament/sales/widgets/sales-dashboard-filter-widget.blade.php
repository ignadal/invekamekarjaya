<x-filament-widgets::widget>
    <style>
        .parallax-dashboard > use {
            animation: move-forever-dashboard 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        @keyframes move-forever-dashboard {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }
        .parallax-dashboard > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; fill: rgba(127, 29, 29, 0.3); } /* Tailwind red-900 */
        .parallax-dashboard > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; fill: rgba(127, 29, 29, 0.5); }
        .parallax-dashboard > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; fill: rgba(127, 29, 29, 0.7); }
        .parallax-dashboard > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; fill: #7f1d1d; }

        html.dark .parallax-dashboard > use:nth-child(1) { fill: rgba(69, 10, 10, 0.3); } /* Tailwind red-950 */
        html.dark .parallax-dashboard > use:nth-child(2) { fill: rgba(69, 10, 10, 0.5); }
        html.dark .parallax-dashboard > use:nth-child(3) { fill: rgba(69, 10, 10, 0.7); }
        html.dark .parallax-dashboard > use:nth-child(4) { fill: #450a0a; }

        .dashboard-filter-content {
            position: relative;
            z-index: 10;
        }

        /* Apply Red Gradient in Light Mode (Brighter Red) */
        html:not(.dark) .red-gradient-filter { 
            background: linear-gradient(to right, #991b1b, #dc2626, #b91c1c, #991b1b) !important; 
            background-size: 300% 300% !important;
            animation: gradient-animation 8s ease infinite !important;
            border-radius: 0.75rem !important;
            margin-bottom: 1.5rem !important;
            border: none !important;
        }
        
        /* Apply VERY Dark Red Gradient in Dark Mode (Very Dark Red) */
        html.dark .red-gradient-filter { 
            background: linear-gradient(to right, #450a0a, #7f1d1d, #450a0a) !important; 
            background-size: 300% 300% !important;
            animation: gradient-animation 8s ease infinite !important;
            border-radius: 0.75rem !important;
            margin-bottom: 1.5rem !important;
            border: none !important;
        }
        
        @keyframes gradient-animation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .red-gradient-filter,
        .red-gradient-filter > div,
        .red-gradient-filter section,
        .red-gradient-filter header,
        .red-gradient-filter header > div {
            background-color: transparent !important;
        }
    </style>

    <x-filament::section class="red-gradient-filter w-full border-none shadow-none !max-w-full" style="position: relative; overflow: hidden; padding-bottom: 2rem;">
        
        <!-- Animated Wave Background -->
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; line-height: 0; z-index: 0; pointer-events: none;">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto" style="position: relative; width: 100%; height: 60px; margin-bottom: -7px; min-height: 60px; max-height: 80px;">
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

        <div class="dashboard-filter-content">
            <div style="margin-bottom: 1rem;">
                <h3 class="text-lg leading-6" style="color: white !important; font-weight: bold !important;">Selamat datang kembali, {{ auth()->user()->name ?? 'Sales' }}! 👋</h3>
                <p class="mt-1 text-sm" style="color: white !important;">Filter data dashboard berdasarkan periode di bawah ini.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: flex-end;">
                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model.live="bulan" class="w-full" style="width: 100%;">
                            <option value="">Semua Bulan</option>
                            @foreach($this->getBulanOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model.live="tahun" class="w-full" style="width: 100%;">
                            <option value="">Semua Tahun</option>
                            @foreach($this->getTahunOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                <div style="display: flex; align-items: flex-end;">
                    <x-filament::button wire:click="resetFilter" class="reset-filter-btn" color="gray" style="background-color: #1f2937; color: white;">
                        Reset
                    </x-filament::button>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
