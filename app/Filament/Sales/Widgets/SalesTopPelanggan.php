<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\Sales;
use App\Models\Buyer;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class SalesTopPelanggan extends Widget
{
    protected string $view = 'filament.sales.widgets.sales-top-pelanggan';

    public ?string $filterBulan = null;
    public ?string $filterTahun = null;
    public string $periodeLabel = '';
    public string $search = '';

    protected static ?int $sort = 5;
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

    public function getTopPelangganProperty()
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        if (!$salesId) {
            return collect();
        }

        $targetDate = now();
        if ($this->filterBulan && $this->filterTahun) {
            $targetDate = now()->setDate((int) $this->filterTahun, (int) $this->filterBulan, 1);
        }

        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();

        return Buyer::query()
            ->whereHas('penjualans', function (Builder $query) use ($salesId, $startOfMonth, $endOfMonth) {
                $query->where('sales_id', $salesId)
                      ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth]);
            })
            ->when($this->search, function ($query) {
                $query->where('nama_toko', 'like', '%' . $this->search . '%')
                      ->orWhere('nama_owner', 'like', '%' . $this->search . '%');
            })
            ->withSum(['penjualans' => function ($query) use ($salesId, $startOfMonth, $endOfMonth) {
                $query->where('sales_id', $salesId)
                      ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth]);
            }], 'total_penjualan')
            ->orderByDesc('penjualans_sum_total_penjualan')
            ->limit(5)
            ->get();
    }

    public function getAllPelangganProperty()
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        if (!$salesId) {
            return collect();
        }

        $targetDate = now();
        if ($this->filterBulan && $this->filterTahun) {
            $targetDate = now()->setDate((int) $this->filterTahun, (int) $this->filterBulan, 1);
        }

        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();

        return Buyer::query()
            ->whereHas('penjualans', function (Builder $query) use ($salesId, $startOfMonth, $endOfMonth) {
                $query->where('sales_id', $salesId)
                      ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth]);
            })
            ->when($this->search, function ($query) {
                $query->where('nama_toko', 'like', '%' . $this->search . '%')
                      ->orWhere('nama_owner', 'like', '%' . $this->search . '%');
            })
            ->withSum(['penjualans' => function ($query) use ($salesId, $startOfMonth, $endOfMonth) {
                $query->where('sales_id', $salesId)
                      ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth]);
            }], 'total_penjualan')
            ->orderByDesc('penjualans_sum_total_penjualan')
            ->get();
    }
}
