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
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->email(),

                TextInput::make('no_hp')
                    ->tel()
                    ->required(),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),

                Select::make('role')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'sales' => 'Sales',
                    ])
                    ->required()
                    ->default('sales'),
            ]);
    }
}