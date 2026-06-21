<?php

namespace App\Filament\Resources\PembelianSuppliers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class PembelianSupplierForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema
        ->components([
            Section::make('Data Pembelian')
                ->schema([

                    Grid::make(2)
                        ->schema([

                            DatePicker::make('tanggal_pembelian')
                                ->required(),

                            Select::make('supplier_id')
                                ->relationship('supplier', 'nama_supplier')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Select::make('metode')
                                ->options([
                                    'lunas' => 'Lunas',
                                    'nyicil' => 'Nyicil',
                                ])
                                ->required(),

                            DatePicker::make('jatuh_tempo'),

                            TextInput::make('sudah_dibayar')
                                ->numeric()
                                ->default(0),

                            TextInput::make('sisa_pembayaran')
                                ->numeric()
                                ->default(0),

                        ]),
                ]),

            Section::make('Daftar Barang')
                ->schema([

                    Repeater::make('details')
                        ->relationship()
                        ->schema([

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

                        ])
                        ->columns(4),

                    TextInput::make('total_pembelian')
                        ->numeric()
                        ->default(0)
                        ->required(),

                ]),
        ]);
    }
}
