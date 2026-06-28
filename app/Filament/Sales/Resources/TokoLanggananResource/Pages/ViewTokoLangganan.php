<?php

namespace App\Filament\Sales\Resources\TokoLanggananResource\Pages;

use App\Filament\Sales\Resources\TokoLanggananResource;
use Filament\Resources\Pages\ViewRecord;

class ViewTokoLangganan extends ViewRecord
{
    protected static string $resource = TokoLanggananResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
        return [
            \App\Filament\Sales\Resources\TokoLanggananResource::getUrl() => 'Toko Langganan',
            '#' => $this->record->nama_toko,
        ];
    }
}
