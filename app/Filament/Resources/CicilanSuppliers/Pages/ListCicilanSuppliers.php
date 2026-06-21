<?php

namespace App\Filament\Resources\CicilanSuppliers\Pages;

use App\Filament\Resources\CicilanSuppliers\CicilanSupplierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCicilanSuppliers extends ListRecords
{
    protected static string $resource = CicilanSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
