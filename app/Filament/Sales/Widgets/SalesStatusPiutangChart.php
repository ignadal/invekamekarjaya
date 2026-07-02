<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\Sales;
use App\Models\Penjualan;
use Livewire\Attributes\On;

class SalesStatusPiutangChart extends Widget
{
    protected string $view = 'filament.sales.widgets.sales-status-piutang-chart';

    public ?string $filterBulan = null;
    public ?string $filterTahun = null;
    public string $periodeLabel = '';

    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

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

    protected function getViewData(): array
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $targetDate = now();
        if ($this->filterBulan && $this->filterTahun) {
            $targetDate = now()->setDate((int) $this->filterTahun, (int) $this->filterBulan, 1);
        }

        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();

        $lunasCount = 0;
        $belumLunasCount = 0;

        if ($salesId) {
            $lunasCount = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->where('status_bayar', 'lunas')
                ->count();
                
            $belumLunasCount = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->where('status_bayar', '!=', 'lunas')
                ->count();
        }

        $totalCount = $lunasCount + $belumLunasCount;
        $lunasPct = $totalCount > 0 ? round(($lunasCount / $totalCount) * 100) : 0;
        $belumLunasPct = $totalCount > 0 ? round(($belumLunasCount / $totalCount) * 100) : 0;
        
        // Adjust for exactly 100% logic to avoid 99% or 101% due to rounding if needed, but since it's just two it's fine if we do 100 - $lunasPct
        if ($totalCount > 0) {
            $belumLunasPct = 100 - $lunasPct;
        }

        return [
            'lunasPct' => $lunasPct,
            'belumLunasPct' => $belumLunasPct,
            'totalCount' => $totalCount
        ];
    }
}
