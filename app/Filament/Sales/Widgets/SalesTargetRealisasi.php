<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\Sales;
use App\Models\Penjualan;

class SalesTargetRealisasi extends Widget
{
    protected string $view = 'filament.sales.widgets.sales-target-realisasi';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 2;

    public function getTargetRealisasiProperty()
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        // Assuming fixed target 150.000.000 for demo, or could be fetched from DB if exists
        $target = 150000000;
        
        $realisasi = Penjualan::where('sales_id', $salesId)
            ->whereMonth('tanggal_beli', now()->month)
            ->whereYear('tanggal_beli', now()->year)
            ->sum('total_penjualan');

        $percentage = $target > 0 ? ($realisasi / $target) * 100 : 0;
        if ($percentage > 100) $percentage = 100;

        return [
            'target' => $target,
            'realisasi' => $realisasi,
            'percentage' => round($percentage, 1),
        ];
    }
}
