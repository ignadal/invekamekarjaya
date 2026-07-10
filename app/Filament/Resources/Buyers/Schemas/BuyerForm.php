<?php

namespace App\Filament\Resources\Buyers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class BuyerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Toko / Buyer')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                Select::make('kecamatan_id')
                                    ->relationship('kecamatan', 'nama_kecamatan')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('nama_toko')
                                    ->required(),
                                FileUpload::make('foto_toko')
                                    ->label('Foto Toko')
                                    ->image()
                                    ->disk('public')
                                    ->directory('foto-toko')
                                    ->maxSize(5120)
                                    ->nullable(),
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        TimePicker::make('jam_buka')
                                            ->label('Jam Buka')
                                            ->seconds(false)
                                            ->nullable()
                                            ->prefixIcon('heroicon-o-clock'),
                                        TimePicker::make('jam_tutup')
                                            ->label('Jam Tutup')
                                            ->seconds(false)
                                            ->nullable()
                                            ->prefixIcon('heroicon-o-clock'),
                                    ]),
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        Select::make('hari_buka')
                                            ->label('Dari Hari')
                                            ->options([
                                                'Senin' => 'Senin', 'Selasa' => 'Selasa', 'Rabu' => 'Rabu',
                                                'Kamis' => 'Kamis', 'Jumat' => 'Jumat', 'Sabtu' => 'Sabtu', 'Minggu' => 'Minggu',
                                            ])
                                            ->prefixIcon('heroicon-o-calendar-days')
                                            ->placeholder('Pilih Hari')
                                            ->selectablePlaceholder(false)
                                            ->default('Senin'),
                                        Select::make('hari_bukaakhir')
                                            ->label('Sampai Hari')
                                            ->options([
                                                'Senin' => 'Senin', 'Selasa' => 'Selasa', 'Rabu' => 'Rabu',
                                                'Kamis' => 'Kamis', 'Jumat' => 'Jumat', 'Sabtu' => 'Sabtu', 'Minggu' => 'Minggu',
                                            ])
                                            ->prefixIcon('heroicon-o-calendar-days')
                                            ->placeholder('Pilih Hari')
                                            ->selectablePlaceholder(false)
                                            ->default('Senin'),
                                    ]),
                                TextInput::make('nama_owner')
                                    ->required(),
                                TextInput::make('no_hp')
                                    ->prefix('+62')
                                    ->tel()
                                    ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[^0-9]/g, '')"])
                                    ->formatStateUsing(function ($state) {
                                        if (!$state) return null;
                                        $state = preg_replace('/[^0-9]/', '', $state);
                                        if (str_starts_with($state, '62')) return substr($state, 2);
                                        if (str_starts_with($state, '0')) return substr($state, 1);
                                        return $state;
                                    })
                                    ->dehydrateStateUsing(function ($state) {
                                        if (!$state) return null;
                                        $state = preg_replace('/[^0-9]/', '', $state);
                                        if (str_starts_with($state, '62')) $state = substr($state, 2);
                                        elseif (str_starts_with($state, '0')) $state = substr($state, 1);
                                        return '+62' . $state;
                                    }),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Detail Lokasi & Catatan')
                    ->schema([
                        Textarea::make('alamat')
                            ->columnSpanFull(),
                        Textarea::make('catatan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
