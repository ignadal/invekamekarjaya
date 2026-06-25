<?php

namespace App\Filament\Sales\Resources\TokoLanggananResource\Pages;

use App\Filament\Sales\Resources\TokoLanggananResource;
use Filament\Resources\Pages\ListRecords;

class ListTokoLangganan extends ListRecords
{
    protected static string $resource = TokoLanggananResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            // No create action for sales, just view
        ];
    }
}
