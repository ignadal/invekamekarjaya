<x-filament-panels::page>
    <style>
        .ts-tab-container {
            display: inline-flex;
            background-color: #ffffff;
            border-radius: 9999px;
            padding: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            overflow-x: auto;
            white-space: nowrap;
            max-width: 100%;
        }
        html.dark .ts-tab-container {
            background-color: #18181b; /* matching standard filament dark background */
            border-color: #3f3f46;
        }

        /* Hide scrollbar for the tab container */
        .ts-tab-container::-webkit-scrollbar {
            display: none;
        }
        .ts-tab-container {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        .ts-tab-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
            outline: none;
        }

        .ts-tab-btn-active {
            background-color: #E30613; /* Branded red */
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .ts-tab-btn-inactive {
            background-color: transparent;
            color: #6b7280;
        }
        .ts-tab-btn-inactive:hover {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        html.dark .ts-tab-btn-inactive {
            color: #a1a1aa;
        }
        html.dark .ts-tab-btn-inactive:hover {
            background-color: #27272a;
            color: #f4f4f5;
        }

        .ts-icon {
            width: 1.25rem;
            height: 1.25rem;
        }

        .ts-content-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
        }
        html.dark .ts-content-card {
            background-color: #18181b;
            border-color: #3f3f46;
        }

        .ts-content-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 1rem 0;
        }
        html.dark .ts-content-title {
            color: white;
        }

        .ts-empty-state {
            color: #6b7280;
            text-align: center;
            padding: 2.5rem 0;
        }
        html.dark .ts-empty-state {
            color: #a1a1aa;
        }

        .ts-empty-icon {
            width: 3rem;
            height: 3rem;
            margin: 0 auto 0.75rem auto;
            color: #9ca3af;
        }
        html.dark .ts-empty-icon {
            color: #71717a;
        }
        
        .ts-flex-row {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 1.5rem;
            width: 100%;
        }
    </style>

    <div class="ts-flex-row">
        <div class="ts-tab-container">
            <!-- Gaji Pokok Tab -->
            <button 
                wire:click="setTab('gaji_pokok')"
                class="ts-tab-btn {{ $activeTab === 'gaji_pokok' ? 'ts-tab-btn-active' : 'ts-tab-btn-inactive' }}"
            >
                <x-heroicon-o-banknotes class="ts-icon" />
                Gaji Pokok
            </button>

            <!-- Uang Makan/Bensin Tab -->
            <button 
                wire:click="setTab('makan_bensin')"
                class="ts-tab-btn {{ $activeTab === 'makan_bensin' ? 'ts-tab-btn-active' : 'ts-tab-btn-inactive' }}"
            >
                <x-heroicon-o-truck class="ts-icon" />
                Uang Makan/Bensin
            </button>

            <!-- Bonus & Komisi Tab -->
            <button 
                wire:click="setTab('bonus_komisi')"
                class="ts-tab-btn {{ $activeTab === 'bonus_komisi' ? 'ts-tab-btn-active' : 'ts-tab-btn-inactive' }}"
            >
                <x-heroicon-o-star class="ts-icon" />
                Bonus & Komisi
            </button>
        </div>
    </div>

    <div>
        @if ($activeTab === 'gaji_pokok')
            <div class="ts-content-card">
                <h2 class="ts-content-title">Rincian Gaji Pokok</h2>
                <div class="ts-empty-state">
                    <x-heroicon-o-inbox class="ts-empty-icon" />
                    <p style="margin: 0;">Informasi Gaji Pokok akan ditampilkan di sini.</p>
                </div>
            </div>
        @elseif ($activeTab === 'makan_bensin')
            <div class="ts-content-card">
                <h2 class="ts-content-title">Uang Makan & Bensin</h2>
                <div class="ts-empty-state">
                    <x-heroicon-o-inbox class="ts-empty-icon" />
                    <p style="margin: 0;">Rincian Uang Makan/Bensin akan ditampilkan di sini.</p>
                </div>
            </div>
        @elseif ($activeTab === 'bonus_komisi')
            <div class="ts-content-card">
                <h2 class="ts-content-title">Bonus & Komisi</h2>
                <div class="ts-empty-state">
                    <x-heroicon-o-inbox class="ts-empty-icon" />
                    <p style="margin: 0;">Informasi Bonus, Komisi, dan insentif lainnya akan ditampilkan di sini.</p>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
