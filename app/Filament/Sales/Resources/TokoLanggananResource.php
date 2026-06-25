<?php

namespace App\Filament\Sales\Resources;

use App\Filament\Sales\Resources\TokoLanggananResource\Pages;
use App\Models\Buyer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TokoLanggananResource extends Resource
{
    protected static ?string $model = Buyer::class;
    protected static ?string $pluralModelLabel = 'Toko Langganan';
    protected static ?string $modelLabel = 'Toko Langganan';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;
    protected static ?string $navigationLabel = 'Toko Langganan';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Toko')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                Select::make('kecamatan_id')
                                    ->relationship('kecamatan', 'nama_kecamatan')
                                    ->label('Kecamatan')
                                    ->disabled(),
                                TextInput::make('nama_toko')
                                    ->label('Nama Toko')
                                    ->disabled(),
                                TextInput::make('nama_owner')
                                    ->label('Nama Owner')
                                    ->disabled(),
                                TextInput::make('no_hp')
                                    ->label('No. Handphone')
                                    ->disabled(),
                            ]),
                    ]),
                \Filament\Schemas\Components\Section::make('Detail Lokasi & Catatan')
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull()
                            ->disabled(),
                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->columnSpanFull()
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_toko')
                    ->label('Nama Toko')
                    ->searchable(),
                TextColumn::make('nama_owner')
                    ->label('Nama Owner')
                    ->searchable(),
                TextColumn::make('kecamatan.nama_kecamatan')
                    ->label('Kecamatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_hp')
                    ->label('No. Handphone')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('kecamatan_id')
                    ->relationship('kecamatan', 'nama_kecamatan')
                    ->label('Filter Kecamatan')
                    ->searchable()
                    ->preload(),
            ])
            ->actionsColumnLabel('Aksi')
            ->recordActions([
                \Filament\Actions\ViewAction::make()->label('Detail')->button()->outlined()->color('danger'),
            ])
            ->toolbarActions([
                // 
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTokoLangganan::route('/'),
        ];
    }
}
