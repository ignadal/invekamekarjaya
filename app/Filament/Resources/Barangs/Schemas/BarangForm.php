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
            ->components([
                Select::make('kategori_barang_id')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('nama_barang')
                    ->required(),

                TextInput::make('harga_jual')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('harga_beli_terakhir')
                    ->label('Harga Beli Terakhir')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),

                TextInput::make('stok')
                    ->numeric()
                    ->required()
                    ->default(0),

                TextInput::make('stok_minimum')
                    ->numeric()
                    ->required()
                    ->default(0),

                FileUpload::make('foto')
                    ->image()
                    ->directory('barang'),

                Textarea::make('deskripsi')
                    ->columnSpanFull(),

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
            ]);
    }
}
