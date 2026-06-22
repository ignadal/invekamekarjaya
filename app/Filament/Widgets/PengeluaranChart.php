<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\PembelianSupplier;
use App\Models\PayrollSales;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

class PengeluaranChart extends ApexChartWidget
{
    protected static ?string $chartId = 'pengeluaranChart';
    protected static ?string $heading = 'Grafik Pengeluaran Per Bulan';
    protected static ?int $sort = 3;
    protected static bool $isLazy = true;

    public ?string $bulan = null;
    public ?string $tahun = null;

    #[On('dashboard-filter-changed')]
    public function updateFilter(?string $bulan, ?string $tahun): void
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun ?: now()->year;
        $this->updateOptions();
    }

    protected function getOptions(): array
    {
        $tahun = $this->tahun ?: now()->year;

        $data = [];
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create($tahun, $i, 1);
            $months[] = $month->translatedFormat('M');

            $pembelian = PembelianSupplier::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->sum('total_pembelian');

            $gaji = PayrollSales::where('tahun', $tahun)
                ->where('bulan', $i)
                ->sum('total_gaji');

            $data[] = $pembelian + $gaji;
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
                    'name' => 'Total Pengeluaran',
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
            'colors' => ['#b91c1c'],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'light',
                    'type' => 'vertical',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => ['#fca5a5'],
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
