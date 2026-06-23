<?php

namespace App\Filament\Resources\Penjualans\Widgets;

use App\Models\Penjualan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PenjualanStatsOverview extends BaseWidget
{
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        // 1. Nota butuh acc
        $notaButuhAcc = Penjualan::where('status_persetujuan', 'pending')->count();
        
        // 2. Total penjualan (disetujui)
        $totalPenjualan = Penjualan::where('status_persetujuan', 'disetujui')->sum('total_penjualan');
        
        // 3. Piutang butuh bayar cicilan (disetujui, cicil, belum lunas)
        $piutangCicilan = Penjualan::where('status_persetujuan', 'disetujui')
            ->where('metode', 'cicil')
            ->where('sisa_pembayaran', '>', 0)
            ->sum('sisa_pembayaran');

        // 4. Total Penghasilan (uang yang sudah riil diterima)
        $lunas = Penjualan::where('status_persetujuan', 'disetujui')->where('metode', 'lunas')->sum('total_penjualan');
        $nyicil = Penjualan::where('status_persetujuan', 'disetujui')->where('metode', 'cicil')->sum('sudah_dibayar');
        $totalPenghasilan = $lunas + $nyicil;

        return [
            Stat::make('Nota Butuh ACC', $this->animatedStat($notaButuhAcc, '', ' Nota'))
                ->description('Menunggu persetujuan admin')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
                
            Stat::make('Total Penjualan', $this->animatedStat($totalPenjualan, 'Rp '))
                ->description('Seluruh penjualan disetujui')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),

            Stat::make('Total Penghasilan', $this->animatedStat($totalPenghasilan, 'Rp '))
                ->description('Uang yang sudah dibayar/diterima')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('danger'),
                
            Stat::make('Piutang Belum Lunas', $this->animatedStat($piutangCicilan, 'Rp '))
                ->description('Cicilan yang belum dibayar')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('danger'),
        ];
    }

    private function animatedStat(int|float $value, string $prefix = '', string $suffix = '')
    {
        $prefixHtml = $prefix ? "<span class=\"text-xl font-normal text-gray-500\">{$prefix}</span><br>" : '';
        
        return new \Illuminate\Support\HtmlString(<<<HTML
{$prefixHtml}<span 
    x-data="{
        current: 0,
        target: {$value},
        init() {
            this.animateTo(this.target);
            let observer = new MutationObserver((mutations) => {
                mutations.forEach((m) => {
                    if (m.type === 'attributes' && m.attributeName === 'data-target') {
                        let newTarget = parseFloat(this.\$el.getAttribute('data-target'));
                        if(newTarget !== this.target) {
                            this.target = newTarget;
                            this.animateTo(this.target);
                        }
                    }
                });
            });
            observer.observe(this.\$el, { attributes: true });
        },
        animateTo(end) {
            let start = this.current;
            let duration = 1500;
            let startTime = performance.now();
            let animate = (currentTime) => {
                let elapsed = currentTime - startTime;
                let progress = Math.min(elapsed / duration, 1);
                let easeProgress = 1 - Math.pow(1 - progress, 3);
                this.current = start + (end - start) * easeProgress;
                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    this.current = end;
                }
            };
            requestAnimationFrame(animate);
        }
    }"
    data-target="{$value}"
    x-text="new Intl.NumberFormat('id-ID').format(Math.round(current)) + '{$suffix}'"
    class="tabular-nums tracking-tight whitespace-nowrap"
></span>
HTML
        );
    }
}
