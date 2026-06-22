<?php

namespace App\Filament\Resources\KunjunganSales\Pages;

use App\Filament\Resources\KunjunganSales\KunjunganSalesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKunjunganSales extends ListRecords
{
    protected static string $resource = KunjunganSalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('')
                ->icon('heroicon-o-plus')
                ->tooltip('Tambah Data'),
        ];
    }
}
