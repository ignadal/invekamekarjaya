<?php

namespace App\Filament\Resources\PembelianSuppliers\Pages;

use App\Filament\Resources\PembelianSuppliers\PembelianSupplierResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePembelianSupplier extends CreateRecord
{
    protected static string $resource = PembelianSupplierResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
