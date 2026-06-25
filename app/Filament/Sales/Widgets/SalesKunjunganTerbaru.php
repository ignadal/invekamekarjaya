<?php

namespace App\Filament\Sales\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\KunjunganSales;
use App\Models\Sales;

class SalesKunjunganTerbaru extends BaseWidget
{
    protected static ?string $heading = 'Kunjungan Terbaru';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        return $table
            ->query(
                KunjunganSales::query()
                    ->where('sales_id', $salesId)
                    ->latest('tanggal_kunjungan')
                    ->latest('created_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('buyer.nama_toko')
                    ->label('Toko')
                    ->description(fn (KunjunganSales $record): string => $record->tanggal_kunjungan ? $record->tanggal_kunjungan->translatedFormat('d F Y') : '')
                    ->icon('heroicon-o-building-storefront'),
                Tables\Columns\TextColumn::make('buyer.kecamatan.nama_kecamatan')
                    ->label('Lokasi')
                    ->badge()
                    ->color('info')
                    ->alignEnd(),
            ])
            ->paginated(false);
    }
}
