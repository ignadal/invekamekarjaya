<?php

namespace App\Filament\Resources\PayrollSales;

use App\Filament\Resources\PayrollSales\Pages\CreatePayrollSales;
use App\Filament\Resources\PayrollSales\Pages\EditPayrollSales;
use App\Filament\Resources\PayrollSales\Pages\ListPayrollSales;
use App\Filament\Resources\PayrollSales\Schemas\PayrollSalesForm;
use App\Filament\Resources\PayrollSales\Tables\PayrollSalesTable;
use App\Models\PayrollSales;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PayrollSalesResource extends Resource
{
    protected static ?string $model = \App\Models\PayrollSales::class;
    protected static ?string $modelLabel = 'Gaji Sales';
    protected static ?string $pluralModelLabel = 'Gaji Sales';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;
    protected static string|\UnitEnum|null $navigationGroup = 'HR & Sales';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Gaji Sales';

    public static function form(Schema $schema): Schema
    {
        return PayrollSalesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PayrollSalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Resources\PayrollSales\Widgets\PayrollSalesStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPayrollSales::route('/'),
            'create' => CreatePayrollSales::route('/create'),
            'edit' => EditPayrollSales::route('/{record}/edit'),
        ];
    }
}
