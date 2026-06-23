<?php

namespace App\Filament\Widgets;

use App\Models\Sales;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class TopSalesWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public ?string $bulan = null;
    public ?string $tahun = null;

    #[On('dashboard-filter-changed')]
    public function updateFilter(?string $bulan = null, ?string $tahun = null): void
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->resetTable();
    }

    public function table(Table $table): Table
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;

        return $table
            ->query(
                Sales::query()
                    ->whereHas('penjualans', function ($query) use ($bulan, $tahun) {
                        $query->where('status_persetujuan', 'disetujui')
                              ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
                              ->when($bulan, fn($q) => $q->whereMonth('tanggal_beli', $bulan));
                    })
                    ->withSum(['penjualans' => function ($query) use ($bulan, $tahun) {
                        $query->where('status_persetujuan', 'disetujui')
                              ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
                              ->when($bulan, fn($q) => $q->whereMonth('tanggal_beli', $bulan));
                    }], 'total_penjualan')
                    ->orderByDesc('penjualans_sum_total_penjualan')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_sales')
                    ->label('Nama Sales')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP'),
                Tables\Columns\TextColumn::make('penjualans_sum_total_penjualan')
                    ->label('Total Penjualan (Disetujui)')
                    ->money('IDR')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),
            ])
            ->defaultPaginationPageOption(5)
            ->heading('Performa Sales (Top Sales)');
    }
}
