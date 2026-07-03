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
        ->columns(1)
        ->components([
            Section::make('Data Pembelian')
                ->schema([

                    Grid::make(1)
                        ->schema([

                            DatePicker::make('tanggal_pembelian')
                                ->required()
                                ->minDate(today()->subDays(7))
                                ->maxDate(today())
                                ->disabled(fn (string $operation) => $operation === 'edit'),

                            Select::make('supplier_id')
                                ->relationship('supplier', 'nama_supplier')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->disabled(fn (string $operation) => $operation === 'edit'),

                            Select::make('metode')
                                ->options([
                                    'lunas' => 'Lunas',
                                    'nyicil' => 'Nyicil',
                                ])
                                ->required()
                                ->live()
                                ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) {
                                    if ($state === 'lunas') {
                                        $set('sudah_dibayar', $get('total_pembelian') ?? 0);
                                        $set('sisa_pembayaran', 0);
                                    } else {
                                        $set('sudah_dibayar', 0);
                                        $set('sisa_pembayaran', $get('total_pembelian') ?? 0);
                                    }
                                })
                                ->disabled(fn (string $operation) => $operation === 'edit'),

                            DatePicker::make('jatuh_tempo')
                                ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('metode') === 'nyicil')
                                ->required(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('metode') === 'nyicil')
                                ->minDate(today())
                                ->disabled(fn (string $operation) => $operation === 'edit'),

                            TextInput::make('sudah_dibayar')
                                ->numeric()
                                ->default(0)
                                ->live(debounce: 500)
                                ->readOnly(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('metode') === 'lunas')
                                ->disabled(fn (string $operation) => $operation === 'edit')
                                ->dehydrated()
                                ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) {
                                    $set('sisa_pembayaran', (int)$get('total_pembelian') - (int)$state);
                                }),

                            TextInput::make('sisa_pembayaran')
                                ->numeric()
                                ->default(0)
                                ->readOnly()
                                ->dehydrated(),

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
                                ->required()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->live()
                                ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) {
                                    if ($state) {
                                        $barang = \App\Models\Barang::find($state);
                                        if ($barang) {
                                            $set('harga_beli', $barang->harga_beli_terakhir);
                                            // Trigger subtotal calculation
                                            $set('subtotal', $barang->harga_beli_terakhir * (int)$get('qty'));
                                            
                                            // Recalculate totals
                                            $details = $get('../../details');
                                            $total = 0;
                                            if (is_array($details)) {
                                                foreach ($details as $item) {
                                                    $total += (int) ($item['subtotal'] ?? 0);
                                                }
                                            }
                                            $set('../../total_pembelian', $total);
                                            if ($get('../../metode') === 'lunas') {
                                                $set('../../sudah_dibayar', $total);
                                                $set('../../sisa_pembayaran', 0);
                                            } else {
                                                $set('../../sisa_pembayaran', $total - (int)$get('../../sudah_dibayar'));
                                            }
                                        }
                                    }
                                }),

                            TextInput::make('qty')
                                ->numeric()
                                ->required()
                                ->default(1)
                                ->live(debounce: 500)
                                ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) {
                                    $set('subtotal', $state * (int)$get('harga_beli'));
                                    $details = $get('../../details');
                                    $total = 0;
                                    if (is_array($details)) {
                                        foreach ($details as $item) {
                                            $total += (int) ($item['subtotal'] ?? 0);
                                        }
                                    }
                                    $set('../../total_pembelian', $total);
                                    if ($get('../../metode') === 'lunas') {
                                        $set('../../sudah_dibayar', $total);
                                        $set('../../sisa_pembayaran', 0);
                                    } else {
                                        $set('../../sisa_pembayaran', $total - (int)$get('../../sudah_dibayar'));
                                    }
                                }),

                            TextInput::make('harga_beli')
                                ->numeric()
                                ->required()
                                ->live(debounce: 500)
                                ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) {
                                    $set('subtotal', $state * (int)$get('qty'));
                                    $details = $get('../../details');
                                    $total = 0;
                                    if (is_array($details)) {
                                        foreach ($details as $item) {
                                            $total += (int) ($item['subtotal'] ?? 0);
                                        }
                                    }
                                    $set('../../total_pembelian', $total);
                                    if ($get('../../metode') === 'lunas') {
                                        $set('../../sudah_dibayar', $total);
                                        $set('../../sisa_pembayaran', 0);
                                    } else {
                                        $set('../../sisa_pembayaran', $total - (int)$get('../../sudah_dibayar'));
                                    }
                                }),

                            TextInput::make('subtotal')
                                ->numeric()
                                ->required()
                                ->readOnly()
                                ->default(0),

                        ])
                        ->columns(1)
                        ->live(debounce: 500)
                        ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Get $get, \Filament\Schemas\Components\Utilities\Set $set) {
                            $total = 0;
                            foreach ((array) $get('details') as $item) {
                                $total += (int) ($item['subtotal'] ?? 0);
                            }
                            $set('total_pembelian', $total);
                            if ($get('metode') === 'lunas') {
                                $set('sudah_dibayar', $total);
                                $set('sisa_pembayaran', 0);
                            } else {
                                $set('sisa_pembayaran', $total - (int)$get('sudah_dibayar'));
                            }
                        }),

                    TextInput::make('total_pembelian')
                        ->numeric()
                        ->default(0)
                        ->readOnly()
                        ->required(),

                ]),
        ]);
    }
}
