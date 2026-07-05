<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;


class BarangForm
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
                                FileUpload::make('foto')
                                    ->image()
                                    ->disk('public')
                                    ->directory('barang')
                                    ->columnSpanFull(),

                                TextInput::make('nama_barang')
                                    ->required(),

                                Textarea::make('deskripsi')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Harga & Stok')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('harga_jual')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),

                                TextInput::make('harga_beli_terakhir')
                                    ->label('Harga Beli Terakhir')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated()
                                    ->helperText('Otomatis diupdate berdasarkan harga dari nota Pembelian Supplier terakhir.')
                                    ->default(0),

                                TextInput::make('stok')
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->helperText('Stok akan bertambah dari pembelian dan berkurang dari penjualan.')
                                    ->default(0),

                                TextInput::make('stok_minimum')
                                    ->numeric()
                                    ->required()
                                    ->default(0),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Spesifikasi Fisik')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                Select::make('kategori_barang_id')
                                    ->relationship('kategori', 'nama_kategori')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('ukuran')
                                    ->options([
                                        'kecil' => 'Kecil',
                                        'sedang' => 'Sedang',
                                        'besar' => 'Besar',
                                    ]),

                                Select::make('berat')
                                    ->options([
                                        'ringan' => 'Ringan',
                                        'sedang' => 'Sedang',
                                        'berat' => 'Berat',
                                    ]),
                            ]),
                    ]),
                
                \Filament\Schemas\Components\Section::make('Statistik Penjualan')
                    ->visible(fn ($operation) => $operation === 'view')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(3)
                            ->schema([
                                TextInput::make('total_terjual')
                                    ->label('Total Kuantitas Terjual')
                                    ->afterStateHydrated(function (TextInput $component, $record) {
                                        if ($record) {
                                            $total = $record->penjualanDetails()->whereHas('penjualan', function ($q) {
                                                $q->where('status_persetujuan', 'disetujui');
                                            })->sum('qty');
                                            $component->state($total);
                                        }
                                    })
                                    ->disabled(),

                                TextInput::make('total_pendapatan')
                                    ->label('Total Pendapatan')
                                    ->prefix('Rp')
                                    ->afterStateHydrated(function (TextInput $component, $record) {
                                        if ($record) {
                                            $total = $record->penjualanDetails()->whereHas('penjualan', function ($q) {
                                                $q->where('status_persetujuan', 'disetujui');
                                            })->sum('subtotal');
                                            $component->state($total);
                                        }
                                    })
                                    ->disabled(),

                                TextInput::make('rata_rata_harga_jual')
                                    ->label('Rata-rata Harga Jual / Qty')
                                    ->prefix('Rp')
                                    ->afterStateHydrated(function (TextInput $component, $record) {
                                        if ($record) {
                                            $qty = $record->penjualanDetails()->whereHas('penjualan', function ($q) {
                                                $q->where('status_persetujuan', 'disetujui');
                                            })->sum('qty');
                                            $pendapatan = $record->penjualanDetails()->whereHas('penjualan', function ($q) {
                                                $q->where('status_persetujuan', 'disetujui');
                                            })->sum('subtotal');
                                            
                                            if ($qty > 0) {
                                                $component->state($pendapatan / $qty);
                                            } else {
                                                $component->state(0);
                                            }
                                        }
                                    })
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }
}
