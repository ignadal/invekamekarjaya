<?php

namespace App\Filament\Resources\CicilanSuppliers\Pages;

use App\Filament\Resources\CicilanSuppliers\CicilanSupplierResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCicilanSupplier extends EditRecord
{
    protected static string $resource = CicilanSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
