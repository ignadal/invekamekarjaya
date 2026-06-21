<?php

namespace App\Filament\Resources\PembelianSuppliers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PembelianSuppliersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_pembelian')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('supplier.nama_supplier')
                    ->label('Supplier')
                    ->searchable(),

                TextColumn::make('metode')
                    ->badge(),

                TextColumn::make('total_pembelian')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('sudah_dibayar')
                    ->money('IDR'),

                TextColumn::make('sisa_pembayaran')
                    ->money('IDR'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'lunas' => 'success',
                        'sebagian' => 'warning',
                        'belum_dibayar' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
