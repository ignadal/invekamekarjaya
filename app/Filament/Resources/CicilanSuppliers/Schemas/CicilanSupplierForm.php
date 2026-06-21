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
            ->components([
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

                DatePicker::make('tanggal_bayar')
                    ->required(),

                TextInput::make('nominal')
                    ->numeric()
                    ->required(),

                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
