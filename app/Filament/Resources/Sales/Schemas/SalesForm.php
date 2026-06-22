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
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Pribadi & Akun')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name', modifyQueryUsing: function (\Illuminate\Database\Eloquent\Builder $query, \Filament\Schemas\Components\Utilities\Get $get) {
                                        $query->where('role', '!=', 'super_admin')
                                              ->where(function ($q) use ($get) {
                                                  $q->whereNotIn('id', \App\Models\Sales::select('user_id')->whereNotNull('user_id'));
                                                  if ($get('user_id')) {
                                                      $q->orWhere('id', $get('user_id'));
                                                  }
                                              });
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state) {
                                            $user = \App\Models\User::find($state);
                                            if ($user) {
                                                $set('nama_sales', $user->name);
                                                
                                                $noHp = $user->no_hp;
                                                if ($noHp) {
                                                    $noHp = preg_replace('/[^0-9]/', '', $noHp);
                                                    if (str_starts_with($noHp, '62')) $noHp = substr($noHp, 2);
                                                    elseif (str_starts_with($noHp, '0')) $noHp = substr($noHp, 1);
                                                }
                                                $set('no_hp', $noHp);
                                            }
                                        }
                                    })
                                    ->required(),
                                TextInput::make('nama_sales')
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
                                    })
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                DatePicker::make('tanggal_bergabung')
                                    ->required(),
                            ]),
                        Textarea::make('alamat')
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Informasi Gaji')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('gaji_pokok')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(1000)
                                    ->extraInputAttributes(['min' => '1000', 'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')"])
                                    ->required()
                                    ->default(1000),
                            ]),
                    ]),
            ]);
    }
}
