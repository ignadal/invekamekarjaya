<?php

namespace App\Filament\Resources\PayrollSales\Pages;

use App\Filament\Resources\PayrollSales\PayrollSalesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPayrollSales extends ListRecords
{
    protected static string $resource = PayrollSalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('')
                ->icon('heroicon-o-plus')
                ->tooltip('Tambah Data'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\PayrollSales\Widgets\PayrollSalesStatsOverview::class,
        ];
    }

}
