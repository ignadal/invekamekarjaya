<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\KunjunganSales;

class SalesMonthlyPerformanceChart extends ChartWidget
{
    protected ?string $heading = 'Performa Penjualan (Tahun Ini)';
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '250px';
    protected static bool $isDiscovered = false;

    protected function getData(): array
    {
        $sales = \App\Models\Sales::where('user_id', auth()->id())->first();
        
        // Fallback khusus untuk superadmin yang sedang melakukan testing
        if (!$sales && auth()->user()->name === 'superadmin') {
            $sales = \App\Models\Sales::first();
        }
        
        // Data default (0) untuk 12 bulan
        $monthlyData = array_fill(0, 12, 0);

        if ($sales) {
            // Ambil total penjualan (dalam Rp) dari data PayrollSales di tahun ini
            $payroll = \App\Models\PayrollSales::where('sales_id', $sales->id)
                ->where('tahun', now()->year)
                ->get();
                
            foreach ($payroll as $p) {
                // Index array dari 0 (Jan = 0, Feb = 1, dsb)
                $monthlyData[$p->bulan - 1] = $p->total_penjualan ?? 0;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan (Rp)',
                    'data' => $monthlyData,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
