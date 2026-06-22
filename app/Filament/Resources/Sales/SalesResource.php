<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\Pages\CreateSales;
use App\Filament\Resources\Sales\Pages\EditSales;
use App\Filament\Resources\Sales\Pages\ListSales;
use App\Filament\Resources\Sales\Schemas\SalesForm;
use App\Filament\Resources\Sales\Tables\SalesTable;
use App\Models\Sales;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesResource extends Resource
{
    protected static ?string $model = \App\Models\Sales::class;
    protected static ?string $pluralModelLabel = 'Sales';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static string|\UnitEnum|null $navigationGroup = 'HR & Sales';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Sales';

    protected static ?string $recordTitleAttribute = 'nama_sales';

    public static function form(Schema $schema): Schema
    {
        return SalesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalesTable::configure($table);
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
            'index' => ListSales::route('/'),
            'create' => CreateSales::route('/create'),
            'edit' => EditSales::route('/{record}/edit'),
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
