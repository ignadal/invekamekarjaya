<?php

namespace App\Filament\Resources\Sales\Pages;

use App\Filament\Resources\Sales\SalesResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Models\Sales;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Penjualan;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Sum;

class PerformaSales extends Page implements HasTable
{
    use InteractsWithRecord;
    use InteractsWithTable;

    protected static string $resource = SalesResource::class;

    protected string $view = 'filament.resources.sales.pages.performa-sales';

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Performa Sales - ' . $this->record->nama_sales;
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Penjualan::query()->where('sales_id', $this->record->id)
            )
            ->defaultSort('tanggal_beli', 'desc')
            ->columns([
                TextColumn::make('tanggal_beli')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('buyer.nama_toko')
                    ->label('Toko/Buyer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('buyer.kecamatan.nama_kecamatan')
                    ->label('Kecamatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_penjualan')
                    ->label('Penjualan')
                    ->money('IDR')
                    ->sortable()
                    ->summarize(Sum::make()->money('IDR')->label('Total Penjualan')),
            ])
            ->filters([
                SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->query(function ($query, array $data) {
                        if (! empty($data['value'])) {
                            $query->whereMonth('tanggal_beli', $data['value']);
                        }
                    }),
                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(function () {
                        $years = range(2024, now()->year);
                        return array_combine($years, $years);
                    })
                    ->query(function ($query, array $data) {
                        if (! empty($data['value'])) {
                            $query->whereYear('tanggal_beli', $data['value']);
                        }
                    }),
            ]);
    }
}
