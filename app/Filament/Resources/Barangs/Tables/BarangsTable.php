<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class BarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('foto')
                    ->square(),

                TextColumn::make('nama_barang')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('harga_jual')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('stok')
                    ->badge()
                    ->color(fn ($record) =>
                        $record->stok <= $record->stok_minimum
                            ? 'danger'
                            : 'success'
                    ),

                TextColumn::make('stok_minimum')
                    ->label('Min. Stok'),



                TextColumn::make('ukuran')
                    ->badge(),

                TextColumn::make('berat')
                    ->badge(),

            ])
            ->filters([
                SelectFilter::make('kategori_barang_id')
                    ->relationship('kategori', 'nama_kategori'),

                TrashedFilter::make(),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()->iconButton()->tooltip('Detail Barang'),
                \Filament\Actions\EditAction::make()->iconButton()->tooltip('Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
