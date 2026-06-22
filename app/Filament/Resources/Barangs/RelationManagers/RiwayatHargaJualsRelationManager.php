<?php

namespace App\Filament\Resources\Barangs\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RiwayatHargaJualsRelationManager extends RelationManager
{
    protected static string $relationship = 'riwayatHargaJuals';
    protected static ?string $title = 'Riwayat Harga';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('harga_lama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Riwayat Harga Jual')
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('tanggal_berubah')
                    ->label('Tanggal Berubah')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('harga_lama')
                    ->label('Harga Lama')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('harga_baru')
                    ->label('Harga Baru')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->defaultSort('tanggal_berubah', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
