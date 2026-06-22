<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Penjualan;
use App\Models\PembelianSupplier;
use App\Models\PayrollSales;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

class LabaChart extends ApexChartWidget
{
    protected static ?string $chartId = 'labaChart';
    protected static ?string $heading = 'Grafik Laba (Pemasukan - Pengeluaran)';
    protected static ?int $sort = 2;
    protected static bool $isLazy = true;
    protected int | string | array $columnSpan = 'full';

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

            $omset = Penjualan::where('status_persetujuan', 'disetujui')
                ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
                ->whereMonth('tanggal_beli', $i)
                ->sum('total_penjualan');

            $pembelian = PembelianSupplier::when($tahun, fn($q) => $q->whereYear('created_at', $tahun))
                ->whereMonth('created_at', $i)
                ->sum('total_pembelian');

            $gaji = PayrollSales::when($tahun, fn($q) => $q->where('tahun', $tahun))
                ->where('bulan', $i)
                ->sum('total_gaji');

            $data[] = (float) ($omset - ($pembelian + $gaji));
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
                    'name' => 'Total Laba',
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
            'colors' => ['#991b1b'],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'light',
                    'type' => 'vertical',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => ['#fecaca'],
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