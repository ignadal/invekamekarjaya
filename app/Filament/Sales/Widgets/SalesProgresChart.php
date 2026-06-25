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

    protected function getData(): array
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $tagihanBulanIni = Penjualan::where('sales_id', $salesId)
            ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
            ->sum('total_penjualan');
            
        $pembayaranBulanIni = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                $q->where('sales_id', $salesId);
            })
            ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
            ->sum('nominal');

        $belumTerbayar = $tagihanBulanIni - $pembayaranBulanIni;
        if ($belumTerbayar < 0) $belumTerbayar = 0;

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [$pembayaranBulanIni, $belumTerbayar],
                    'backgroundColor' => ['#16a34a', '#dc2626'], // Green for paid, Red for unpaid
                ],
            ],
            'labels' => ['Terbayar', 'Belum Terbayar'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
