<?php

namespace App\Filament\Sales\Widgets;

use Filament\Widgets\Widget;
use App\Models\Sales;
use App\Models\KunjunganSales;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;
use App\Models\PayrollSales;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class SalesStatsOverview extends Widget
{
    protected string $view = 'filament.widgets.custom-stats-overview';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    public ?string $filterBulan = null;
    public ?string $filterTahun = null;
    public string $periodeLabel = '';

    public function mount(): void
    {
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $this->periodeLabel = $namaBulan[now()->month - 1] . ' ' . now()->year;
    }

    #[On('sales-dashboard-filter-changed')]
    public function updateFilter(?string $bulan, ?string $tahun): void
    {
        $this->filterBulan = $bulan;
        $this->filterTahun = $tahun;

        if ($bulan && $tahun) {
            $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $this->periodeLabel = $namaBulan[$bulan - 1] . ' ' . $tahun;
        } else {
            $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $this->periodeLabel = $namaBulan[now()->month - 1] . ' ' . now()->year;
        }
    }

    public function getCustomStats(): array
    {
        $sales = Sales::where('user_id', auth()->id())->first();
        $salesId = $sales ? $sales->id : null;

        $targetDate = now();
        if ($this->filterBulan && $this->filterTahun) {
            $targetDate = now()->setDate((int) $this->filterTahun, (int) $this->filterBulan, 1);
        }

        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();
        $startOfLastMonth = $targetDate->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $targetDate->copy()->subMonth()->endOfMonth();

        $penjualanBulanIni = 0;
        $penjualanBulanLalu = 0;
        $penjualanGrowth = 0;

        $harusDitagihBulanIni = 0;
        $harusDitagihBulanLalu = 0;
        $harusDitagihGrowth = 0;

        $pembayaranBulanIni = 0;
        $pembayaranBulanLalu = 0;
        $pembayaranGrowth = 0;

        $kunjunganBulanIni = 0;
        $kunjunganBulanLalu = 0;
        $kunjunganGrowth = 0;

        if ($salesId) {
            // 1. Total Penjualan
            $penjualanBulanIni = Penjualan::where('sales_id', $salesId)
                ->where('status_persetujuan', 'disetujui')
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->sum('total_penjualan');
            $penjualanBulanLalu = Penjualan::where('sales_id', $salesId)
                ->where('status_persetujuan', 'disetujui')
                ->whereBetween('tanggal_beli', [$startOfLastMonth, $endOfLastMonth])
                ->sum('total_penjualan');
            $penjualanGrowth = $penjualanBulanLalu > 0 ? (($penjualanBulanIni - $penjualanBulanLalu) / $penjualanBulanLalu) * 100 : ($penjualanBulanIni > 0 ? 100 : 0);

            // 2. Total Harus Ditagih
            $harusDitagihBulanIni = Penjualan::where('sales_id', $salesId)
                ->where('status_persetujuan', 'disetujui')
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->sum('sisa_pembayaran');
            $harusDitagihBulanLalu = Penjualan::where('sales_id', $salesId)
                ->where('status_persetujuan', 'disetujui')
                ->whereBetween('tanggal_beli', [$startOfLastMonth, $endOfLastMonth])
                ->sum('sisa_pembayaran');
            $harusDitagihGrowth = $harusDitagihBulanLalu > 0 ? (($harusDitagihBulanIni - $harusDitagihBulanLalu) / $harusDitagihBulanLalu) * 100 : ($harusDitagihBulanIni > 0 ? 100 : 0);

            // 3. Total Pembayaran Penagihan
            $pembayaranLunasBulanIni = Penjualan::where('sales_id', $salesId)
                ->where('status_persetujuan', 'disetujui')
                ->where('metode', 'lunas')
                ->whereBetween('tanggal_beli', [$startOfMonth, $endOfMonth])
                ->sum('total_penjualan');
            $pembayaranCicilBulanIni = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                    $q->where('sales_id', $salesId)->where('status_persetujuan', 'disetujui');
                })
                ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
                ->sum('nominal');
            $pembayaranBulanIni = $pembayaranLunasBulanIni + $pembayaranCicilBulanIni;

            $pembayaranLunasBulanLalu = Penjualan::where('sales_id', $salesId)
                ->where('status_persetujuan', 'disetujui')
                ->where('metode', 'lunas')
                ->whereBetween('tanggal_beli', [$startOfLastMonth, $endOfLastMonth])
                ->sum('total_penjualan');
            $pembayaranCicilBulanLalu = CicilanBuyer::whereHas('penjualan', function($q) use ($salesId) {
                    $q->where('sales_id', $salesId)->where('status_persetujuan', 'disetujui');
                })
                ->whereBetween('tanggal_bayar', [$startOfLastMonth, $endOfLastMonth])
                ->sum('nominal');
            $pembayaranBulanLalu = $pembayaranLunasBulanLalu + $pembayaranCicilBulanLalu;
            
            $pembayaranGrowth = $pembayaranBulanLalu > 0 ? (($pembayaranBulanIni - $pembayaranBulanLalu) / $pembayaranBulanLalu) * 100 : ($pembayaranBulanIni > 0 ? 100 : 0);

            // 4. Total Kunjungan Sales
            $kunjunganBulanIni = KunjunganSales::where('sales_id', $salesId)
                ->whereBetween('tanggal_kunjungan', [$startOfMonth, $endOfMonth])
                ->count();
            $kunjunganBulanLalu = KunjunganSales::where('sales_id', $salesId)
                ->whereBetween('tanggal_kunjungan', [$startOfLastMonth, $endOfLastMonth])
                ->count();
            $kunjunganGrowth = $kunjunganBulanLalu > 0 ? (($kunjunganBulanIni - $kunjunganBulanLalu) / $kunjunganBulanLalu) * 100 : ($kunjunganBulanIni > 0 ? 100 : 0);
        }

        return [
            [
                'label' => 'Total Penjualan',
                'explanation' => 'Total nilai pesanan atau order baru yang Anda hasilkan pada periode ini.',
                'value' => 'Rp ' . number_format($penjualanBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($penjualanGrowth), 1, ',', '.') . '% dari bulan sebelumnya',
                'trend_up' => $penjualanGrowth >= 0,
                'icon_bg' => '#fee2e2',
                'icon_color' => '#ef4444',
                'icon' => 'shopping-bag',
            ],
            [
                'label' => 'Total Harus Ditagih',
                'explanation' => 'Sisa tagihan pada periode ini yang belum lunas dan masih harus Anda tagih ke toko.',
                'value' => 'Rp ' . number_format($harusDitagihBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($harusDitagihGrowth), 1, ',', '.') . '% dari bulan sebelumnya',
                'trend_up' => $harusDitagihGrowth <= 0, // Less is better for outstanding
                'icon_bg' => '#fee2e2',
                'icon_color' => '#ef4444',
                'icon' => 'document-text',
            ],
            [
                'label' => 'Total Pembayaran',
                'explanation' => 'Total uang setoran atau cicilan yang berhasil Anda kumpulkan pada periode ini.',
                'value' => 'Rp ' . number_format($pembayaranBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($pembayaranGrowth), 1, ',', '.') . '% dari bulan sebelumnya',
                'trend_up' => $pembayaranGrowth >= 0,
                'icon_bg' => '#fee2e2',
                'icon_color' => '#ef4444',
                'icon' => 'banknotes',
            ],
            [
                'label' => 'Total Kunjungan',
                'explanation' => 'Jumlah toko yang sudah Anda kunjungi dan catat laporannya pada periode ini.',
                'value' => number_format($kunjunganBulanIni, 0, ',', '.'),
                'trend' => number_format(abs($kunjunganGrowth), 1, ',', '.') . '% dari bulan sebelumnya',
                'trend_up' => $kunjunganGrowth >= 0,
                'icon_bg' => '#fee2e2',
                'icon_color' => '#ef4444',
                'icon' => 'users',
            ],
        ];
    }
}
