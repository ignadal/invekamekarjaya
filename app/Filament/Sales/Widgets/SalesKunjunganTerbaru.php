<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\KunjunganSales;
use App\Models\Sales;

class SalesKunjunganTerbaru extends Widget
{
    protected string $view = 'filament.sales.widgets.sales-kunjungan-terbaru';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 1;

    public function getKunjungansProperty()
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        if (!$salesId) {
            return collect();
        }

        return KunjunganSales::with(['buyer', 'buyer.kecamatan'])
            ->where('sales_id', $salesId)
            ->latest('tanggal_kunjungan')
            ->latest('created_at')
            ->limit(5)
            ->get();
    }
}
