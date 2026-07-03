<?php

namespace App\Filament\Resources\KunjunganSales\Pages;

use App\Filament\Resources\KunjunganSales\KunjunganSalesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKunjunganSales extends CreateRecord
{
    protected static string $resource = KunjunganSalesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
