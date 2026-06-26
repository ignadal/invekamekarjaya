<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\Sales;
use App\Models\KunjunganSales;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;
use App\Models\PayrollSales;

class SalesStatsOverview extends Widget
{
    protected string $view = 'filament.widgets.custom-stats-overview';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    public function getCustomStats(): array
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        $kunjunganBulanIni = 0;
        $kunjunganBulanLalu = 0;
        $kunjunganGrowth = 0;
        $tagihanBulanIni = 0;
        $tagihanBulanLalu = 0;
        $tagihanGrowth = 0;
        $pembayaranBulanIni = 0;
        $pembayaranBulanLalu = 0;
        $pembayaranGrowth = 0;
        $komisiBulanIni = 0;
        $komisiBulanLalu = 0;
        $komisiGrowth = 0;

        if ($salesId) {
            // 1. Total Kunjungan
            $kunjunganBulanIni = KunjunganSales::where('sales_id', $salesId)
                ->whereBetween('tanggal_kunjungan', [$startOfMonth, $endOfMonth])
                ->count();
            $kunjunganBulanLalu = KunjunganSales::where('sales_id', $salesId)
                ->whereBetween('tanggal_kunjungan', [$startOfLastMonth, $endOfLastMonth])
                ->count();
            $kunjunganGrowth = $kunjunganBulanLalu > 0 ? (($kunjunganBulanIni - $kunjunganBulanLalu) / $kunjunganBulanLalu) * 100 : ($kunjunganBulanIni > 0 ? 100 : 0);

            // 2. Total Tagihan
            $tagihanBulanIni = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->sum('total_penjualan');
            $tagihanBulanLalu = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfLastMonth, $endOfLastMonth])
                ->sum('total_penjualan');
            $tagihanGrowth = $tagihanBulanLalu > 0 ? (($tagihanBulanIni - $tagihanBulanLalu) / $tagihanBulanLalu) * 100 : ($tagihanBulanIni > 0 ? 100 : 0);

            // 3. Total Pembayaran
            $pembayaranBulanIni = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                    $q->where('sales_id', $salesId);
                })
                ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
                ->sum('nominal');
            $pembayaranBulanLalu = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                    $q->where('sales_id', $salesId);
                })
                ->whereBetween('tanggal_bayar', [$startOfLastMonth, $endOfLastMonth])
                ->sum('nominal');
            $pembayaranGrowth = $pembayaranBulanLalu > 0 ? (($pembayaranBulanIni - $pembayaranBulanLalu) / $pembayaranBulanLalu) * 100 : ($pembayaranBulanIni > 0 ? 100 : 0);

            // 4. Komisi
            $komisiBulanIni = PayrollSales::where('sales_id', $salesId)
                ->where('bulan', now()->month)
                ->where('tahun', now()->year)
                ->sum('bonus_nominal');
            $komisiBulanLalu = PayrollSales::where('sales_id', $salesId)
                ->where('bulan', now()->subMonth()->month)
                ->where('tahun', now()->subMonth()->year)
                ->sum('bonus_nominal');
            $komisiGrowth = $komisiBulanLalu > 0 ? (($komisiBulanIni - $komisiBulanLalu) / $komisiBulanLalu) * 100 : ($komisiBulanIni > 0 ? 100 : 0);
        }

        return [
            [
                'label' => 'Total Kunjungan',
                'value' => number_format($kunjunganBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($kunjunganGrowth), 1, ',', '.') . '% dari bulan lalu',
                'trend_up' => $kunjunganGrowth >= 0,
                'icon_bg' => '#fee2e2',
                'icon_color' => '#ef4444',
                'icon' => 'users',
            ],
            [
                'label' => 'Total Tagihan',
                'value' => 'Rp ' . number_format($tagihanBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($tagihanGrowth), 1, ',', '.') . '% dari bulan lalu',
                'trend_up' => $tagihanGrowth >= 0,
                'icon_bg' => '#dcfce7',
                'icon_color' => '#22c55e',
                'icon' => 'banknotes',
            ],
            [
                'label' => 'Total Pembayaran',
                'value' => 'Rp ' . number_format($pembayaranBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($pembayaranGrowth), 1, ',', '.') . '% dari bulan lalu',
                'trend_up' => $pembayaranGrowth >= 0,
                'icon_bg' => '#dbeafe',
                'icon_color' => '#3b82f6',
                'icon' => 'credit-card',
            ],
            [
                'label' => 'Komisi',
                'value' => 'Rp ' . number_format($komisiBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($komisiGrowth), 1, ',', '.') . '% dari bulan lalu',
                'trend_up' => $komisiGrowth >= 0,
                'icon_bg' => '#fef9c3',
                'icon_color' => '#eab308',
                'icon' => 'receipt-percent',
            ],
        ];
    }
}
