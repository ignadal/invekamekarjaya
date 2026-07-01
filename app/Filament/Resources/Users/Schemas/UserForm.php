<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Pengguna')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('name')
                                    ->required(),

                                TextInput::make('username')
                                    ->unique(ignoreRecord: true)
                                    ->nullable()
                                    ->extraInputAttributes([
                                        'autocomplete' => 'off', 
                                        'data-lpignore' => 'true', 
                                        'readonly' => 'readonly', 
                                        'onfocus' => "this.removeAttribute('readonly');"
                                    ]),

                                TextInput::make('email')
                                    ->email(),

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
                                    })
                                    ->required(),

                                Select::make('role')
                                    ->options([
                                        'super_admin' => 'Super Admin',
                                        'sales' => 'Sales',
                                    ])
                                    ->required()
                                    ->default('sales'),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Keamanan')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('password')
                                    ->password()
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->helperText(fn (string $operation): ?string => $operation === 'edit' ? 'Biarkan kosong jika tidak ingin mengubah password.' : null),

                                TextInput::make('password_confirmation')
                                    ->label('Konfirmasi Password')
                                    ->password()
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->same('password')
                                    ->dehydrated(false)
                                    ->visible(fn (string $operation): bool => $operation === 'create'),
                            ]),
                    ]),
            ]);
    }
}