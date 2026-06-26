<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Sales;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;

class SalesProgresChart extends ChartWidget
{
    protected ?string $heading = 'Progres Tagihan vs Pembayaran (Bulan Ini)';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Get weekly data
        $labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        $tagihanData = [0, 0, 0, 0];
        $pembayaranData = [0, 0, 0, 0];

        if ($salesId) {
            // Get all penjualan this month grouped by week
            $penjualans = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->get();

            $cumulativeTagihan = 0;
            foreach ($penjualans as $p) {
                $weekNum = min(3, (int) floor(($p->tanggal_beli->day - 1) / 7));
                $cumulativeTagihan += $p->total_penjualan;
                for ($i = $weekNum; $i < 4; $i++) {
                    $tagihanData[$i] = $cumulativeTagihan;
                }
            }

            // Get all pembayaran this month grouped by week
            $pembayarans = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                    $q->where('sales_id', $salesId);
                })
                ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
                ->get();

            $cumulativePembayaran = 0;
            foreach ($pembayarans as $p) {
                $weekNum = min(3, (int) floor(($p->tanggal_bayar->day - 1) / 7));
                $cumulativePembayaran += $p->nominal;
                for ($i = $weekNum; $i < 4; $i++) {
                    $pembayaranData[$i] = $cumulativePembayaran;
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Tagihan',
                    'data' => $tagihanData,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'transparent',
                    'pointBackgroundColor' => '#ef4444',
                    'pointRadius' => 5,
                    'tension' => 0.3,
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Total Pembayaran',
                    'data' => $pembayaranData,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'transparent',
                    'pointBackgroundColor' => '#22c55e',
                    'pointRadius' => 5,
                    'tension' => 0.3,
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
