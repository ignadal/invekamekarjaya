<?php

namespace App\Filament\Resources\PembelianSuppliers\Pages;

use App\Filament\Resources\PembelianSuppliers\PembelianSupplierResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPembelianSupplier extends EditRecord
{
    protected static string $resource = PembelianSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
