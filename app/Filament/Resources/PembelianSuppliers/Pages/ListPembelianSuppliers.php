<?php

namespace App\Filament\Resources\PembelianSuppliers\Pages;

use App\Filament\Resources\PembelianSuppliers\PembelianSupplierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPembelianSuppliers extends ListRecords
{
    protected static string $resource = PembelianSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
