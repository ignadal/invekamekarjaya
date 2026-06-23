<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\PembelianSupplier;
use App\Models\PayrollSales;
use App\Models\Barang;
use Illuminate\Support\Number;
use Illuminate\Support\Carbon;

use Livewire\Attributes\On;

class DashboardStatsOverview extends StatsOverviewWidget
{
    public ?string $bulan = null;
    public ?string $tahun = null;

    #[On('dashboard-filter-changed')]
    public function updateFilter(?string $bulan = null, ?string $tahun = null): void
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;

        $omsetLunas = Penjualan::where('status_persetujuan', 'disetujui')
            ->where('metode', 'lunas')
            ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_beli', $bulan))
            ->sum('total_penjualan');
            
        $omsetCicil = Penjualan::where('status_persetujuan', 'disetujui')
            ->where('metode', 'cicil')
            ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_beli', $bulan))
            ->sum('sudah_dibayar');
            
        $omset = $omsetLunas + $omsetCicil;

        $piutang = Penjualan::where('status_persetujuan', 'disetujui')
            ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_beli', $bulan))
            ->sum('sisa_pembayaran');

        $pengeluaranSupplierLunas = PembelianSupplier::where('metode', 'lunas')
            ->when($tahun, fn($q) => $q->whereYear('created_at', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->sum('total_pembelian');
            
        $pengeluaranSupplierNyicil = PembelianSupplier::where('metode', 'nyicil')
            ->when($tahun, fn($q) => $q->whereYear('created_at', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->sum('sudah_dibayar');
            
        $pengeluaranSupplier = $pengeluaranSupplierLunas + $pengeluaranSupplierNyicil;

        $pengeluaranGaji = PayrollSales::where('status_pembayaran', 'sudah_digaji')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun))
            ->when($bulan, fn($q) => $q->where('bulan', $bulan))
            ->sum('total_gaji');

        $totalPengeluaran = $pengeluaranSupplier + $pengeluaranGaji;
        $penghasilanBersih = $omset - $totalPengeluaran;

        $totalBarang = Barang::count();
        $barangHampirHabis = Barang::whereColumn('stok', '<', 'stok_minimum')->count();
        $notaPending = Penjualan::where('status_persetujuan', 'pending')
            ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_beli', $bulan))
            ->count();

        // Total barang terjual (qty) in this period
        $barangTerjual = PenjualanDetail::whereHas('penjualan', function ($query) use ($tahun, $bulan) {
            $query->where('status_persetujuan', 'disetujui')
                ->when($tahun, fn($q) => $q->whereYear('tanggal_beli', $tahun))
                ->when($bulan, fn($q) => $q->whereMonth('tanggal_beli', $bulan));
        })->sum('qty');

        $namaBulan = $bulan ? Carbon::create()->month((int) $bulan)->translatedFormat('F') : 'Semua Bulan';
        $namaTahun = $tahun ?: 'Semua Tahun';
        $periodeDesc = ($bulan || $tahun) ? trim(($bulan ? $namaBulan : '') . ' ' . ($tahun ? $namaTahun : '')) : 'Semua Waktu';

        return [
            Stat::make('Total Penghasilan Bersih', $this->animatedStat($penghasilanBersih, 'Rp '))
                ->description($periodeDesc)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($penghasilanBersih >= 0 ? 'success' : 'danger'),
            Stat::make('Total Omset', $this->animatedStat($omset, 'Rp '))
                ->description($periodeDesc)
                ->descriptionIcon('heroicon-m-banknotes'),
            Stat::make('Total Piutang', $this->animatedStat($piutang, 'Rp '))
                ->description($periodeDesc)
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($piutang > 0 ? 'warning' : 'success'),
            Stat::make('Total Pengeluaran', $this->animatedStat($totalPengeluaran, 'Rp '))
                ->description($periodeDesc)
                ->descriptionIcon('heroicon-m-arrow-trending-down'),
            Stat::make('Barang Terjual', $this->animatedStat($barangTerjual, '', ' stok'))
                ->description($periodeDesc)
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
            Stat::make('Total Barang', $this->animatedStat($totalBarang))
                ->description('Semua jenis')
                ->descriptionIcon('heroicon-m-cube'),
            Stat::make('Barang Hampir Habis', $this->animatedStat($barangHampirHabis))
                ->color($barangHampirHabis > 0 ? 'danger' : 'success')
                ->description($barangHampirHabis > 0 ? 'Perlu restok!' : 'Stok aman')
                ->descriptionIcon($barangHampirHabis > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle'),
            Stat::make('Nota Pending Approval', $this->animatedStat($notaPending))
                ->color($notaPending > 0 ? 'warning' : 'success')
                ->description($periodeDesc)
                ->descriptionIcon('heroicon-m-clock'),
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
