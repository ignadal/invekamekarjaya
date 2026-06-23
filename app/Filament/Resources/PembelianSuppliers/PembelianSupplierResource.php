<?php

namespace App\Filament\Resources\PembelianSuppliers;

use App\Filament\Resources\PembelianSuppliers\Pages\CreatePembelianSupplier;
use App\Filament\Resources\PembelianSuppliers\Pages\EditPembelianSupplier;
use App\Filament\Resources\PembelianSuppliers\Pages\ListPembelianSuppliers;
use App\Filament\Resources\PembelianSuppliers\Schemas\PembelianSupplierForm;
use App\Filament\Resources\PembelianSuppliers\Tables\PembelianSuppliersTable;
use App\Models\PembelianSupplier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\PembelianSuppliers\RelationManagers\DetailsRelationManager;

class PembelianSupplierResource extends Resource
{
    protected static ?string $model = \App\Models\PembelianSupplier::class;
    protected static ?string $pluralModelLabel = 'Pembelian Supplier';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;
    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Pembelian Supplier';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationBadge(): ?string
    {
        $batasTempo = now()->addDays(3)->endOfDay();
        $count = \App\Models\PembelianSupplier::where('metode', 'nyicil')
            ->whereIn('status', ['sebagian', 'belum_dibayar'])
            ->whereNotNull('jatuh_tempo')
            ->where('jatuh_tempo', '<=', $batasTempo)
            ->count();
            
        return $count > 0 ? (string) $count : null;
    }
    
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return PembelianSupplierForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PembelianSuppliersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DetailsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Resources\PembelianSuppliers\Widgets\PembelianSupplierStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPembelianSuppliers::route('/'),
            'create' => CreatePembelianSupplier::route('/create'),
            'edit' => EditPembelianSupplier::route('/{record}/edit'),
        ];
    }
}
