<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SalesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('nama_sales')
                    ->required(),
                TextInput::make('no_hp')
                    ->tel()
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('alamat')
                    ->columnSpanFull(),
                TextInput::make('gaji_pokok')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->default(0),
                DatePicker::make('tanggal_bergabung')
                    ->required(),
            ]);
    }
}
