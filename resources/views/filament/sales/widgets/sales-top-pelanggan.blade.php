<x-filament-widgets::widget>
    <style>
        .top-toko-card {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        /* Header Section */
        .top-toko-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .top-toko-title-area {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .top-toko-main-icon {
            background: #fef2f2;
            color: #ef4444;
            padding: 0.75rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .top-toko-main-icon svg {
            width: 1.75rem;
            height: 1.75rem;
            stroke-width: 2;
        }

        .top-toko-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 0.25rem 0;
        }

        .top-toko-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }

        .top-toko-search {
            position: relative;
            width: 100%;
            max-width: 250px;
        }

        .top-toko-search input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #374151;
            outline: none;
            transition: border-color 0.2s;
        }

        .top-toko-search input:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 1px #ef4444;
        }

        .top-toko-search svg {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.25rem;
            height: 1.25rem;
            color: #9ca3af;
        }

        /* Table Section */
        .top-toko-table-wrapper {
            overflow-x: auto;
        }

        .top-toko-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .top-toko-table th {
            background: #fffafa;
            padding: 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: #111827;
        }
        
        .top-toko-table th:first-child {
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }
        .top-toko-table th:last-child {
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .top-toko-table td {
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .top-toko-table tr:last-child td {
            border-bottom: none;
        }

        /* Cell Styles */
        .rank-badge {
            background: #fef2f2;
            color: #ef4444;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            display: inline-block;
        }

        .toko-cell, .owner-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cell-icon {
            background: #fef2f2;
            color: #ef4444;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .cell-icon svg {
            width: 1.25rem;
            height: 1.25rem;
            stroke-width: 2;
        }

        .toko-info-name, .owner-info-name {
            font-weight: 700;
            color: #111827;
            font-size: 0.9375rem;
            margin-bottom: 0.125rem;
        }
        
        .toko-info-id {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .owner-info-name {
            font-weight: 500;
        }

        .total-cell {
            font-weight: 700;
            color: #111827;
            font-size: 0.9375rem;
        }

        /* Footer Button */
        .top-toko-footer-btn {
            display: block;
            width: 100%;
            background: #fef2f2;
            color: #ef4444;
            text-align: center;
            padding: 0.875rem;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
            margin-top: 1.5rem;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }
        .top-toko-footer-btn:hover {
            background: #fee2e2;
        }
        .top-toko-footer-btn span {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        /* Modal Custom CSS */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(17, 24, 39, 0.7); /* bg-gray-900 bg-opacity-70 */
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .custom-modal-content {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 56rem; /* max-w-4xl */
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .custom-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .custom-modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex: 1;
        }
        
        .custom-modal-close-btn {
            color: #9ca3af;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.2s;
        }
        .custom-modal-close-btn:hover {
            color: #4b5563;
        }
    </style>

    <div x-data="{ showModal: false }" class="top-toko-card">
        <!-- Header -->
        <div class="top-toko-header">
            <div class="top-toko-title-area">
                <div class="top-toko-main-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="top-toko-title">Top 5 Toko Teraktif {{ $periodeLabel }}</h2>
                    <p class="top-toko-subtitle">Berdasarkan total transaksi</p>
                </div>
            </div>
            
            <div class="top-toko-search">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search toko...">
            </div>
        </div>

        <!-- Table -->
        <div class="top-toko-table-wrapper">
            <table class="top-toko-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 40%;">Toko</th>
                        <th style="width: 30%;">Pemilik</th>
                        <th style="width: 25%; white-space: nowrap;">
                            <div style="display: flex; align-items: center; gap: 0.25rem;">
                                Total Transaksi 
                                <svg style="width: 1rem; height: 1rem; color: #6b7280;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->topPelanggan as $index => $toko)
                        <tr>
                            <td>
                                <span class="rank-badge">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="toko-cell">
                                    <div class="cell-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="toko-info-name">{{ $toko->nama_toko }}</div>
                                        <div class="toko-info-id">ID: TKD{{ str_pad($toko->id, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="owner-cell">
                                    <div class="cell-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <div class="owner-info-name">{{ $toko->nama_owner ?? '-' }}</div>
                                </div>
                            </td>
                            <td style="white-space: nowrap;">
                                <div class="total-cell">
                                    Rp {{ number_format($toko->penjualans_sum_total_penjualan, 2, ',', '.') }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: #6b7280;">
                                Tidak ada data pelanggan teraktif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <button type="button" @click="showModal = true" class="top-toko-footer-btn">
            <span>
                Lihat ranking lengkap 
                <svg style="width: 1rem; height: 1rem;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </button>

        <!-- Pop-Up Modal -->
        <div x-show="showModal" style="display: none;" class="custom-modal-overlay" x-transition.opacity>
            <div @click.away="showModal = false" class="custom-modal-content" x-transition>
                <!-- Modal Header -->
                <div class="custom-modal-header">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div class="top-toko-main-icon" style="padding: 0.5rem;">
                            <svg style="width: 1.5rem; height: 1.5rem;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                            </svg>
                        </div>
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin: 0;">Ranking Lengkap Toko Teraktif</h2>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Semua data transaksi pelanggan Anda bulan ini</p>
                        </div>
                    </div>
                    <button @click="showModal = false" class="custom-modal-close-btn">
                        <svg style="width: 1.5rem; height: 1.5rem;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body with Scroll -->
                <div class="custom-modal-body">
                    <div class="top-toko-table-wrapper" style="border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                        <table class="top-toko-table" style="min-width: 100%;">
                            <thead style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                <tr>
                                    <th style="width: 5%; background: #f9fafb;">#</th>
                                    <th style="width: 40%; background: #f9fafb;">Toko</th>
                                    <th style="width: 30%; background: #f9fafb;">Pemilik</th>
                                    <th style="width: 25%; white-space: nowrap; background: #f9fafb;">Total Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->allPelanggan as $index => $toko)
                                    <tr>
                                        <td>
                                            <span class="rank-badge" style="background: {{ $index < 3 ? '#fef2f2' : '#f3f4f6' }}; color: {{ $index < 3 ? '#ef4444' : '#6b7280' }};">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="toko-cell">
                                                <div class="cell-icon" style="background: {{ $index < 3 ? '#fef2f2' : '#f3f4f6' }}; color: {{ $index < 3 ? '#ef4444' : '#6b7280' }};">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="toko-info-name">{{ $toko->nama_toko }}</div>
                                                    <div class="toko-info-id">ID: TKD{{ str_pad($toko->id, 3, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="owner-cell">
                                                <div class="cell-icon" style="background: {{ $index < 3 ? '#fef2f2' : '#f3f4f6' }}; color: {{ $index < 3 ? '#ef4444' : '#6b7280' }};">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                    </svg>
                                                </div>
                                                <div class="owner-info-name">{{ $toko->nama_owner ?? '-' }}</div>
                                            </div>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <div class="total-cell">
                                                Rp {{ number_format($toko->penjualans_sum_total_penjualan, 2, ',', '.') }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; padding: 2rem; color: #6b7280;">
                                            Tidak ada data pelanggan teraktif.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
