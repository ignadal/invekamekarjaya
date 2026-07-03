<?php

namespace App\Filament\Resources\PayrollSales\Pages;

use App\Filament\Resources\PayrollSales\PayrollSalesResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayrollSales extends CreateRecord
{
    protected static string $resource = PayrollSalesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
