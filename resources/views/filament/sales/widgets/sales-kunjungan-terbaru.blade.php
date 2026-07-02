<x-filament-widgets::widget>
    <style>
        .kunjungan-card {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        
        .kunjungan-header {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .kunjungan-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }
        
        .kunjungan-header-btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ef4444;
            background: #fff;
            border: 1px solid #fee2e2;
            border-radius: 0.5rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .kunjungan-header-btn:hover {
            background: #fef2f2;
        }
        
        .kunjungan-banner {
            height: 140px;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .kunjungan-banner-icon {
            color: #ef4444;
            width: 5rem;
            height: 5rem;
            z-index: 2;
            opacity: 0.9;
        }
        
        .kunjungan-banner-decor {
            position: absolute;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            z-index: 1;
        }
        .decor-1 { width: 100px; height: 100px; top: -20px; left: -20px; }
        .decor-2 { width: 150px; height: 150px; bottom: -50px; right: -30px; }
        
        .kunjungan-table-wrapper {
            overflow-x: auto;
        }
        
        .kunjungan-table {
            width: 100%;
            min-width: 450px;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            font-size: 0.875rem;
        }
        
        .kunjungan-table th {
            text-align: left;
            padding: 0 0.75rem 0.75rem 0.75rem;
            font-weight: 700;
            color: #9ca3af;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .kunjungan-table td {
            padding: 1rem 0.75rem;
            color: #374151;
            vertical-align: middle;
            background: #fff;
        }
        
        /* Optional subtle row background */
        .kunjungan-table tbody tr {
            border-radius: 0.5rem;
        }
        .kunjungan-table tbody tr:hover td {
            background: #f9fafb;
        }
        
        .kunjungan-toko-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .kunjungan-toko-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: #fef2f2;
            color: #ef4444;
            border-radius: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .kunjungan-toko-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }
        
        .kunjungan-toko-name {
            font-weight: 700;
            color: #111827;
            font-size: 0.9375rem;
            white-space: nowrap;
        }
        
        .kunjungan-lokasi-text {
            font-weight: 600;
            color: #4b5563;
            white-space: nowrap;
        }
        
        .kunjungan-waktu-date {
            color: #6b7280;
            font-weight: 500;
            display: block;
            white-space: nowrap;
        }
        .kunjungan-waktu-time {
            color: #9ca3af;
            font-size: 0.8125rem;
            display: block;
            margin-top: 0.125rem;
            white-space: nowrap;
        }

        html.dark .kunjungan-card { background: #18181b; border-color: #3f3f46; }
        html.dark .kunjungan-title { color: #f4f4f5; }
        html.dark .kunjungan-header-btn { background: #18181b; border-color: #3f3f46; color: #f87171; }
        html.dark .kunjungan-header-btn:hover { background: #450a0a; }
        html.dark .kunjungan-table td { border-bottom-color: #3f3f46; background: #27272a; }
        html.dark .kunjungan-table tbody tr:hover td { background: #3f3f46; }
        html.dark .kunjungan-table th { color: #a1a1aa; border-bottom-color: #3f3f46; }
        html.dark .kunjungan-toko-name { color: #f4f4f5; }
        html.dark .kunjungan-lokasi-text { color: #d4d4d8; }
        html.dark .kunjungan-toko-icon { background: #450a0a; color: #f87171; }
        html.dark .kunjungan-banner { background: linear-gradient(135deg, #450a0a 0%, #7f1d1d 100%); }
        html.dark .kunjungan-banner-decor { background: rgba(0, 0, 0, 0.2); }

        .kunjungan-empty {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            text-align: center;
        }
        .kunjungan-empty-title {
            font-size: 1rem;
            font-weight: 700;
            color: #374151;
            margin: 1rem 0 0.25rem 0;
        }
        .kunjungan-empty-desc {
            font-size: 0.875rem;
            color: #9ca3af;
            margin: 0;
        }
    </style>

    <div class="kunjungan-card">
        <div class="kunjungan-header">
            <div class="kunjungan-title">
                Kunjungan Terbaru
                <div x-data="{ open: false }" style="position: relative; display: inline-flex; align-items: center;">
                    <button type="button" @click="open = !open" style="outline: none; background: none; border: none; cursor: pointer; padding: 0.5rem; margin: -0.5rem; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af" style="width: 1.25rem; height: 1.25rem;">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; z-index: 99999; width: 220px; background-color: #1f2937; color: #f9fafb; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: normal; line-height: 1.4; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); top: 150%; left: 50%; transform: translateX(-50%); white-space: normal;">
                        <div style="position: absolute; top: -4px; left: 50%; margin-left: -5px; width: 10px; height: 10px; background-color: #1f2937; transform: rotate(45deg);"></div>
                        Daftar 5 toko terakhir yang Anda kunjungi hari ini.
                    </div>
                </div>
            </div>
            <button type="button" wire:click="gotoList" class="kunjungan-header-btn">Lihat semua</button>
        </div>

        <div class="kunjungan-banner">
            <div class="kunjungan-banner-decor decor-1"></div>
            <div class="kunjungan-banner-decor decor-2"></div>
            <svg class="kunjungan-banner-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M5.223 2.25c-.498 0-.97.198-1.325.55l-1.3 1.298A3.75 3.75 0 0 0 7.5 9.75c.627 0 1.216-.153 1.73-.421A3.649 3.649 0 0 0 12 10.5a3.649 3.649 0 0 0 2.77-1.171 3.731 3.731 0 0 0 1.73.421 3.75 3.75 0 0 0 4.902-5.652l-1.3-1.298a1.875 1.875 0 0 0-1.325-.55H5.223Z" />
              <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 0 0 9.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 0 0 2.25.506c.804 0 1.568-.182 2.25-.506 1.42.674 3.08.673 4.5 0v8.755M15.75 11.25c.804 0 1.568-.182 2.25-.506v9.506c0 .414-.336.75-.75.75H6.75a.75.75 0 0 1-.75-.75v-9.506c.682.324 1.446.506 2.25.506A5.23 5.23 0 0 0 12 10.5a5.23 5.23 0 0 0 3.75.75Zm-7.5 5.25a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 .75.75v3h-7.5v-3Z" clip-rule="evenodd" />
            </svg>
        </div>

        @if($this->kunjungans->count() > 0)
            <div class="kunjungan-table-wrapper">
                <table class="kunjungan-table">
                    <thead>
                        <tr>
                            <th>Toko</th>
                            <th>Lokasi</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->kunjungans as $kunjungan)
                            <tr style="cursor: pointer;" wire:click="gotoView('{{ $kunjungan->buyer_id }}')">
                                <td>
                                    <div class="kunjungan-toko-cell">
                                        <div class="kunjungan-toko-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                              <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                                            </svg>
                                        </div>
                                        <span class="kunjungan-toko-name">{{ $kunjungan->buyer->nama_toko ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="kunjungan-lokasi-text">{{ $kunjungan->buyer->kecamatan->nama_kecamatan ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="kunjungan-waktu-date">{{ $kunjungan->created_at ? $kunjungan->created_at->format('d M Y') : '-' }}</span>
                                    <span class="kunjungan-waktu-time">{{ $kunjungan->created_at ? $kunjungan->created_at->format('H:i') : '' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="kunjungan-empty">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
                    <path d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                </svg>
                <p class="kunjungan-empty-title">Belum ada kunjungan hari ini</p>
                <p class="kunjungan-empty-desc">Kunjungan yang Anda buat hari ini akan muncul di sini.</p>
            </div>
        @endif

    </div>
</x-filament-widgets::widget>
