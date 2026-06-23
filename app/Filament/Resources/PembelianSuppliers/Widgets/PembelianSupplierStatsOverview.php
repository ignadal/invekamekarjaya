<?php

namespace App\Filament\Resources\PembelianSuppliers\Widgets;

use App\Models\PembelianSupplier;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PembelianSupplierStatsOverview extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        // 1. Total uang keluar: total_pembelian dari yang lunas + sudah_dibayar dari yang nyicil
        $lunas = PembelianSupplier::where('metode', 'lunas')->sum('total_pembelian');
        $sebagian = PembelianSupplier::where('metode', 'nyicil')->sum('sudah_dibayar');
        $totalUangKeluar = $lunas + $sebagian;
        
        // 2. Total hutang yang belum dibayar: ambil dari sisa_pembayaran yang nyicil
        $hutangCicilan = PembelianSupplier::where('metode', 'nyicil')->sum('sisa_pembayaran');

        return [
            Stat::make('Total Uang Keluar (Pembelian)', $this->animatedStat($totalUangKeluar, 'Rp '))
                ->description('Seluruh pembelian disetujui')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('danger'),
                
            Stat::make('Total Hutang Belum Dibayar', $this->animatedStat($hutangCicilan, 'Rp '))
                ->description('Sisa hutang cicilan')
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
