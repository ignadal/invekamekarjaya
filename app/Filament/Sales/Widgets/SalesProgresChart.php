<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Sales;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;

class SalesProgresChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 2;

    protected ?string $heading = 'Progres Tagihan vs Pembayaran (Bulan Ini)';

    public function getDescription(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        return new \Illuminate\Support\HtmlString('
            <div x-data="{ open: false }" style="position: relative; display: inline-flex; align-items: center; margin-top: 0.25rem;">
                <button type="button" @click.stop="open = !open" style="outline: none; background: none; border: none; cursor: pointer; padding: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af" style="width: 1.25rem; height: 1.25rem;">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; z-index: 9999; width: 220px; background-color: #1f2937; color: #f9fafb; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: normal; line-height: 1.4; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); top: 100%; left: 1.5rem; white-space: normal;">
                    <div style="position: absolute; top: 10px; left: -5px; width: 10px; height: 10px; background-color: #1f2937; transform: rotate(45deg);"></div>
                    Membandingkan tren nilai total pesanan baru vs uang cicilan yang masuk dari minggu ke minggu.
                </div>
            </div>
        ');
    }

    protected function getData(): array
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Get weekly data
        $labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        $tagihanData = [0, 0, 0, 0];
        $pembayaranData = [0, 0, 0, 0];

        if ($salesId) {
            // Get all penjualan this month grouped by week
            $penjualans = Penjualan::where('sales_id', $salesId)
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->get();

            $cumulativeTagihan = 0;
            foreach ($penjualans as $p) {
                $weekNum = min(3, (int) floor(($p->tanggal_beli->day - 1) / 7));
                $cumulativeTagihan += $p->total_penjualan;
                for ($i = $weekNum; $i < 4; $i++) {
                    $tagihanData[$i] = $cumulativeTagihan;
                }
            }

            // Get all pembayaran this month grouped by week
            $pembayarans = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                    $q->where('sales_id', $salesId);
                })
                ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
                ->get();

            $cumulativePembayaran = 0;
            foreach ($pembayarans as $p) {
                $weekNum = min(3, (int) floor(($p->tanggal_bayar->day - 1) / 7));
                $cumulativePembayaran += $p->nominal;
                for ($i = $weekNum; $i < 4; $i++) {
                    $pembayaranData[$i] = $cumulativePembayaran;
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $tagihanData,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'transparent',
                    'pointBackgroundColor' => '#ef4444',
                    'pointRadius' => 5,
                    'tension' => 0.3,
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Total Pembayaran',
                    'data' => $pembayaranData,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'transparent',
                    'pointBackgroundColor' => '#22c55e',
                    'pointRadius' => 5,
                    'tension' => 0.3,
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
