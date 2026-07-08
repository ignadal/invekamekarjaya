<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Sales;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;
use Livewire\Attributes\On;

class SalesProgresChart extends ChartWidget
{
    public ?string $filterBulan = null;
    public ?string $filterTahun = null;
    public string $periodeLabel = '';

    public function mount(): void
    {
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $this->periodeLabel = $namaBulan[now()->month - 1] . ' ' . now()->year;
    }

    #[On('sales-dashboard-filter-changed')]
    public function updateFilter(?string $bulan, ?string $tahun): void
    {
        $this->filterBulan = $bulan;
        $this->filterTahun = $tahun;

        if ($bulan && $tahun) {
            $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $this->periodeLabel = $namaBulan[$bulan - 1] . ' ' . $tahun;
        } else {
            $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $this->periodeLabel = $namaBulan[now()->month - 1] . ' ' . now()->year;
        }
    }

    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        return "Total Penjualan dan Penagihan {$this->periodeLabel}";
    }

    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected string $view = 'filament.sales.widgets.sales-progres-chart';
    
    protected ?string $maxHeight = '300px';

    protected ?string $heading = 'Total Penjualan dan Penagihan';

    public function getDescription(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        return new \Illuminate\Support\HtmlString('
            <div x-data="{ open: false }" style="position: relative; display: inline-flex; align-items: center; margin-top: 0.25rem;">
                <button type="button" @click.stop="open = !open" style="outline: none; background: none; border: none; cursor: pointer; padding: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af" style="width: 1.25rem; height: 1.25rem;">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; z-index: 9999; width: 220px; background-color: #1f2937; color: #f9fafb; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: normal; line-height: 1.4; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); top: 100%; left: 1.5rem; white-space: normal;">
                    <div style="position: absolute; top: 10px; left: -5px; width: 10px; height: 10px; background-color: #1f2937; transform: rotate(45deg);"></div>
                    Membandingkan tren nilai total pesanan baru vs uang cicilan yang masuk dari minggu ke minggu.
                </div>
            </div>
        ');
    }

    protected function getData(): array
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $targetDate = now();
        if ($this->filterBulan && $this->filterTahun) {
            $targetDate = now()->setDate((int) $this->filterTahun, (int) $this->filterBulan, 1);
        }

        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();

        // Generate dynamic labels with date ranges
        $namaBulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $monthName = $namaBulanList[$targetDate->month - 1] . ' ' . $targetDate->year;
        $endOfMonthDay = $endOfMonth->day;

        $labels = [
            ["Minggu 1", "(1-7 $monthName)"],
            ["Minggu 2", "(8-14 $monthName)"],
            ["Minggu 3", "(15-21 $monthName)"],
            ["Minggu 4", "(22-$endOfMonthDay $monthName)"],
        ];
        $tagihanData = [0, 0, 0, 0];
        $pembayaranData = [0, 0, 0, 0];

        if ($salesId) {
            // 1. Tagihan (Total Penjualan)
            $penjualans = Penjualan::where('sales_id', $salesId)
                ->where('status_persetujuan', 'disetujui')
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->get();

            foreach ($penjualans as $p) {
                $weekNum = min(3, (int) floor(($p->tanggal_beli->day - 1) / 7));
                $tagihanData[$weekNum] += $p->total_penjualan;
            }

            // 2. Pembayaran (Cicilan + Lunas)
            $pembayarans = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                    $q->where('sales_id', $salesId)->where('status_persetujuan', 'disetujui');
                })
                ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
                ->get();

            foreach ($pembayarans as $p) {
                $weekNum = min(3, (int) floor(($p->tanggal_bayar->day - 1) / 7));
                $pembayaranData[$weekNum] += $p->nominal;
            }
            
            $penjualanLunas = Penjualan::where('sales_id', $salesId)
                ->where('status_persetujuan', 'disetujui')
                ->where('metode', 'lunas')
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->get();
                
            foreach ($penjualanLunas as $p) {
                $weekNum = min(3, (int) floor(($p->tanggal_beli->day - 1) / 7));
                $pembayaranData[$weekNum] += $p->total_penjualan;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $tagihanData,
                    'backgroundColor' => '#fca5a5',
                    'borderColor' => '#ef4444',
                    'borderWidth' => 1,
                    'categoryPercentage' => 0.7,
                    'barPercentage' => 0.9,
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Total Pembayaran',
                    'data' => $pembayaranData,
                    'backgroundColor' => '#86efac', // Green-300
                    'borderColor' => '#22c55e', // Green-500
                    'borderWidth' => 1,
                    'categoryPercentage' => 0.7,
                    'barPercentage' => 0.9,
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
