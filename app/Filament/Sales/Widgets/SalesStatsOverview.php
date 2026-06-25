<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesStatsOverview extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $sales = \App\Models\Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        // 1. Total Kunjungan
        $kunjunganBulanIni = \App\Models\KunjunganSales::where('sales_id', $salesId)
            ->whereBetween('tanggal_kunjungan', [$startOfMonth, $endOfMonth])
            ->count();
        $kunjunganBulanLalu = \App\Models\KunjunganSales::where('sales_id', $salesId)
            ->whereBetween('tanggal_kunjungan', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        $kunjunganGrowth = $kunjunganBulanLalu > 0 ? (($kunjunganBulanIni - $kunjunganBulanLalu) / $kunjunganBulanLalu) * 100 : ($kunjunganBulanIni > 0 ? 100 : 0);
        $kunjunganColor = $kunjunganGrowth >= 0 ? 'success' : 'danger';
        $kunjunganIcon = $kunjunganGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';

        // 2. Total Tagihan
        $tagihanBulanIni = \App\Models\Penjualan::where('sales_id', $salesId)
            ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
            ->sum('total_penjualan');
        $tagihanBulanLalu = \App\Models\Penjualan::where('sales_id', $salesId)
            ->whereBetween('tanggal_beli', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total_penjualan');
        $tagihanGrowth = $tagihanBulanLalu > 0 ? (($tagihanBulanIni - $tagihanBulanLalu) / $tagihanBulanLalu) * 100 : ($tagihanBulanIni > 0 ? 100 : 0);
        $tagihanColor = $tagihanGrowth >= 0 ? 'success' : 'danger';
        $tagihanIcon = $tagihanGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';

        // 3. Total Pembayaran
        $pembayaranBulanIni = \App\Models\CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                $q->where('sales_id', $salesId);
            })
            ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
            ->sum('nominal');
        $pembayaranBulanLalu = \App\Models\CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                $q->where('sales_id', $salesId);
            })
            ->whereBetween('tanggal_bayar', [$startOfLastMonth, $endOfLastMonth])
            ->sum('nominal');
        $pembayaranGrowth = $pembayaranBulanLalu > 0 ? (($pembayaranBulanIni - $pembayaranBulanLalu) / $pembayaranBulanLalu) * 100 : ($pembayaranBulanIni > 0 ? 100 : 0);
        $pembayaranColor = $pembayaranGrowth >= 0 ? 'success' : 'danger';
        $pembayaranIcon = $pembayaranGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';

        // 4. Komisi
        $komisiBulanIni = \App\Models\PayrollSales::where('sales_id', $salesId)
            ->where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->sum('bonus_nominal');
        $komisiBulanLalu = \App\Models\PayrollSales::where('sales_id', $salesId)
            ->where('bulan', now()->subMonth()->month)
            ->where('tahun', now()->subMonth()->year)
            ->sum('bonus_nominal');
        $komisiGrowth = $komisiBulanLalu > 0 ? (($komisiBulanIni - $komisiBulanLalu) / $komisiBulanLalu) * 100 : ($komisiBulanIni > 0 ? 100 : 0);
        $komisiColor = $komisiGrowth >= 0 ? 'success' : 'danger';
        $komisiIcon = $komisiGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';

        return [
            Stat::make('Total Kunjungan (Bulan Ini)', $kunjunganBulanIni)
                ->description(number_format(abs($kunjunganGrowth), 1) . '% dari bulan lalu')
                ->descriptionIcon($kunjunganIcon)
                ->color($kunjunganColor)
                ->chart([7, 2, 10, 3, 15, 4, $kunjunganBulanIni]),
                
            Stat::make('Total Tagihan (Bulan Ini)', 'Rp ' . number_format($tagihanBulanIni, 0, ',', '.'))
                ->description(number_format(abs($tagihanGrowth), 1) . '% dari bulan lalu')
                ->descriptionIcon($tagihanIcon)
                ->color($tagihanColor)
                ->chart([7, 2, 10, 3, 15, 4, $tagihanBulanIni]),
                
            Stat::make('Total Pembayaran (Bulan Ini)', 'Rp ' . number_format($pembayaranBulanIni, 0, ',', '.'))
                ->description(number_format(abs($pembayaranGrowth), 1) . '% dari bulan lalu')
                ->descriptionIcon($pembayaranIcon)
                ->color($pembayaranColor)
                ->chart([7, 2, 10, 3, 15, 4, $pembayaranBulanIni]),
                
            Stat::make('Komisi (Bulan Ini)', 'Rp ' . number_format($komisiBulanIni, 0, ',', '.'))
                ->description(number_format(abs($komisiGrowth), 1) . '% dari bulan lalu')
                ->descriptionIcon($komisiIcon)
                ->color($komisiColor)
                ->chart([7, 2, 10, 3, 15, 4, $komisiBulanIni]),
        ];
    }
}
