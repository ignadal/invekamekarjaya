<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PembelianSupplier;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Session;

class JatuhTempoNotification extends Component
{
    public $allNotifications = [];
    public $currentIndex = 0;
    public $isOpen = false;

    public function mount()
    {
        if (!Session::has('jatuh_tempo_notified')) {
            $sekarang = now()->startOfDay();
            $batasTempo = now()->addDays(3)->endOfDay();

            $pending = Penjualan::with('buyer', 'sales')
                ->where('status_persetujuan', 'pending')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => 'p_pending_' . $item->id,
                        'type' => 'pending',
                        'title' => 'Butuh Persetujuan (ACC Penjualan)',
                        'name' => $item->buyer->nama_toko ?? 'Unknown',
                        'amount_label' => 'Total',
                        'amount' => $item->total_penjualan,
                        'info' => 'Sales: ' . ($item->sales->nama_sales ?? '-'),
                        'url' => \App\Filament\Resources\Penjualans\PenjualanResource::getUrl('index'),
                        'icon' => 'heroicon-o-clipboard-document-check',
                        'color' => 'warning',
                        'is_telat' => false,
                    ];
                });

            $hutang = PembelianSupplier::with('supplier')
                ->where('metode', 'nyicil')
                ->whereIn('status', ['sebagian', 'belum_dibayar'])
                ->whereNotNull('jatuh_tempo')
                ->where('jatuh_tempo', '<=', $batasTempo)
                ->get()
                ->map(function ($item) {
                    $jatuhTempo = \Carbon\Carbon::parse($item->jatuh_tempo)->startOfDay();
                    $isTelat = $jatuhTempo->isBefore(now()->startOfDay());
                    $diffDays = now()->startOfDay()->diffInDays($jatuhTempo);
                    $tempoText = $isTelat ? 'Terlambat' : 'H-' . $diffDays;

                    return [
                        'id' => 'h_' . $item->id,
                        'type' => 'hutang',
                        'title' => 'Tagihan Pembelian (Hutang)',
                        'name' => $item->supplier->nama_supplier ?? 'Unknown',
                        'amount_label' => 'Sisa Hutang',
                        'amount' => $item->sisa_pembayaran,
                        'info' => 'Tempo: ' . $jatuhTempo->format('d M Y') . ' (' . $tempoText . ')',
                        'url' => \App\Filament\Resources\PembelianSuppliers\PembelianSupplierResource::getUrl('index'),
                        'icon' => 'heroicon-o-arrow-down-tray',
                        'color' => 'danger',
                        'is_telat' => $isTelat,
                    ];
                });

            $piutang = Penjualan::with('buyer')
                ->where('metode', 'cicil')
                ->whereIn('status_bayar', ['sebagian', 'belum_dibayar'])
                ->where('status_persetujuan', 'disetujui')
                ->whereNotNull('jatuh_tempo')
                ->where('jatuh_tempo', '<=', $batasTempo)
                ->get()
                ->map(function ($item) {
                    $jatuhTempo = \Carbon\Carbon::parse($item->jatuh_tempo)->startOfDay();
                    $isTelat = $jatuhTempo->isBefore(now()->startOfDay());
                    $diffDays = now()->startOfDay()->diffInDays($jatuhTempo);
                    $tempoText = $isTelat ? 'Terlambat' : 'H-' . $diffDays;

                    return [
                        'id' => 'pi_' . $item->id,
                        'type' => 'piutang',
                        'title' => 'Tagihan Penjualan (Piutang)',
                        'name' => $item->buyer->nama_toko ?? 'Unknown',
                        'amount_label' => 'Sisa Piutang',
                        'amount' => $item->sisa_pembayaran,
                        'info' => 'Tempo: ' . $jatuhTempo->format('d M Y') . ' (' . $tempoText . ')',
                        'url' => \App\Filament\Resources\Penjualans\PenjualanResource::getUrl('index'),
                        'icon' => 'heroicon-o-arrow-up-tray',
                        'color' => 'danger',
                        'is_telat' => $isTelat,
                    ];
                });

            $this->allNotifications = collect()->merge($pending)->merge($hutang)->merge($piutang)->toArray();

            if (count($this->allNotifications) > 0) {
                $this->isOpen = true;
            }
        }
    }

    public function next()
    {
        if ($this->currentIndex < count($this->allNotifications) - 1) {
            $this->currentIndex++;
        }
    }

    public function prev()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        Session::put('jatuh_tempo_notified', true);
        $this->dispatch('close-modal', id: 'jatuh-tempo-modal');
    }

    public function render()
    {
        return view('livewire.jatuh-tempo-notification');
    }
}
