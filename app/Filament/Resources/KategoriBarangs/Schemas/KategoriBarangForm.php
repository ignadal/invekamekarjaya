<?php

namespace App\Filament\Resources\KategoriBarangs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KategoriBarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Detail Kategori')
                    ->schema([
                        TextInput::make('nama_kategori')
                            ->required(),
                    ]),
            ]);
    }
}
