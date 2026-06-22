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
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Supplier')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('nama_supplier')
                                    ->required(),
                                TextInput::make('no_hp_supplier')
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
                                    })
                                    ->required(),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Informasi Agen/PIC')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('nama_agent'),
                                TextInput::make('jabatan_agent'),
                                TextInput::make('no_hp_agent')
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

                \Filament\Schemas\Components\Section::make('Detail Tambahan')
                    ->schema([
                        Textarea::make('alamat')
                            ->columnSpanFull(),
                        Textarea::make('catatan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
