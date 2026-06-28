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

    <style>
        .ts-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .ts-table th, .ts-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        html.dark .ts-table th, html.dark .ts-table td {
            border-color: #3f3f46;
        }
        .ts-table th {
            font-weight: 600;
            color: #374151;
            background-color: #f9fafb;
        }
        html.dark .ts-table th {
            color: #d1d5db;
            background-color: #27272a;
        }
        .ts-table td {
            color: #4b5563;
        }
        html.dark .ts-table td {
            color: #a1a1aa;
        }
        .ts-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.125rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .ts-badge-success {
            background-color: #dcfce7;
            color: #166534;
        }
        html.dark .ts-badge-success {
            background-color: #14532d;
            color: #4ade80;
        }
        .ts-badge-warning {
            background-color: #fef9c3;
            color: #854d0e;
        }
        html.dark .ts-badge-warning {
            background-color: #713f12;
            color: #fde047;
        }
    </style>

    <div>
        @if ($activeTab === 'gaji_pokok')
            <div class="ts-content-card">
                <h2 class="ts-content-title">Rincian Gaji Pokok</h2>
                @if(isset($payrollData) && count($payrollData) > 0)
                    <div style="overflow-x: auto;">
                        <table class="ts-table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Gaji Pokok</th>
                                    <th>Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payrollData as $payroll)
                                <tr>
                                    <td>{{ DateTime::createFromFormat('!m', $payroll->bulan)->format('F') }} {{ $payroll->tahun }}</td>
                                    <td>Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
                                    <td>
                                        @if($payroll->status_pembayaran === 'lunas')
                                            <span class="ts-badge ts-badge-success">Lunas</span>
                                        @else
                                            <span class="ts-badge ts-badge-warning">Belum Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="ts-empty-state">
                        <x-heroicon-o-inbox class="ts-empty-icon" />
                        <p style="margin: 0;">Informasi Gaji Pokok belum tersedia.</p>
                    </div>
                @endif
            </div>
        @elseif ($activeTab === 'makan_bensin')
            <div class="ts-content-card">
                <h2 class="ts-content-title">Uang Makan & Bensin</h2>
                @if(isset($payrollData) && count($payrollData) > 0)
                    <div style="overflow-x: auto;">
                        <table class="ts-table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Uang Makan</th>
                                    <th>Uang Bensin</th>
                                    <th>Total</th>
                                    <th>Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payrollData as $payroll)
                                <tr>
                                    <td>{{ DateTime::createFromFormat('!m', $payroll->bulan)->format('F') }} {{ $payroll->tahun }}</td>
                                    <td>Rp {{ number_format($payroll->uang_makan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($payroll->uang_bensin, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($payroll->uang_makan + $payroll->uang_bensin, 0, ',', '.') }}</td>
                                    <td>
                                        @if($payroll->status_pembayaran === 'lunas')
                                            <span class="ts-badge ts-badge-success">Lunas</span>
                                        @else
                                            <span class="ts-badge ts-badge-warning">Belum Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="ts-empty-state">
                        <x-heroicon-o-inbox class="ts-empty-icon" />
                        <p style="margin: 0;">Rincian Uang Makan/Bensin belum tersedia.</p>
                    </div>
                @endif
            </div>
        @elseif ($activeTab === 'bonus_komisi')
            <div class="ts-content-card">
                <h2 class="ts-content-title">Bonus & Komisi</h2>
                @if(isset($payrollData) && count($payrollData) > 0)
                    <div style="overflow-x: auto;">
                        <table class="ts-table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Total Penjualan</th>
                                    <th>Persentase Bonus</th>
                                    <th>Bonus Nominal</th>
                                    <th>Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payrollData as $payroll)
                                <tr>
                                    <td>{{ DateTime::createFromFormat('!m', $payroll->bulan)->format('F') }} {{ $payroll->tahun }}</td>
                                    <td>Rp {{ number_format($payroll->total_penjualan, 0, ',', '.') }}</td>
                                    <td>{{ $payroll->bonus_persen }}%</td>
                                    <td>Rp {{ number_format($payroll->bonus_nominal, 0, ',', '.') }}</td>
                                    <td>
                                        @if($payroll->status_pembayaran === 'lunas')
                                            <span class="ts-badge ts-badge-success">Lunas</span>
                                        @else
                                            <span class="ts-badge ts-badge-warning">Belum Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="ts-empty-state">
                        <x-heroicon-o-inbox class="ts-empty-icon" />
                        <p style="margin: 0;">Informasi Bonus, Komisi, dan insentif lainnya belum tersedia.</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-filament-panels::page>
