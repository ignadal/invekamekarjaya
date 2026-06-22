<?php

namespace App\Filament\Resources\CicilanSuppliers;

use App\Filament\Resources\CicilanSuppliers\Pages\CreateCicilanSupplier;
use App\Filament\Resources\CicilanSuppliers\Pages\EditCicilanSupplier;
use App\Filament\Resources\CicilanSuppliers\Pages\ListCicilanSuppliers;
use App\Filament\Resources\CicilanSuppliers\Schemas\CicilanSupplierForm;
use App\Filament\Resources\CicilanSuppliers\Tables\CicilanSuppliersTable;
use App\Models\CicilanSupplier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CicilanSupplierResource extends Resource
{
    protected static ?string $model = \App\Models\CicilanSupplier::class;
    protected static ?string $pluralModelLabel = 'Cicilan Supplier';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;
    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Cicilan Supplier';
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return CicilanSupplierForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CicilanSuppliersTable::configure($table);
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
            'index' => ListCicilanSuppliers::route('/'),
            'create' => CreateCicilanSupplier::route('/create'),
            'edit' => EditCicilanSupplier::route('/{record}/edit'),
        ];
    }
}
