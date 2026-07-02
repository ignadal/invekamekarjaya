<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\Sales;
use App\Models\KunjunganSales;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;
use App\Models\PayrollSales;
use Illuminate\Support\Facades\DB;

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

        $penjualanBulanIni = 0;
        $penjualanBulanLalu = 0;
        $penjualanGrowth = 0;

        $harusDitagihBulanIni = 0;
        $harusDitagihBulanLalu = 0;
        $harusDitagihGrowth = 0;

        $pembayaranBulanIni = 0;
        $pembayaranBulanLalu = 0;
        $pembayaranGrowth = 0;

        $kunjunganBulanIni = 0;
        $kunjunganBulanLalu = 0;
        $kunjunganGrowth = 0;

        if ($salesId) {
            // 1. Total Penjualan
            $penjualanBulanIni = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->sum('total_penjualan');
            $penjualanBulanLalu = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfLastMonth, $endOfLastMonth])
                ->sum('total_penjualan');
            $penjualanGrowth = $penjualanBulanLalu > 0 ? (($penjualanBulanIni - $penjualanBulanLalu) / $penjualanBulanLalu) * 100 : ($penjualanBulanIni > 0 ? 100 : 0);

            // 2. Total Harus Ditagih
            $harusDitagihBulanIni = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->sum(DB::raw('total_penjualan - sudah_dibayar'));
            $harusDitagihBulanLalu = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfLastMonth, $endOfLastMonth])
                ->sum(DB::raw('total_penjualan - sudah_dibayar'));
            $harusDitagihGrowth = $harusDitagihBulanLalu > 0 ? (($harusDitagihBulanIni - $harusDitagihBulanLalu) / $harusDitagihBulanLalu) * 100 : ($harusDitagihBulanIni > 0 ? 100 : 0);

            // 3. Total Pembayaran Penagihan
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

            // 4. Total Kunjungan Sales
            $kunjunganBulanIni = KunjunganSales::where('sales_id', $salesId)
                ->whereBetween('tanggal_kunjungan', [$startOfMonth, $endOfMonth])
                ->count();
            $kunjunganBulanLalu = KunjunganSales::where('sales_id', $salesId)
                ->whereBetween('tanggal_kunjungan', [$startOfLastMonth, $endOfLastMonth])
                ->count();
            $kunjunganGrowth = $kunjunganBulanLalu > 0 ? (($kunjunganBulanIni - $kunjunganBulanLalu) / $kunjunganBulanLalu) * 100 : ($kunjunganBulanIni > 0 ? 100 : 0);
        }

        return [
            [
                'label' => 'Total Penjualan',
                'value' => 'Rp ' . number_format($penjualanBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($penjualanGrowth), 1, ',', '.') . '% dari bulan lalu',
                'trend_up' => $penjualanGrowth >= 0,
                'icon_bg' => '#dcfce7',
                'icon_color' => '#22c55e',
                'icon' => 'shopping-bag',
            ],
            [
                'label' => 'Total Harus Ditagih',
                'value' => 'Rp ' . number_format($harusDitagihBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($harusDitagihGrowth), 1, ',', '.') . '% dari bulan lalu',
                'trend_up' => $harusDitagihGrowth <= 0, // Less is better for outstanding
                'icon_bg' => '#fef9c3',
                'icon_color' => '#eab308',
                'icon' => 'document-text',
            ],
            [
                'label' => 'Total Pembayaran',
                'value' => 'Rp ' . number_format($pembayaranBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($pembayaranGrowth), 1, ',', '.') . '% dari bulan lalu',
                'trend_up' => $pembayaranGrowth >= 0,
                'icon_bg' => '#dbeafe',
                'icon_color' => '#3b82f6',
                'icon' => 'banknotes',
            ],
            [
                'label' => 'Total Kunjungan',
                'value' => number_format($kunjunganBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($kunjunganGrowth), 1, ',', '.') . '% dari bulan lalu',
                'trend_up' => $kunjunganGrowth >= 0,
                'icon_bg' => '#fee2e2',
                'icon_color' => '#ef4444',
                'icon' => 'users',
            ],
        ];
    }
}
