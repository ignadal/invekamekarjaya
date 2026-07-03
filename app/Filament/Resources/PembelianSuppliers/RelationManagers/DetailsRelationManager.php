<?php

namespace App\Filament\Resources\PembelianSuppliers\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('barang_id')
                    ->relationship('barang', 'nama_barang')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('qty')
                    ->numeric()
                    ->required(),

                TextInput::make('harga_beli')
                    ->numeric()
                    ->required(),

                TextInput::make('subtotal')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barang.nama_barang')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('harga_beli')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\DeleteAction::make()->requiresConfirmation(),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                ->label('')
                ->icon('heroicon-o-plus')
                ->tooltip('Tambah Data'),
            ]);
    }
}