<?php

namespace App\Filament\Resources\Buyers;

use App\Filament\Resources\Buyers\Pages\CreateBuyer;
use App\Filament\Resources\Buyers\Pages\EditBuyer;
use App\Filament\Resources\Buyers\Pages\ListBuyers;
use App\Filament\Resources\Buyers\Schemas\BuyerForm;
use App\Filament\Resources\Buyers\Tables\BuyersTable;
use App\Models\Buyer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BuyerResource extends Resource
{
    protected static ?string $model = \App\Models\Buyer::class;
    protected static ?string $pluralModelLabel = 'Buyer';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Buyer / Toko';

    protected static ?string $recordTitleAttribute = 'nama_toko';

    public static function form(Schema $schema): Schema
    {
        return BuyerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BuyersTable::configure($table);
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
            'index' => ListBuyers::route('/'),
            'create' => CreateBuyer::route('/create'),
            'edit' => EditBuyer::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
