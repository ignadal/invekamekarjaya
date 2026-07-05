<?php

namespace App\Filament\Sales\Resources\TokoLanggananResource\Pages;

use App\Filament\Sales\Resources\TokoLanggananResource;
use App\Models\Buyer;
use App\Models\Kecamatan;
use App\Models\KunjunganSales;
use App\Models\Sales;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
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

    public string $filterTanggal = '';

    public string $search = '';
    public string $filterKecamatan = '';
    public string $statusFilter = 'semua';
    public string $filterHasilKunjungan = 'semua';
    public ?string $activeTab = 'kunjungan_hari_ini';
    public int $perPage = 8;

    public function mount(): void
    {
        parent::mount();
        $this->filterTanggal = \Carbon\Carbon::today()->toDateString();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

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

    public function updatingFilterHasilKunjungan(): void
    {
        $this->resetPage();
    }

    public function updatingFilterTanggal(): void
    {
        $this->resetPage();
    }

    public function getTokoProperty()
    {
        $now = \Carbon\Carbon::now()->format('H:i');
        $sales = \App\Models\Sales::where('user_id', auth()->id())->first();

        if ($this->activeTab === 'kunjungan_hari_ini') {
            return \App\Models\KunjunganSales::with('buyer.kecamatan')
                ->where('sales_id', $sales?->id)
                ->when($this->search, function ($q) {
                    $q->whereHas('buyer', function ($query) {
                        $query->where('nama_toko', 'like', '%' . $this->search . '%')
                              ->orWhere('nama_owner', 'like', '%' . $this->search . '%')
                              ->orWhereHas('kecamatan', fn ($k) => $k->where('nama_kecamatan', 'like', '%' . $this->search . '%'));
                    });
                })
                ->when($this->filterKecamatan, function ($q) {
                    $q->whereHas('buyer', fn($query) => $query->where('kecamatan_id', $this->filterKecamatan));
                })
                ->when($this->filterTanggal, function ($q) {
                    $q->whereDate('tanggal_kunjungan', $this->filterTanggal);
                })
                ->when($this->filterHasilKunjungan !== 'semua', function ($q) {
                    $q->where('hasil_kunjungan', $this->filterHasilKunjungan);
                })
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);
        }

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
        return [
            Action::make('tambah_kunjungan')
                ->label('Kunjungan Baru')
                ->icon('heroicon-o-plus')
                ->color('danger')
                ->modalHeading('Tambah Laporan Kunjungan')
                ->modalSubmitActionLabel('Simpan Laporan')
                ->form([
                    Select::make('buyer_id')
                        ->label('Pilih Toko')
                        ->options(Buyer::query()->pluck('nama_toko', 'id'))
                        ->searchable()
                        ->required(),
                    Select::make('hasil_kunjungan')
                        ->label('Hasil Kunjungan')
                        ->options([
                            'sukses' => 'Sukses (Order)',
                            'gagal' => 'Gagal / Ditunda',
                        ])
                        ->required(),
                    Textarea::make('catatan')
                        ->label('Catatan Kunjungan')
                        ->rows(3)
                        ->placeholder('Opsional'),
                    FileUpload::make('foto')
                        ->label('Foto Bukti Kunjungan (Opsional)')
                        ->image()
                        ->directory('kunjungan-sales'),
                ])
                ->action(function (array $data) {
                    $sales = Sales::where('user_id', auth()->id())->first();
                    if (!$sales) {
                        \Filament\Notifications\Notification::make()
                            ->title('Gagal, data Sales tidak ditemukan.')
                            ->danger()
                            ->send();
                        return;
                    }

                    KunjunganSales::create([
                        'sales_id' => $sales->id,
                        'buyer_id' => $data['buyer_id'],
                        'tanggal_kunjungan' => now()->toDateString(),
                        'hasil_kunjungan' => $data['hasil_kunjungan'],
                        'catatan' => $data['catatan'] ?? null,
                        'foto' => $data['foto'] ?? null,
                    ]);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Laporan Kunjungan berhasil ditambahkan!')
                        ->success()
                        ->send();
                })
        ];
    }
    
    public function viewTokoAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('viewToko')
            ->modalHeading('Detail Toko')
            ->modalSubmitAction(false)
            ->modalCancelAction(fn ($action) => $action->label('Tutup'))
            ->record(function (array $arguments) {
                return Buyer::find($arguments['record'] ?? null);
            })
            ->infolist(function (\Filament\Schemas\Schema $schema) {
                return TokoLanggananResource::infolist($schema);
            });
    }
}
