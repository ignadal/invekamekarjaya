<?php

namespace App\Filament\Resources\Buyers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BuyerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kecamatan_id')
                    ->relationship('kecamatan', 'nama_kecamatan')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('nama_toko')
                    ->required(),

                TextInput::make('nama_owner')
                    ->required(),

                TextInput::make('no_hp')
                    ->tel(),

                Textarea::make('alamat')
                    ->columnSpanFull(),

                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
