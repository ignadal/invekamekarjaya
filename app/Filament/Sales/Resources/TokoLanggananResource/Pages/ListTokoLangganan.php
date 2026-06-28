<?php

namespace App\Filament\Sales\Resources\TokoLanggananResource\Pages;

use App\Filament\Sales\Resources\TokoLanggananResource;
use App\Models\Buyer;
use App\Models\Kecamatan;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\WithPagination;

class ListTokoLangganan extends ListRecords
{
    protected static string $resource = TokoLanggananResource::class;

    // Override view ke blade custom kita
    public function getView(): string
    {
        return 'filament.sales.pages.toko-langganan-list';
    }

    public string $search = '';
    public string $filterKecamatan = '';
    public string $statusFilter = 'semua';
    public int $perPage = 8;

    public function getBreadcrumbs(): array
    {
        return [];
    }



    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterKecamatan(): void
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function getTokoProperty()
    {
        $now = \Carbon\Carbon::now()->format('H:i');

        return Buyer::with('kecamatan')
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('nama_toko', 'like', '%' . $this->search . '%')
                          ->orWhere('nama_owner', 'like', '%' . $this->search . '%')
                          ->orWhereHas('kecamatan', fn ($k) => $k->where('nama_kecamatan', 'like', '%' . $this->search . '%'));
                });
            })
            ->when($this->filterKecamatan, fn ($q) => $q->where('kecamatan_id', $this->filterKecamatan))
            ->when($this->statusFilter !== 'semua', function ($q) use ($now) {
                if ($this->statusFilter === 'buka') {
                    $q->where('jam_buka', '<=', $now)
                      ->where('jam_tutup', '>=', $now);
                } elseif ($this->statusFilter === 'tutup') {
                    $q->where(function($query) use ($now) {
                        $query->where('jam_buka', '>', $now)
                              ->orWhere('jam_tutup', '<', $now)
                              ->orWhereNull('jam_buka')
                              ->orWhereNull('jam_tutup');
                    });
                }
            })
            ->whereNull('deleted_at')
            ->paginate($this->perPage);
    }

    public function getKecamatanListProperty()
    {
        return Kecamatan::orderBy('nama_kecamatan')->get();
    }

    public function getViewData(): array
    {
        return [
            'toko'          => $this->toko,
            'kecamatanList' => $this->kecamatanList,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
