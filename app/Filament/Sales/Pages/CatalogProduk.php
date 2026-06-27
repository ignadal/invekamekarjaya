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
        $barangs = Barang::with('kategori')->get();
        $categories = KategoriBarang::withCount('barangs')->get();
        
        $totalProduk = $barangs->count();
        $stokTersedia = $barangs->sum('stok');
        
        // Produk dengan stok <= stok_minimum dan stok > 0
        $stokMenipis = $barangs->filter(function($b) {
            return $b->stok <= $b->stok_minimum && $b->stok > 0;
        })->count();
        
        // Produk dengan stok 0
        $produkNonaktif = $barangs->filter(function($b) {
            return $b->stok == 0;
        })->count();

        $barangsData = $barangs->map(function($b) {
            return [
                'id' => $b->id,
                'nama_barang' => $b->nama_barang,
                'kategori_barang_id' => $b->kategori_barang_id,
                'kategori_nama' => $b->kategori ? $b->kategori->nama_kategori : 'UMUM',
                'stok' => $b->stok,
                'harga_jual' => $b->harga_jual,
                'foto' => $b->foto,
                'created_at' => $b->created_at ? $b->created_at->toIso8601String() : null
            ];
        })->values()->toArray();

        return [
            'categories' => $categories,
            'barangs' => $barangs,
            'barangsData' => $barangsData,
            'stats' => [
                'total_produk' => $totalProduk,
                'stok_tersedia' => $stokTersedia,
                'stok_menipis' => $stokMenipis,
                'produk_nonaktif' => $produkNonaktif
            ]
        ];
    }
}
