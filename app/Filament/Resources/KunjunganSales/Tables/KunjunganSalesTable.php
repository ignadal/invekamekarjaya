<?php

namespace App\Filament\Resources\KunjunganSales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KunjunganSalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->StackedOnMobile()
            ->columns([
                TextColumn::make('tanggal_kunjungan')
                    ->date()
                    ->sortable(),
                TextColumn::make('sales.nama_sales')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('buyer.nama_toko')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hasil_kunjungan')
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'order' => 'success',
                        'tidak_order' => 'danger',
                        'toko_tutup' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actionsColumnLabel('Aksi')
            ->recordActions([
                \Filament\Actions\Action::make('lihat_foto')
                    ->label('Foto')
                    ->icon('heroicon-o-camera')
                    ->button()
                    ->outlined()
                    ->color('danger')
                    ->modalHeading('Foto & Catatan Kunjungan')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->infolist([
                        \Filament\Infolists\Components\ImageEntry::make('foto')
                            ->hiddenLabel()
                            ->disk('public')
                            ->extraImgAttributes(['style' => 'width: 100%; height: 100%; object-fit: contain;']),
                        \Filament\Infolists\Components\TextEntry::make('catatan')
                            ->label('Catatan/Deskripsi'),
                    ]),
                EditAction::make()->iconButton()->label(''),
                \Filament\Actions\DeleteAction::make()->iconButton()->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
