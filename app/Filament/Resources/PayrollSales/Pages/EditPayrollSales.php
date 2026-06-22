<?php

namespace App\Filament\Resources\PayrollSales\Pages;

use App\Filament\Resources\PayrollSales\PayrollSalesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPayrollSales extends EditRecord
{
    protected static string $resource = PayrollSalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
