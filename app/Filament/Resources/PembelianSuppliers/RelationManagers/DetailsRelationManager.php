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
use Filament\Forms\Get;
use Filament\Forms\Set;

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
                TextInput::make('qty')
                    ->numeric()
                    ->live()
                    ->required()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set(
                            'subtotal',
                            ((float) $get('qty')) * ((float) $get('harga_beli'))
                        );
                    }),

                TextInput::make('harga_beli')
                    ->numeric()
                    ->live()
                    ->required()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set(
                            'subtotal',
                            ((float) $get('qty')) * ((float) $get('harga_beli'))
                        );
                    }),

                TextInput::make('subtotal')
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}