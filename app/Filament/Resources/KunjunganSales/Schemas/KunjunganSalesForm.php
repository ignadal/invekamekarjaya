<?php

namespace App\Filament\Resources\KunjunganSales\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class KunjunganSalesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Detail Kunjungan')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                Select::make('sales_id')
                                    ->relationship('sales', 'nama_sales')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                
                                Select::make('buyer_id')
                                    ->relationship('buyer', 'nama_toko')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                DatePicker::make('tanggal_kunjungan')
                                    ->required()
                                    ->default(now())
                                    ->maxDate(now()),

                                Select::make('hasil_kunjungan')
                                    ->options([
                                        'order' => 'Order',
                                        'tidak_order' => 'Tidak Order',
                                        'toko_tutup' => 'Toko Tutup',
                                    ])
                                    ->required(),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Dokumentasi & Catatan')
                    ->schema([
                        FileUpload::make('foto')
                            ->image()
                            ->directory('kunjungan_sales')
                            ->columnSpanFull(),
                            
                        Textarea::make('catatan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
