<div>
    @if($penjualan)
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <div>
                <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">Toko / Pembeli</div>
                <div style="font-weight: 600; color: #111827; font-size: 0.875rem;">{{ $penjualan->buyer->nama_toko ?? 'Unknown' }}</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">Tanggal Beli</div>
                <div style="font-weight: 600; color: #111827; font-size: 0.875rem;">{{ \Carbon\Carbon::parse($penjualan->tanggal_beli)->format('d M Y') }}</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">Metode</div>
                <div style="font-weight: 600; color: #111827; font-size: 0.875rem;">{{ ucfirst($penjualan->metode) }}</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">Status</div>
                <div>
                    @php
                        $statusClass = $penjualan->status_persetujuan === 'pending' ? 'text-orange-600 bg-orange-100' : ($penjualan->status_persetujuan === 'disetujui' ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100');
                    @endphp
                    <span style="font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 9999px; font-weight: 600;" class="{{ $statusClass }}">
                        {{ ucfirst($penjualan->status_persetujuan) }}
                    </span>
                </div>
            </div>
        </div>

        <div style="font-weight: 700; color: #374151; margin-bottom: 1rem; font-size: 0.875rem;">Detail Barang</div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.5rem;">
            @forelse($penjualan->details as $item)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                    <div>
                        <div style="font-weight: 600; color: #111827; font-size: 0.875rem;">{{ $item->barang->nama_barang ?? 'Unknown Item' }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.125rem;">{{ $item->qty }} x Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</div>
                    </div>
                    <div style="font-weight: 700; color: #111827; font-size: 0.875rem;">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #6b7280; font-size: 0.875rem;">Tidak ada detail barang.</div>
            @endforelse
        </div>

        <div style="padding-top: 1rem; border-top: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 0.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Total Penjualan:</span>
                <span style="font-weight: 700; color: #111827; font-size: 1rem;">Rp {{ number_format($penjualan->total_penjualan, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Sudah Dibayar:</span>
                <span style="font-weight: 700; color: #10b981; font-size: 1rem;">Rp {{ number_format($penjualan->sudah_dibayar, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Sisa Tagihan:</span>
                <span style="font-weight: 700; color: #ef4444; font-size: 1rem;">Rp {{ number_format(max(0, $penjualan->total_penjualan - $penjualan->sudah_dibayar), 0, ',', '.') }}</span>
            </div>
        </div>
    @else
        <div style="text-align: center; color: #6b7280;">Data penjualan tidak ditemukan.</div>
    @endif
</div>
