<?php

namespace App\Filament\Sales\Pages;

use Filament\Pages\Page;

class Transaksi extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';

    protected string $view = 'filament.sales.pages.transaksi';
    
    protected static ?string $navigationLabel = 'Orderan';
    
    protected static ?string $title = 'Penjualan & Penagihan';
    
    protected static ?int $navigationSort = 3;

    public $activeTab = 'penjualan';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }
}
