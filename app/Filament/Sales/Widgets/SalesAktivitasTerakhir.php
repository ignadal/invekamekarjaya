<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\Sales;
use App\Models\KunjunganSales;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;

class SalesAktivitasTerakhir extends Widget
{
    protected string $view = 'filament.sales.widgets.sales-aktivitas-terakhir';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function getActivitiesProperty()
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $activities = collect();

        if ($salesId) {
            // Get last 3 Kunjungan
            $kunjungans = KunjunganSales::with('buyer')
                ->where('sales_id', $salesId)
                ->latest('created_at')
                ->limit(3)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'kunjungan',
                        'title' => 'Kunjungan ke ' . ($item->buyer ? $item->buyer->nama_toko : 'Toko'),
                        'date' => $item->created_at,
                        'amount' => null,
                        'icon' => 'heroicon-o-building-storefront',
                        'color' => 'warning',
                    ];
                });

            // Get last 3 Penjualan
            $penjualans = Penjualan::with('buyer')
                ->where('sales_id', $salesId)
                ->latest('created_at')
                ->limit(3)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'penjualan',
                        'title' => 'Tagihan baru untuk ' . ($item->buyer ? $item->buyer->nama_toko : 'Toko'),
                        'date' => $item->created_at,
                        'amount' => 'Rp ' . number_format($item->total_penjualan, 0, ',', '.'),
                        'icon' => 'heroicon-o-document-text',
                        'color' => 'danger',
                    ];
                });

            // Get last 3 Pembayaran (Cicilan)
            $pembayarans = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                    $q->where('sales_id', $salesId);
                })
                ->with('penjualan.buyer')
                ->latest('created_at')
                ->limit(3)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'pembayaran',
                        'title' => 'Pembayaran cicilan dari ' . ($item->penjualan && $item->penjualan->buyer ? $item->penjualan->buyer->nama_toko : 'Toko'),
                        'date' => $item->created_at,
                        'amount' => 'Rp ' . number_format($item->nominal, 0, ',', '.'),
                        'icon' => 'heroicon-o-banknotes',
                        'color' => 'success',
                    ];
                });

            $activities = $activities->concat($kunjungans)
                ->concat($penjualans)
                ->concat($pembayarans)
                ->sortByDesc('date')
                ->take(5);
        }

        return $activities;
    }
}
