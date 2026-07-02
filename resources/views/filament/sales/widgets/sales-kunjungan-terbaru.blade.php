<x-filament-widgets::widget>
    <style>
        .kunjungan-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .kunjungan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .kunjungan-title {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .kunjungan-btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #374151;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            text-decoration: none;
            cursor: pointer;
        }
        .kunjungan-btn:hover {
            background: #f9fafb;
        }
        .kunjungan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
        }
        .kunjungan-table th {
            text-align: left;
            padding: 0.625rem 0.5rem;
            font-weight: 600;
            color: #6b7280;
            font-size: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .kunjungan-table td {
            padding: 0.75rem 0.5rem;
            color: #111827;
            border-bottom: 1px solid #f9fafb;
            vertical-align: top;
        }
        .kunjungan-toko-name {
            font-weight: 600;
            color: #111827;
        }
        .kunjungan-empty {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }
        .kunjungan-empty-icon {
            width: 5rem;
            height: 5rem;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            position: relative;
        }
        .kunjungan-empty-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 1.25rem;
            height: 1.25rem;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .kunjungan-empty-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 0.25rem 0;
        }
        .kunjungan-empty-desc {
            font-size: 0.75rem;
            color: #9ca3af;
            margin: 0;
            line-height: 1.4;
        }
    </style>

    <div class="kunjungan-card">
        <div class="kunjungan-header">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <h3 class="kunjungan-title">Kunjungan Terbaru</h3>
                <div x-data="{ open: false }" style="position: relative; display: inline-flex; align-items: center;">
                    <button type="button" @click.stop="open = !open" style="outline: none; background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af" style="width: 1.25rem; height: 1.25rem;">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; z-index: 9999; width: 220px; background-color: #1f2937; color: #f9fafb; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: normal; line-height: 1.4; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); top: 125%; left: 0; white-space: normal;">
                        <div style="position: absolute; top: -5px; left: 8px; width: 10px; height: 10px; background-color: #1f2937; transform: rotate(45deg);"></div>
                        Daftar 5 toko terakhir yang Anda kunjungi dan telah Anda catat laporannya.
                    </div>
                </div>
            </div>
            <button class="kunjungan-btn">Lihat semua</button>
        </div>

        @if($this->kunjungans->count() > 0)
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
                        <tr>
                            <td>
                                <span class="kunjungan-toko-name">{{ $kunjungan->buyer->nama_toko ?? '-' }}</span>
                            </td>
                            <td>{{ $kunjungan->buyer->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td style="white-space: nowrap; font-size: 0.75rem; color: #6b7280;">
                                {{ $kunjungan->tanggal_kunjungan ? $kunjungan->tanggal_kunjungan->format('d M Y') : '-' }}<br>
                                {{ $kunjungan->tanggal_kunjungan ? $kunjungan->tanggal_kunjungan->format('H:i') : '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="kunjungan-empty">
                <div class="kunjungan-empty-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5"><path d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/></svg>
                    <div class="kunjungan-empty-badge">
                        <svg width="10" height="10" viewBox="0 0 20 20" fill="#fff"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/></svg>
                    </div>
                </div>
                <p class="kunjungan-empty-title">Belum ada kunjungan sales</p>
                <p class="kunjungan-empty-desc">Kunjungan yang Anda lakukan<br>akan muncul di sini.</p>
            </div>
        @endif
    </div>
</x-filament-widgets::widget>
