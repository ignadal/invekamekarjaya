<?php

namespace App\Filament\Resources\Kecamatans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KecamatanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Detail Kecamatan')
                    ->schema([
                        TextInput::make('nama_kecamatan')
                            ->required(),
                    ]),
            ]);
    }
}
