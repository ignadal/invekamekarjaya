<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Penjualan;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

class PenjualanChart extends ApexChartWidget
{
    protected static ?string $chartId = 'penjualanChart';
    protected static ?string $heading = 'Grafik Penjualan Per Bulan';
    protected static ?int $sort = 4;
    protected static bool $isLazy = true;

    public ?string $bulan = null;
    public ?string $tahun = null;

    #[On('dashboard-filter-changed')]
    public function updateFilter(?string $bulan, ?string $tahun): void
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->updateOptions();
    }

    protected function getOptions(): array
    {
        $tahun = $this->tahun;

        $data = [];
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create($tahun ?: now()->year, $i, 1);
            $months[] = $month->translatedFormat('M');

            $total = Penjualan::where('status_persetujuan', 'disetujui')
                ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
                ->whereMonth('tanggal_beli', $i)
                ->sum('total_penjualan');

            $data[] = $total;
        }

        return [
            'chart' => [
                'type' => 'area',
                'height' => 300,
                'toolbar' => ['show' => true],
                'zoom' => ['enabled' => true],
            ],
            'series' => [
                [
                    'name' => 'Total Penjualan',
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $months,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                    'formatter' => 'function (val) { return "Rp " + new Intl.NumberFormat("id-ID").format(val); }',
                ],
            ],
            'colors' => ['#ef4444'],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'light',
                    'type' => 'vertical',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => ['#fee2e2'],
                    'opacityFrom' => 0.7,
                    'opacityTo' => 0.1,
                ],
            ],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 3,
            ],
            'dataLabels' => ['enabled' => false],
            'tooltip' => [
                'y' => [
                    'formatter' => 'function (val) { return "Rp " + new Intl.NumberFormat("id-ID").format(val); }',
                ],
            ],
            'grid' => [
                'borderColor' => '#f1f1f1',
                'strokeDashArray' => 4,
            ],
        ];
    }
}
