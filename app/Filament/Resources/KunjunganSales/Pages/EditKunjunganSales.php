<?php

namespace App\Filament\Resources\KunjunganSales\Pages;

use App\Filament\Resources\KunjunganSales\KunjunganSalesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKunjunganSales extends EditRecord
{
    protected static string $resource = KunjunganSalesResource::class;

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
