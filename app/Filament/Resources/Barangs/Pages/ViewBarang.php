<?php

namespace App\Filament\Resources\Barangs\Pages;

use App\Filament\Resources\Barangs\BarangResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBarang extends ViewRecord
{
    protected static string $resource = BarangResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function content(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                $this->getRelationManagersContentComponent(),
                $this->getFormContentComponent(),
            ]);
    }
}
