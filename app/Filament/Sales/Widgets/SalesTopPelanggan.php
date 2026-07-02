<?php

namespace App\Filament\Sales\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Sales;
use App\Models\Buyer;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class SalesTopPelanggan extends BaseWidget
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

    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 1;

    protected static ?string $heading = 'Top 5 Toko Teraktif';

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
                    Daftar 5 pelanggan/toko dengan total nilai transaksi pesanan terbesar bulan ini.
                </div>
            </div>
        ');
    }

    public function table(Table $table): Table
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $targetDate = now();
        if ($this->filterBulan && $this->filterTahun) {
            $targetDate = now()->setDate((int) $this->filterTahun, (int) $this->filterBulan, 1);
        }

        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();

        // Query buyers who have purchased from this sales this month
        $query = Buyer::query()
            ->whereHas('penjualans', function (Builder $query) use ($salesId, $startOfMonth, $endOfMonth) {
                $query->where('sales_id', $salesId)
                      ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth]);
            })
            ->withSum(['penjualans' => function ($query) use ($salesId, $startOfMonth, $endOfMonth) {
                $query->where('sales_id', $salesId)
                      ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth]);
            }], 'total_penjualan')
            ->orderByDesc('penjualans_sum_total_penjualan')
            ->limit(5);

        return $table
            ->heading("Top 5 Toko Teraktif {$this->periodeLabel}")
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('nama_toko')
                    ->label('Toko')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_owner')
                    ->label('Pemilik'),
                Tables\Columns\TextColumn::make('penjualans_sum_total_penjualan')
                    ->label('Total Transaksi')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
