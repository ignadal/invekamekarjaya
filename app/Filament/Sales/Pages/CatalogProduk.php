<?php

namespace App\Filament\Sales\Pages;

use Filament\Pages\Page;
use App\Models\KategoriBarang;
use App\Models\Barang;

class CatalogProduk extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected string $view = 'filament.sales.pages.catalog-produk';

    protected function getViewData(): array
    {
        return [
            'categories' => KategoriBarang::withCount('barangs')->get(),
            'newArrivals' => Barang::with('kategori')->latest()->take(12)->get(),
        ];
    }
}
