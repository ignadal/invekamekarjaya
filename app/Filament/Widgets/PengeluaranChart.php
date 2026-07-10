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

            $pengeluaranSupplierLunas = PembelianSupplier::where('metode', 'lunas')
                ->when($tahun, fn($q) => $q->whereYear('tanggal_pembelian', $tahun))
                ->whereMonth('tanggal_pembelian', $i)
                ->sum('total_pembelian');
                
            $pengeluaranSupplierNyicil = PembelianSupplier::where('metode', 'nyicil')
                ->when($tahun, fn($q) => $q->whereYear('tanggal_pembelian', $tahun))
                ->whereMonth('tanggal_pembelian', $i)
                ->sum('sudah_dibayar');

            $gaji = PayrollSales::where('status_pembayaran', 'sudah_digaji')
                ->when($tahun, fn($q) => $q->where('tahun', $tahun))
                ->where('bulan', $i)
                ->sum('total_gaji');

            $data[] = (float) ($pengeluaranSupplierLunas + $pengeluaranSupplierNyicil + $gaji);
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
                ],
            ],
            'colors' => ['#dc2626'],
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
                ],
            ],
            'grid' => [
                'borderColor' => '#f1f1f1',
                'strokeDashArray' => 4,
            ],
        ];
    }

    protected function extraJsOptions(): ?\Filament\Support\RawJs
    {
        return \Filament\Support\RawJs::make(<<<'JS'
        {
            yaxis: {
                labels: {
                    formatter: function (val, index) {
                        return 'Rp ' + Number(val).toLocaleString('id-ID');
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return 'Rp ' + Number(val).toLocaleString('id-ID');
                    }
                }
            }
        }
        JS);
    }
}
