<x-filament-panels::page>
    <style>
        .ts-tab-container {
            display: inline-flex;
            background-color: #ffffff;
            border-radius: 0.75rem;
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
            border-radius: 0.5rem;
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
        .ts-summary-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }
        html.dark .ts-summary-box {
            background-color: #27272a;
            border-color: #3f3f46;
        }
        .ts-summary-box span {
            font-size: 0.75rem;
            color: #6b7280;
            display: block;
        }
        html.dark .ts-summary-box span {
            color: #a1a1aa;
        }
        .ts-summary-box strong {
            font-size: 1.125rem;
            color: #111827;
        }
        html.dark .ts-summary-box strong {
            color: white;
        }
        .ts-filter-select {
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 0.5rem 2rem 0.5rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            background-color: white;
            color: #374151;
            cursor: pointer;
            outline: none;
        }
        html.dark .ts-filter-select {
            background-color: #18181b;
            border-color: #3f3f46;
            color: #d1d5db;
        }
    </style>

    <div class="ts-flex-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; width: 100%;">
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

        <!-- Filter Bulan & Tahun -->
        <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
            <select wire:model.live="filterBulan" class="ts-filter-select">
                <option value="">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            
            <select wire:model.live="filterTahun" class="ts-filter-select">
                <option value="">Semua Tahun</option>
                @foreach($tahunList ?? [] as $thn)
                    <option value="{{ $thn }}">{{ $thn }}</option>
                @endforeach
            </select>
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
        
        /* Calendar Block */
        .ts-cal-block { width: 3rem; height: 3rem; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; line-height: 1.1; flex-shrink: 0;}
        html.dark .ts-cal-block { background-color: #09090b; border-color: #27272a; }
        .ts-cal-day { font-size: 1.125rem; font-weight: 800; color: #111827; }
        html.dark .ts-cal-day { color: white; }
        .ts-cal-month { font-size: 0.65rem; font-weight: 700; color: #6b7280; text-transform: uppercase; }
        
        .ts-cal-grid { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem; }
    </style>

    <div>
        @if(auth()->user()->name === 'superadmin')
            <div style="padding: 1rem; background-color: #e0f2fe; border: 1px solid #7dd3fc; color: #0369a1; border-radius: 0.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <x-heroicon-o-information-circle style="width: 1.5rem; height: 1.5rem; flex-shrink: 0;" />
                <div>
                    <strong>Mode Testing:</strong> Anda login sebagai Admin ({{ auth()->user()->name }}). Halaman ini saat ini menampilkan data gaji milik <strong>{{ $sales ? $sales->nama_sales : 'Sales' }}</strong> sebagai simulasi.
                </div>
            </div>
        @endif

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
                                        @if($payroll->status_pembayaran === 'sudah_digaji')
                                            <span class="ts-badge ts-badge-success">Sudah Digaji</span>
                                        @else
                                            <span class="ts-badge ts-badge-warning">Belum Digaji</span>
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
            @if(isset($payrollData) && count($payrollData) > 0)
                @foreach($payrollData as $payroll)
                    <div class="ts-content-card" style="margin-bottom: 2rem;">
                        <h2 class="ts-content-title" style="border-bottom: 1px solid #e5e7eb; padding-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;">
                            <span>Periode: {{ DateTime::createFromFormat('!m', $payroll->bulan)->format('F') }} {{ $payroll->tahun }}</span>
                            @if($payroll->status_pembayaran === 'sudah_digaji')
                                <span class="ts-badge ts-badge-success">Sudah Digaji</span>
                            @else
                                <span class="ts-badge ts-badge-warning">Belum Digaji</span>
                            @endif
                        </h2>
                        
                        <!-- Ringkasan Tunjangan -->
                        <div class="ts-summary-box" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; padding: 1rem; border-radius: 0.5rem;">
                            <div>
                                <span>Total Hari Kerja</span>
                                <strong>{{ $payroll->hari_kerja ?? 0 }} Hari</strong>
                            </div>
                            <div>
                                <span>Total Uang Makan</span>
                                <strong>Rp {{ number_format($payroll->uang_makan, 0, ',', '.') }}</strong>
                            </div>
                            <div>
                                <span>Total Uang Bensin</span>
                                <strong>Rp {{ number_format($payroll->uang_bensin, 0, ',', '.') }}</strong>
                            </div>
                            <div>
                                <span>Total Tunjangan</span>
                                <strong style="color: #E30613;">Rp {{ number_format($payroll->uang_makan + $payroll->uang_bensin, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <!-- Rincian Harian -->
                        <div>
                            <h3 style="font-size: 0.875rem; font-weight: 700; color: #374151; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                                <x-heroicon-o-calendar style="width: 1.125rem; height: 1.125rem; color: #6b7280;" />
                                Rincian Tunjangan Harian (Berdasarkan Tanggal)
                            </h3>
                            
                            @php
                                $tanggalList = $payroll->tanggal_kehadiran ?? [];
                                usort($tanggalList, function($a, $b) {
                                    $dateA = is_array($a) ? ($a['tanggal'] ?? '') : (is_string($a) && strlen($a) > 2 ? $a : sprintf('%02d', $a));
                                    $dateB = is_array($b) ? ($b['tanggal'] ?? '') : (is_string($b) && strlen($b) > 2 ? $b : sprintf('%02d', $b));
                                    return strcmp($dateA, $dateB);
                                });
                            @endphp

                            @if(!empty($tanggalList))
                                <div style="overflow-x: auto; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                                    <table class="ts-table" style="margin-top: 0;">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Uang Makan</th>
                                                <th>Uang Bensin</th>
                                                <th>Total Harian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tanggalList as $item)
                                                @php
                                                    $tanggalStr = '-';
                                                    $makanHarian = $payroll->uang_makan_harian ?? 0;
                                                    $bensinHarian = $payroll->uang_bensin_harian ?? 0;
                                                    
                                                    if (is_array($item)) {
                                                        if (isset($item['tanggal'])) {
                                                            $tanggalStr = \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d F Y');
                                                        }
                                                        $makanHarian = $item['uang_makan'] ?? $payroll->uang_makan_harian ?? 0;
                                                        $bensinHarian = $item['uang_bensin'] ?? $payroll->uang_bensin_harian ?? 0;
                                                    } elseif (is_string($item) && strlen($item) > 2) {
                                                        $tanggalStr = \Carbon\Carbon::parse($item)->translatedFormat('d F Y');
                                                    } else {
                                                        $dayStr = str_pad($item, 2, '0', STR_PAD_LEFT);
                                                        $monthStr = DateTime::createFromFormat('!m', $payroll->bulan)->format('M');
                                                        $tanggalStr = $dayStr . ' ' . $monthStr . ' ' . $payroll->tahun;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td style="font-weight: 600;">{{ $tanggalStr }}</td>
                                                    <td>Rp {{ number_format($makanHarian, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($bensinHarian, 0, ',', '.') }}</td>
                                                    <td style="font-weight: 600; color: #111827;">Rp {{ number_format($makanHarian + $bensinHarian, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div style="padding: 1.5rem; text-align: center; border: 1px dashed #e5e7eb; border-radius: 0.5rem; color: #9ca3af;">
                                    Belum ada tanggal kehadiran/tunjangan yang diinput untuk periode ini.
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="ts-content-card">
                    <h2 class="ts-content-title">Uang Makan & Bensin</h2>
                    <div class="ts-empty-state">
                        <x-heroicon-o-inbox class="ts-empty-icon" />
                        <p style="margin: 0;">Rincian Uang Makan/Bensin belum tersedia.</p>
                    </div>
                </div>
            @endif
        @elseif ($activeTab === 'bonus_komisi')
            <div class="ts-content-card">
                <h2 class="ts-content-title">Bonus & Komisi</h2>
                @if(isset($payrollData) && count($payrollData) > 0)
                    <div style="overflow-x: auto;">
                        <table class="ts-table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Total Penagihan</th>
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
                                        @if($payroll->status_pembayaran === 'sudah_digaji')
                                            <span class="ts-badge ts-badge-success">Sudah Digaji</span>
                                        @else
                                            <span class="ts-badge ts-badge-warning">Belum Digaji</span>
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
