<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_supplier')
                    ->required(),
                TextInput::make('nama_agent'),
                TextInput::make('jabatan_agent'),
                TextInput::make('no_hp_supplier')
                    ->required(),
                TextInput::make('no_hp_agent'),
                Textarea::make('alamat')
                    ->columnSpanFull(),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
