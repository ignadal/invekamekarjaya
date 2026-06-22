<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Barang;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Umum')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                Select::make('sales_id')
                                    ->relationship('sales', 'nama_sales')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                
                                Select::make('buyer_id')
                                    ->relationship('buyer', 'nama_toko')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                DatePicker::make('tanggal_beli')
                                    ->required()
                                    ->minDate(today())
                                    ->default(today()),

                                Select::make('metode')
                                    ->options([
                                        'lunas' => 'Lunas',
                                        'cicil' => 'Cicil',
                                    ])
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        if ($state === 'lunas') {
                                            $set('status_bayar', 'lunas');
                                            $set('sudah_dibayar', $get('total_penjualan'));
                                            $set('sisa_pembayaran', 0);
                                        } else {
                                            $sudah = (int) $get('sudah_dibayar');
                                            $total = (int) $get('total_penjualan');
                                            $set('sisa_pembayaran', $total - $sudah);
                                            $set('status_bayar', $sudah >= $total ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                        }
                                    }),

                                Select::make('metode_pembayaran')
                                    ->options([
                                        'cash' => 'Cash',
                                        'transfer' => 'Transfer',
                                    ])
                                    ->required(),

                                DatePicker::make('jatuh_tempo')
                                    ->visible(fn (Get $get) => $get('metode') === 'cicil')
                                    ->required(fn (Get $get) => $get('metode') === 'cicil')
                                    ->minDate(today()),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Pembayaran')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('sudah_dibayar')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->live(debounce: 500)
                                    ->visible(fn (Get $get) => $get('metode') === 'cicil')
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $sudah = (int) $state;
                                        $total = (int) $get('total_penjualan');
                                        $set('sisa_pembayaran', $total - $sudah);
                                        $set('status_bayar', $sudah >= $total ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                    }),

                                TextInput::make('sisa_pembayaran')
                                    ->numeric()
                                    ->required()
                                    ->readOnly()
                                    ->visible(fn (Get $get) => $get('metode') === 'cicil')
                                    ->default(0),

                                \Filament\Forms\Components\Hidden::make('status_bayar')
                                    ->default('belum_dibayar'),

                                \Filament\Forms\Components\Hidden::make('status_persetujuan')
                                    ->default('pending'),
                            ]),

                        FileUpload::make('foto_nota')
                            ->image()
                            ->directory('nota_penjualan')
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Daftar Barang')
                    ->schema([
                        Repeater::make('details')
                            ->relationship()
                            ->schema([
                                Select::make('barang_id')
                                    ->label('Barang')
                                    ->options(function () {
                                        return Barang::where('stok', '>', 0)
                                            ->get()
                                            ->pluck('nama_barang', 'id')
                                            ->map(function ($nama, $id) {
                                                $barang = Barang::find($id);
                                                return $nama . ' - Stok ' . $barang->stok;
                                            });
                                    })
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->required()
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $barang = Barang::find($state);
                                        if ($barang) {
                                            $set('harga_jual', $barang->harga_jual);
                                            $set('qty', 1);
                                            $set('subtotal', $barang->harga_jual);
                                        }
                                    }),

                                TextInput::make('qty')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->maxValue(function (Get $get) {
                                        $barang = Barang::find($get('barang_id'));
                                        return $barang ? $barang->stok : 1;
                                    })
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $barang = Barang::find($get('barang_id'));
                                        if ($barang && $state > $barang->stok) {
                                            $state = $barang->stok;
                                            $set('qty', $state);
                                        }
                                        $set('subtotal', $state * (int)$get('harga_jual'));
                                        $details = $get('../../details');
                                        $total = 0;
                                        if (is_array($details)) {
                                            foreach ($details as $item) {
                                                $total += (int) ($item['subtotal'] ?? 0);
                                            }
                                        }
                                        $set('../../total_penjualan', $total);
                                        
                                        if ($get('../../metode') === 'lunas') {
                                            $set('../../sudah_dibayar', $total);
                                            $set('../../sisa_pembayaran', 0);
                                            $set('../../status_bayar', 'lunas');
                                        } else {
                                            $sudah = (int)$get('../../sudah_dibayar');
                                            $set('../../sisa_pembayaran', $total - $sudah);
                                            $set('../../status_bayar', $sudah >= $total && $total > 0 ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                        }
                                    }),

                                TextInput::make('harga_jual')
                                    ->numeric()
                                    ->required()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $set('subtotal', $state * (int)$get('qty'));
                                        $details = $get('../../details');
                                        $total = 0;
                                        if (is_array($details)) {
                                            foreach ($details as $item) {
                                                $total += (int) ($item['subtotal'] ?? 0);
                                            }
                                        }
                                        $set('../../total_penjualan', $total);
                                        
                                        if ($get('../../metode') === 'lunas') {
                                            $set('../../sudah_dibayar', $total);
                                            $set('../../sisa_pembayaran', 0);
                                            $set('../../status_bayar', 'lunas');
                                        } else {
                                            $sudah = (int)$get('../../sudah_dibayar');
                                            $set('../../sisa_pembayaran', $total - $sudah);
                                            $set('../../status_bayar', $sudah >= $total && $total > 0 ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                        }
                                    }),

                                TextInput::make('subtotal')
                                    ->numeric()
                                    ->required()
                                    ->readOnly()
                                    ->default(0),
                            ])
                            ->columns(1)
                            ->columnSpanFull(),

                        TextInput::make('total_penjualan')
                            ->numeric()
                            ->required()
                            ->readOnly()
                            ->default(0),
                    ]),
            ]);
    }
}
