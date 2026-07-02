<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\Sales;
use App\Models\Penjualan;
use Livewire\Attributes\On;

class SalesTargetRealisasi extends Widget
{
    protected string $view = 'filament.sales.widgets.sales-target-realisasi';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;

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

    public function getTargetRealisasiProperty()
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        // Targets
        $target1 = 75000000;  // 75 Juta -> 0.5%
        $target2 = 100000000; // 100 Juta -> 1%
        
        $targetDate = now();
        if ($this->filterBulan && $this->filterTahun) {
            $targetDate = now()->setDate((int) $this->filterTahun, (int) $this->filterBulan, 1);
        }

        $realisasi = \App\Models\CicilanBuyer::whereHas('penjualan', function ($query) use ($salesId) {
                $query->where('sales_id', $salesId);
            })
            ->whereMonth('tanggal_bayar', $targetDate->month)
            ->whereYear('tanggal_bayar', $targetDate->year)
            ->sum('nominal');

        $percentage1 = $target1 > 0 ? ($realisasi / $target1) * 100 : 0;
        if ($percentage1 > 100) $percentage1 = 100;

        $percentage2 = $target2 > 0 ? ($realisasi / $target2) * 100 : 0;
        if ($percentage2 > 100) $percentage2 = 100;
        
        // Calculate estimated bonus
        $estimatedBonus = 0;
        if ($realisasi >= $target2) {
            $estimatedBonus = $realisasi * 0.01; // 1%
        } elseif ($realisasi >= $target1) {
            $estimatedBonus = $realisasi * 0.005; // 0.5%
        }

        return [
            'target1' => $target1,
            'target2' => $target2,
            'realisasi' => $realisasi,
            'percentage1' => round($percentage1, 1),
            'percentage2' => round($percentage2, 1),
            'estimated_bonus' => $estimatedBonus,
        ];
    }
}
