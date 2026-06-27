<?php

namespace App\Filament\Sales\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\Penjualan;
use App\Models\Sales;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Livewire\WithPagination;

class Transaksi extends Page
{
    use WithPagination;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';

    protected string $view = 'filament.sales.pages.transaksi';
    
    protected static ?string $navigationLabel = 'Orderan';
    
    protected static ?string $title = 'Penjualan & Penagihan';
    
    protected static ?int $navigationSort = 3;

    public $activeTab = 'penjualan';
    
    public $filterTanggal = null;
    public $filterToko = null;
    public $filterMetode = null;
    public $filterStatus = null;
    public $search = '';
    public $perPage = 10;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function resetFilters()
    {
        $this->filterTanggal = null;
        $this->filterToko = null;
        $this->filterMetode = null;
        $this->filterStatus = null;
        $this->search = '';
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make('tambahPenjualan')
                ->model(Penjualan::class)
                ->label('Buat Orderan')
                ->icon('heroicon-o-plus')
                ->color('danger')
                ->modalHeading(new \Illuminate\Support\HtmlString('
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="background-color: #E30613; padding: 0.5rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 1.5rem; height: 1.5rem; color: white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span style="font-weight: 700; color: #111827;">Tambah Orderan Baru</span>
                    </div>
                '))
                ->modalSubmitAction(fn ($action) => $action->label('Buat Orderan')->icon('heroicon-o-document-plus'))
                ->modalCancelActionLabel('Batalkan')
                ->createAnother(false)
                ->form(function(Schema $schema) {
                    return \App\Filament\Resources\Penjualans\Schemas\PenjualanForm::configure($schema);
                })
                ->mutateFormDataUsing(function (array $data): array {
                    $sales = Sales::where('user_id', auth()->id())->first();
                    $data['sales_id'] = $sales ? $sales->id : null;
                    $data['status_persetujuan'] = 'pending';
                    return $data;
                })
                ->after(function (Penjualan $record) {
                    // Update stocks based on details
                    foreach ($record->details as $item) {
                        $barang = \App\Models\Barang::find($item->barang_id);
                        if ($barang) {
                            $barang->decrement('stok', $item->qty);
                        }
                    }

                    // Create DP (CicilanBuyer) if there is a payment
                    if ($record->sudah_dibayar > 0) {
                        \App\Models\CicilanBuyer::create([
                            'penjualan_id' => $record->id,
                            'nominal' => $record->sudah_dibayar,
                            'tanggal_bayar' => $record->tanggal_beli,
                            'keterangan' => 'Pembayaran Awal (' . $record->metode . ')',
                            'status_persetujuan' => 'pending',
                        ]);
                    }
                })
                ->successNotificationTitle('Orderan berhasil dibuat!')
        ];
    }

    protected function getViewData(): array
    {
        $salesId = Sales::where('user_id', auth()->id())->first()?->id ?? -1;
        
        $baseQuery = Penjualan::query()->where('sales_id', $salesId);
        
        // Apply Global Filters
        if ($this->filterToko) $baseQuery->where('buyer_id', $this->filterToko);
        if ($this->filterMetode) $baseQuery->where('metode', $this->filterMetode);
        if ($this->filterStatus) $baseQuery->where('status_persetujuan', $this->filterStatus);
        if ($this->search) {
            $baseQuery->where(function($q) {
                $q->whereHas('buyer', function($q2) {
                    $q2->where('nama_toko', 'like', '%' . $this->search . '%');
                })->orWhere('metode', 'like', '%' . $this->search . '%');
            });
        }

        // Table Query (Applies Date Filter if present)
        $tableQuery = clone $baseQuery;
        if ($this->filterTanggal) {
            $tableQuery->whereDate('tanggal_beli', $this->filterTanggal);
        }
        // Stats Query (Exactly matches the filtered table BEFORE tab modifications)
        $currentCount = (clone $tableQuery)->count();
        $currentPendapatan = (clone $tableQuery)->sum('total_penjualan');
        $avgOrder = $currentCount > 0 ? $currentPendapatan / $currentCount : 0;
        
        $lunasCount = (clone $tableQuery)->where('status_bayar', 'lunas')->count();
        $konversi = $currentCount > 0 ? ($lunasCount / $currentCount) * 100 : 0;

        // Apply Tab Filters to the list records
        $listQuery = clone $tableQuery;
        if ($this->activeTab === 'penagihan') {
            $listQuery->where('metode', 'cicil')->where('status_persetujuan', 'disetujui');
        }

        $records = $listQuery->latest('tanggal_beli')->paginate($this->perPage);
        $konversi = $currentCount > 0 ? ($lunasCount / $currentCount) * 100 : 0;

        $penagihanCount = 0;
        $penagihanTotalTagihan = 0;
        $penagihanTotalDibayar = 0;
        
        if ($this->activeTab === 'penagihan') {
            $penagihanCount = (clone $listQuery)->count();
            $penagihanTotalTagihan = (clone $listQuery)->sum('total_penjualan');
            $penagihanTotalDibayar = (clone $listQuery)->sum('sudah_dibayar');
        }
        $penagihanSisa = max(0, $penagihanTotalTagihan - $penagihanTotalDibayar);

        // Last Period Query for Growth calculation
        $lastQuery = clone $baseQuery;
        if ($this->filterTanggal) {
            $lastQuery->whereDate('tanggal_beli', \Carbon\Carbon::parse($this->filterTanggal)->subMonth());
        } else {
            $lastQuery->where('tanggal_beli', '<=', now()->subMonth());
        }
        
        $lastCount = (clone $lastQuery)->count();
        $lastPendapatan = (clone $lastQuery)->sum('total_penjualan');
        
        $penjualanGrowth = $lastCount > 0 ? (($currentCount - $lastCount) / $lastCount) * 100 : ($currentCount > 0 ? 100 : 0);
        $pendapatanGrowth = $lastPendapatan > 0 ? (($currentPendapatan - $lastPendapatan) / $lastPendapatan) * 100 : ($currentPendapatan > 0 ? 100 : 0);

        $tokos = \App\Models\Buyer::all();

        return [
            'stats' => [
                'total_order' => $currentCount,
                'order_growth' => round($penjualanGrowth, 1),
                'total_pendapatan' => $currentPendapatan,
                'pendapatan_growth' => round($pendapatanGrowth, 1),
                'avg_order' => $avgOrder,
                'konversi' => round($konversi, 1),
                'lunas_count' => $lunasCount,
                'penagihan_count' => $penagihanCount,
                'penagihan_total_tagihan' => $penagihanTotalTagihan,
                'penagihan_total_dibayar' => $penagihanTotalDibayar,
                'penagihan_sisa' => $penagihanSisa,
            ],
            'tokos' => $tokos,
            'records' => $records,
        ];
    }
}
