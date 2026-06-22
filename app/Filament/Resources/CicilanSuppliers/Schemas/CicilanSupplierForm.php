<?php

namespace App\Filament\Resources\CicilanSuppliers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CicilanSupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Cicilan')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                Select::make('pembelian_supplier_id')
                                    ->relationship('pembelianSupplier', 'id')
                                    ->getOptionLabelFromRecordUsing(
                                        fn ($record) =>
                                            $record->supplier->nama_supplier .
                                            ' - ' .
                                            number_format($record->total_pembelian, 0, ',', '.')
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),

                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                DatePicker::make('tanggal_bayar')
                                    ->required(),

                                TextInput::make('nominal')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rp'),
                            ]),

                        Textarea::make('catatan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
