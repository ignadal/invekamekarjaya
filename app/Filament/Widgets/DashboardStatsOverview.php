<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\PembelianSupplier;
use App\Models\PayrollSales;
use App\Models\Barang;
use Illuminate\Support\Number;
use Illuminate\Support\Carbon;

class DashboardStatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $bulan = $this->filters['bulan'] ?? now()->month;
        $tahun = $this->filters['tahun'] ?? now()->year;

        $omset = Penjualan::where('status_persetujuan', 'disetujui')
            ->whereYear('tanggal_beli', $tahun)
            ->whereMonth('tanggal_beli', $bulan)
            ->sum('total_penjualan');

        $piutang = Penjualan::where('status_persetujuan', 'disetujui')
            ->whereYear('tanggal_beli', $tahun)
            ->whereMonth('tanggal_beli', $bulan)
            ->sum('sisa_pembayaran');

        $pengeluaranSupplier = PembelianSupplier::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->sum('total_pembelian');

        $pengeluaranGaji = PayrollSales::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->sum('total_gaji');

        $totalPengeluaran = $pengeluaranSupplier + $pengeluaranGaji;
        $penghasilanBersih = $omset - $totalPengeluaran;

        $totalBarang = Barang::count();
        $barangHampirHabis = Barang::whereColumn('stok', '<', 'stok_minimum')->count();
        $notaPending = Penjualan::where('status_persetujuan', 'pending')
            ->whereYear('tanggal_beli', $tahun)
            ->whereMonth('tanggal_beli', $bulan)
            ->count();

        // Total barang terjual (qty) in this period
        $barangTerjual = PenjualanDetail::whereHas('penjualan', function ($query) use ($tahun, $bulan) {
            $query->where('status_persetujuan', 'disetujui')
                ->whereYear('tanggal_beli', $tahun)
                ->whereMonth('tanggal_beli', $bulan);
        })->sum('qty');

        $namaBulan = Carbon::create()->month((int) $bulan)->translatedFormat('F');

        return [
            Stat::make('Total Penghasilan Bersih', Number::currency($penghasilanBersih, 'IDR', 'id'))
                ->description($namaBulan . ' ' . $tahun)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($penghasilanBersih >= 0 ? 'success' : 'danger'),
            Stat::make('Total Omset', Number::currency($omset, 'IDR', 'id'))
                ->description($namaBulan . ' ' . $tahun)
                ->descriptionIcon('heroicon-m-banknotes'),
            Stat::make('Total Piutang', Number::currency($piutang, 'IDR', 'id'))
                ->description($namaBulan . ' ' . $tahun)
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($piutang > 0 ? 'warning' : 'success'),
            Stat::make('Total Pengeluaran', Number::currency($totalPengeluaran, 'IDR', 'id'))
                ->description($namaBulan . ' ' . $tahun)
                ->descriptionIcon('heroicon-m-arrow-trending-down'),
            Stat::make('Barang Terjual', Number::format($barangTerjual, locale: 'id') . ' pcs')
                ->description($namaBulan . ' ' . $tahun)
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
            Stat::make('Total Barang', $totalBarang)
                ->description('Semua jenis')
                ->descriptionIcon('heroicon-m-cube'),
            Stat::make('Barang Hampir Habis', $barangHampirHabis)
                ->color($barangHampirHabis > 0 ? 'danger' : 'success')
                ->description($barangHampirHabis > 0 ? 'Perlu restok!' : 'Stok aman')
                ->descriptionIcon($barangHampirHabis > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle'),
            Stat::make('Nota Pending Approval', $notaPending)
                ->color($notaPending > 0 ? 'warning' : 'success')
                ->description($namaBulan . ' ' . $tahun)
                ->descriptionIcon('heroicon-m-clock'),
        ];
    }
}
