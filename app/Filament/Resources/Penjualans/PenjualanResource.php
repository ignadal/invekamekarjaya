<?php

namespace App\Filament\Resources\Penjualans;

use App\Filament\Resources\Penjualans\Pages\CreatePenjualan;
use App\Filament\Resources\Penjualans\Pages\EditPenjualan;
use App\Filament\Resources\Penjualans\Pages\ListPenjualans;
use App\Filament\Resources\Penjualans\Schemas\PenjualanForm;
use App\Filament\Resources\Penjualans\Tables\PenjualansTable;
use App\Models\Penjualan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PenjualanResource extends Resource
{
    protected static ?string $model = \App\Models\Penjualan::class;
    protected static ?string $pluralModelLabel = 'Penjualan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;
    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Penjualan';

    public static function getNavigationBadge(): ?string
    {
        $batasTempo = now()->addDays(3)->endOfDay();
        
        $pending = \App\Models\Penjualan::where('status_persetujuan', 'pending')->count();
        $piutang = \App\Models\Penjualan::where('metode', 'cicil')
            ->whereIn('status_bayar', ['sebagian', 'belum_dibayar'])
            ->where('status_persetujuan', 'disetujui')
            ->whereNotNull('jatuh_tempo')
            ->where('jatuh_tempo', '<=', $batasTempo)
            ->count();
            
        $total = $pending + $piutang;
        
        return $total > 0 ? (string) $total : null;
    }
    
    public static function getNavigationBadgeColor(): string|array|null
    {
        $pending = \App\Models\Penjualan::where('status_persetujuan', 'pending')->count();
        return $pending > 0 ? 'warning' : 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return PenjualanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenjualansTable::configure($table);
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
            \App\Filament\Resources\Penjualans\Widgets\PenjualanStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenjualans::route('/'),
            'create' => CreatePenjualan::route('/create'),
            'edit' => EditPenjualan::route('/{record}/edit'),
        ];
    }
}
