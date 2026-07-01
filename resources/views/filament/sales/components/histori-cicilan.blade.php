<div>
    @if($penjualan)
        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <span style="font-weight: 600; color: #374151;">Total Tagihan:</span>
                <span style="font-weight: 700; color: #111827;">Rp {{ number_format($penjualan->total_penjualan, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <span style="font-weight: 600; color: #374151;">Sudah Dibayar:</span>
                <span style="font-weight: 700; color: #10b981;">Rp {{ number_format($penjualan->sudah_dibayar, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600; color: #374151;">Sisa Tagihan:</span>
                <span style="font-weight: 700; color: #ef4444;">Rp {{ number_format(max(0, $penjualan->total_penjualan - $penjualan->sudah_dibayar), 0, ',', '.') }}</span>
            </div>
        </div>
    @endif

    @if($cicilans->isEmpty())
        <div style="text-align: center; padding: 2rem; color: #6b7280; background-color: #f9fafb; border-radius: 0.5rem;">
            Belum ada histori pembayaran.
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($cicilans as $index => $cicilan)
                <div style="padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; background-color: #ffffff; display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                    <div>
                        <div style="font-weight: 700; font-size: 0.875rem; color: #111827; display: flex; align-items: center; gap: 0.5rem;">
                            <span>Pembayaran #{{ $cicilans->count() - $index }}</span>
                            <span style="font-size: 0.75rem; padding: 0.125rem 0.375rem; border-radius: 9999px; background-color: #ecfdf5; color: #10b981; font-weight: 600;">Berhasil</span>
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                            {{ \Carbon\Carbon::parse($cicilan->tanggal_bayar)->format('d M Y') }}
                        </div>
                        @if($cicilan->catatan)
                            <div style="font-size: 0.875rem; color: #4b5563; margin-top: 0.5rem; background-color: #f9fafb; padding: 0.5rem; border-radius: 0.375rem;">
                                {{ $cicilan->catatan }}
                            </div>
                        @endif
                    </div>
                    <div style="text-align: right; font-weight: 700; color: #10b981;">
                        + Rp {{ number_format($cicilan->nominal, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
