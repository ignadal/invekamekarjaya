<?php

namespace App\Filament\Resources\KunjunganSales;

use App\Filament\Resources\KunjunganSales\Pages\CreateKunjunganSales;
use App\Filament\Resources\KunjunganSales\Pages\EditKunjunganSales;
use App\Filament\Resources\KunjunganSales\Pages\ListKunjunganSales;
use App\Filament\Resources\KunjunganSales\Schemas\KunjunganSalesForm;
use App\Filament\Resources\KunjunganSales\Tables\KunjunganSalesTable;
use App\Models\KunjunganSales;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KunjunganSalesResource extends Resource
{
    protected static ?string $model = \App\Models\KunjunganSales::class;
    protected static ?string $pluralModelLabel = 'Kunjungan Sales';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;
    protected static string|\UnitEnum|null $navigationGroup = 'HR & Sales';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Kunjungan Sales';

    public static function form(Schema $schema): Schema
    {
        return KunjunganSalesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KunjunganSalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKunjunganSales::route('/'),
            'create' => CreateKunjunganSales::route('/create'),
            'edit' => EditKunjunganSales::route('/{record}/edit'),
        ];
    }
}
