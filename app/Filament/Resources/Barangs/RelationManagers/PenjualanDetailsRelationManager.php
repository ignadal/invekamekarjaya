<?php

namespace App\Filament\Resources\Barangs\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PenjualanDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'penjualanDetails';
    protected static ?string $title = 'Riwayat Penjualan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('penjualan_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('penjualan_id')
            ->columns([
                Tables\Columns\TextColumn::make('penjualan.tanggal_beli')
                    ->label('Tanggal Penjualan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_jual')
                    ->label('Harga Jual Saat Itu')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // No create action
            ])
            ->actions([
                // No edit/delete action
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('penjualan.tanggal_beli', 'desc');
    }
}
