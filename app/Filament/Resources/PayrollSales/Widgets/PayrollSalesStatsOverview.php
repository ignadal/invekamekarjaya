<?php

namespace App\Filament\Resources\PayrollSales\Widgets;

use App\Models\PayrollSales;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PayrollSalesStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // 1. Total Penggajian (yang sudah dibayarkan)
        $totalPenggajian = PayrollSales::where('status_pembayaran', 'sudah_digaji')->sum('total_gaji');
        
        // 2. Total Gaji Bulan Ini (khusus bulan & tahun saat ini)
        $bulanIni = now()->month;
        $tahunIni = now()->year;
        $totalGajiBulanIni = PayrollSales::where('bulan', $bulanIni)
            ->where('tahun', $tahunIni)
            ->sum('total_gaji');
            
        // 3. Gaji Belum Dibayar (semua yang statusnya belum dibayar)
        $gajiBelumDibayar = PayrollSales::where('status_pembayaran', 'belum')->sum('total_gaji');

        return [
            Stat::make('Total Penggajian', $this->animatedStat($totalPenggajian, 'Rp '))
                ->description('Seluruh gaji yang sudah dibayarkan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('danger'),
                
            Stat::make('Total Gaji Bulan Ini', $this->animatedStat($totalGajiBulanIni, 'Rp '))
                ->description('Total gaji pokok, tunjangan, dll bulan ini')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('danger'),
                
            Stat::make('Gaji Belum Dibayar', $this->animatedStat($gajiBelumDibayar, 'Rp '))
                ->description('Seluruh gaji yang belum dilunasi')
                ->descriptionIcon('heroicon-m-clock')
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
