<?php

namespace App\Filament\Sales\Pages;

use Filament\Pages\Page;

class Gaji extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-wallet';

    protected string $view = 'filament.sales.pages.gaji';
    
    protected static ?string $navigationLabel = 'Gaji & Insentif';
    
    protected static ?string $title = 'Informasi Gaji & Insentif';
    
    protected static ?int $navigationSort = 4;

    public $activeTab = 'gaji_pokok';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }
}
