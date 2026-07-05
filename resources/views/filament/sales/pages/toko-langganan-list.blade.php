<x-filament-panels::page>
@php
    $toko = $this->toko;
    $kecamatanList = $this->kecamatanList;
    $activeTab = $this->activeTab;
@endphp

<div style="margin-bottom: 2rem;">
    <div class="tb-tab-container">
        <button 
            wire:click="setTab('kunjungan_hari_ini')"
            class="tb-tab-btn {{ $activeTab === 'kunjungan_hari_ini' ? 'tb-tab-btn-active' : 'tb-tab-btn-inactive' }}"
        >
            <x-heroicon-o-calendar-days style="width: 1.25rem; height: 1.25rem; flex-shrink: 0;" />
            Laporan Kunjungan
        </button>
        <button 
            wire:click="setTab('semua')"
            class="tb-tab-btn {{ $activeTab === 'semua' ? 'tb-tab-btn-active' : 'tb-tab-btn-inactive' }}"
        >
            <x-heroicon-o-building-storefront style="width: 1.25rem; height: 1.25rem; flex-shrink: 0;" />
            Semua Toko
        </button>
    </div>
</div>

<div class="catalog-wrapper">
    <div class="catalog-layout">
        {{-- Sidebar: Filter --}}
        <aside class="catalog-sidebar">
            <h2 class="sidebar-title">
                <x-heroicon-o-funnel class="title-icon" style="width: 1.5rem; height: 1.5rem; color: #dc2626;" />
                <span>Filter</span>
            </h2>
            
            @if($activeTab === 'kunjungan_hari_ini')
            <div class="filter-section" style="margin-bottom: 1.5rem;">
                <h3 class="filter-heading">Tanggal Kunjungan</h3>
                <div class="search-category" style="margin-bottom: 1rem;">
                    <input type="date" wire:model.live="filterTanggal" class="search-input" style="padding-right: 1rem; cursor: pointer; color: #4b5563;">
                </div>
            </div>
            @endif

            <div class="filter-section">
                <h3 class="filter-heading">Kecamatan</h3>
                <div class="search-category" style="margin-bottom: 1rem;">
                    <select wire:model.live="filterKecamatan" class="search-input" style="padding-right: 2.5rem; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239CA3AF%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 0.75rem top 50%; background-size: 0.65rem auto;">
                        <option value="">Semua Kecamatan</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            @if($activeTab === 'semua')
            <div class="filter-section" style="margin-top: 1.5rem;">
                <h3 class="filter-heading">Status Toko</h3>
                <div class="status-toggles">
                    <button wire:click="$set('statusFilter', 'semua')" class="status-btn {{ $statusFilter === 'semua' ? 'active' : '' }}">Semua</button>
                    <button wire:click="$set('statusFilter', 'buka')" class="status-btn {{ $statusFilter === 'buka' ? 'active' : '' }}">Buka</button>
                    <button wire:click="$set('statusFilter', 'tutup')" class="status-btn {{ $statusFilter === 'tutup' ? 'active' : '' }}">Tutup</button>
                </div>
            </div>
            @endif

            @if($activeTab === 'kunjungan_hari_ini')
            <div class="filter-section" style="margin-top: 1.5rem;">
                <h3 class="filter-heading">Hasil Kunjungan</h3>
                <div class="status-toggles" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <button wire:click="$set('filterHasilKunjungan', 'semua')" class="status-btn {{ $filterHasilKunjungan === 'semua' ? 'active' : '' }}" style="{{ $filterHasilKunjungan === 'semua' ? 'background-color: #f3f4f6; color: #111827; border: 1px solid #d1d5db;' : 'background-color: transparent; border: 1px solid #e5e7eb; color: #6b7280;' }}">Semua</button>
                    <button wire:click="$set('filterHasilKunjungan', 'sukses')" class="status-btn {{ $filterHasilKunjungan === 'sukses' ? 'active' : '' }}" style="{{ $filterHasilKunjungan === 'sukses' ? 'background-color: #991b1b; color: white; border-color: #991b1b;' : 'background-color: transparent; border: 1px solid #e5e7eb; color: #991b1b;' }}">Sukses (Order)</button>
                    <button wire:click="$set('filterHasilKunjungan', 'gagal')" class="status-btn {{ $filterHasilKunjungan === 'gagal' ? 'active' : '' }}" style="{{ $filterHasilKunjungan === 'gagal' ? 'background-color: #ef4444; color: white; border-color: #ef4444;' : 'background-color: transparent; border: 1px solid #e5e7eb; color: #ef4444;' }}">Gagal / Ditunda</button>
                </div>
            </div>
            @endif
            
        </aside>

        {{-- Main Content --}}
        <div class="catalog-main">
            @if($activeTab === 'kunjungan_hari_ini')
                {{-- Laporan Kunjungan UI --}}
                <div class="products-section">
                    <div class="products-header">
                        <h2 class="section-title">
                            <x-heroicon-o-clipboard-document-list class="title-icon" style="width: 1.5rem; height: 1.5rem; color: #dc2626;" />
                            <span>Riwayat Laporan Kunjungan</span>
                        </h2>
                        
                        <div class="products-controls" style="margin-right: 1.5rem;">
                            <div class="search-product" style="min-width: 350px;">
                                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari toko, owner, kecamatan..." class="search-input">
                                <x-heroicon-o-magnifying-glass class="search-icon" style="width: 1.25rem; height: 1.25rem;" />
                            </div>
                        </div>
                    </div>

                    @if($toko->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($toko as $kunjungan)
                        <div class="kunjungan-card" style="padding: 1.5rem; border-radius: 1rem; border: 1px solid #e5e7eb; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; gap: 1.5rem; flex-direction: column;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                                    <span style="font-weight: 700; font-size: 1.125rem; color: #111827;">{{ $kunjungan->buyer->nama_toko ?? '-' }}</span>
                                    @if(strtolower($kunjungan->hasil_kunjungan) == 'sukses')
                                        <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">Sukses</span>
                                    @else
                                        <span style="background: #fef2f2; color: #dc2626; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">Gagal / Ditunda</span>
                                    @endif
                                </div>
                                <div style="color: #6b7280; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                    <x-heroicon-o-clock style="width: 1rem; height: 1rem;" />
                                    {{ \Carbon\Carbon::parse($kunjungan->created_at)->format('H:i') }} WIB
                                    <span style="margin: 0 0.25rem;">&bull;</span>
                                    <x-heroicon-o-map-pin style="width: 1rem; height: 1rem;" />
                                    {{ $kunjungan->buyer->kecamatan->nama_kecamatan ?? '-' }}
                                </div>
                                
                                @if($kunjungan->catatan)
                                <div style="background: #f9fafb; padding: 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6;">
                                    <div style="font-size: 0.75rem; font-weight: 700; color: #6b7280; margin-bottom: 0.25rem;">Catatan Kunjungan</div>
                                    <div style="font-size: 0.875rem; color: #374151;">{{ $kunjungan->catatan }}</div>
                                </div>
                                @endif
                            </div>
                            
                            @if($kunjungan->foto)
                            <div style="width: 100%; max-width: 200px; border-radius: 0.75rem; overflow: hidden; border: 1px solid #e5e7eb; flex-shrink: 0; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('storage/' . str_replace('public/', '', $kunjungan->foto)) }}" alt="Foto Kunjungan" style="width: 100%; height: 150px; object-fit: cover;">
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="pagination-container" style="margin-top: 2rem;">
                        <span class="pagination-info">
                            Menampilkan {{ $toko->firstItem() }}-{{ $toko->lastItem() }} dari {{ $toko->total() }} laporan
                        </span>
                        
                        <div class="pagination-controls">
                            @if($toko->onFirstPage())
                                <span class="page-btn" style="opacity: 0.5; cursor: not-allowed;"><x-heroicon-o-chevron-left style="width: 1rem; height: 1rem;" /></span>
                            @else
                                <button wire:click="previousPage" class="page-btn"><x-heroicon-o-chevron-left style="width: 1rem; height: 1rem;" /></button>
                            @endif
                            
                            @foreach($toko->getUrlRange(max(1, $toko->currentPage()-2), min($toko->lastPage(), $toko->currentPage()+2)) as $page => $url)
                                @if($page == $toko->currentPage())
                                    <button class="page-num-btn active">{{ $page }}</button>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="page-num-btn">{{ $page }}</button>
                                @endif
                            @endforeach
                            
                            @if($toko->hasMorePages())
                                <button wire:click="nextPage" class="page-btn"><x-heroicon-o-chevron-right style="width: 1rem; height: 1rem;" /></button>
                            @else
                                <span class="page-btn" style="opacity: 0.5; cursor: not-allowed;"><x-heroicon-o-chevron-right style="width: 1rem; height: 1rem;" /></span>
                            @endif
                        </div>
                        
                        <div class="per-page-dropdown">
                            <select wire:model.live="perPage" class="per-page-select">
                                <option value="8">8 / halaman</option>
                                <option value="12">12 / halaman</option>
                                <option value="16">16 / halaman</option>
                                <option value="24">24 / halaman</option>
                            </select>
                        </div>
                    </div>
                    @else
                    <div class="empty-state" style="padding: 4rem 2rem; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 0.75rem;">
                        <div class="ts-empty-icon-wrapper">
                            <x-heroicon-o-clipboard-document-check class="ts-empty-icon" />
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 700; color: #111827; margin: 0;">Belum ada riwayat kunjungan</h3>
                        <p style="color: #6b7280; font-size: 0.875rem; margin: 0 0 0.5rem 0;">
                            @if($search || $filterKecamatan)
                                Tidak ada hasil yang sesuai dengan kriteria filter Anda.
                            @else
                                Belum ada laporan kunjungan toko yang tercatat.
                            @endif
                        </p>
                        @if($search || $filterKecamatan)
                        <button wire:click="$set('search', ''); $set('filterKecamatan', '')" style="background: none; border: none; color: #dc2626; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                            <x-heroicon-o-x-circle style="width: 1.25rem; height: 1.25rem;" />
                            Reset filter
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
            @else
                {{-- Default Product Section (Semua Toko) --}}
                <div class="products-section">
                <div class="products-header">
                    <h2 class="section-title">
                        <x-heroicon-o-building-storefront class="title-icon" style="width: 1.5rem; height: 1.5rem; color: #dc2626;" />
                        <span>Daftar Toko Langganan</span>
                    </h2>
                    
                    <div class="products-controls" style="margin-right: 1.5rem;">
                        <div class="search-product" style="min-width: 350px;">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari toko, owner, kecamatan..." class="search-input">
                            <x-heroicon-o-magnifying-glass class="search-icon" style="width: 1.25rem; height: 1.25rem;" />
                        </div>
                    </div>
                </div>

                {{-- Grid Cards --}}
                @if($toko->count() > 0)
                <div class="product-grid">
                    @foreach($toko as $item)
                    @php
                        $fotoUrls = [];
                        
                        if ($item->foto_toko) {
                            if (is_array($item->foto_toko)) {
                                foreach ($item->foto_toko as $foto) {
                                    $fotoPath = str_replace('public/', '', $foto);
                                    $fotoUrls[] = asset('storage/' . $fotoPath);
                                }
                            } else {
                                $fotoPath = str_replace('public/', '', $item->foto_toko);
                                $fotoUrls[] = asset('storage/' . $fotoPath);
                            }
                        }
                        
                        if (empty($fotoUrls)) {
                            $fotoUrls[] = asset('images/default-toko.png');
                        }

                        $jamBuka  = $item->jam_buka  ? \Carbon\Carbon::parse($item->jam_buka)->format('H.i')  : null;
                        $jamTutup = $item->jam_tutup ? \Carbon\Carbon::parse($item->jam_tutup)->format('H.i') : null;

                        $isOpen = false;
                        if ($jamBuka && $jamTutup) {
                            $now    = \Carbon\Carbon::now()->format('H:i');
                            $isOpen = $now >= \Carbon\Carbon::parse($item->jam_buka)->format('H:i')
                                   && $now <= \Carbon\Carbon::parse($item->jam_tutup)->format('H:i');
                        }
                    @endphp

                    <div class="product-card">
                        <div class="product-image-wrapper" style="padding: 0; position: relative;" x-data="{ currentSlide: 0, photos: {{ json_encode($fotoUrls) }}, get isMultiple() { return this.photos.length > 1 } }">
                            <img
                                :src="photos[currentSlide]"
                                alt="{{ $item->nama_toko }}"
                                class="product-image"
                                style="object-fit: cover; width: 100%; height: 100%; transition: opacity 0.3s ease-in-out;"
                                onerror="this.src='{{ asset('images/default-toko.png') }}'"
                            />
                            
                            {{-- Slider Controls --}}
                            <template x-if="isMultiple">
                                <div>
                                    <button @click.prevent="currentSlide = currentSlide === 0 ? photos.length - 1 : currentSlide - 1" class="slider-btn slider-prev">
                                        <x-heroicon-o-chevron-left style="width: 1.25rem; height: 1.25rem;" />
                                    </button>
                                    <button @click.prevent="currentSlide = currentSlide === photos.length - 1 ? 0 : currentSlide + 1" class="slider-btn slider-next">
                                        <x-heroicon-o-chevron-right style="width: 1.25rem; height: 1.25rem;" />
                                    </button>
                                    
                                    <div class="slider-indicators">
                                        <template x-for="(photo, index) in photos" :key="index">
                                            <button @click.prevent="currentSlide = index" :class="{'active': currentSlide === index}" class="slider-dot"></button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            
                            {{-- Kecamatan Badge --}}
                            @if($item->kecamatan)
                            <span class="custom-badge badge-top-left">
                                <x-heroicon-o-map-pin style="width: 0.875rem; height: 0.875rem; color: #dc2626;" />
                                {{ $item->kecamatan->nama_kecamatan }}
                            </span>
                            @endif
                            
                            {{-- Status Badge --}}
                            @if($jamBuka && $jamTutup)
                            <span class="custom-badge badge-bottom-left" style="background-color: {{ $isOpen ? '#dcfce7' : '#fee2e2' }}; color: {{ $isOpen ? '#16a34a' : '#dc2626' }}; border-color: {{ $isOpen ? '#bbf7d0' : '#fecaca' }}; font-weight: 700;">
                                {{ $isOpen ? 'Buka' : 'Tutup' }}
                            </span>
                            @endif
                        </div>
                        
                        <div class="product-details" style="padding: 1.25rem;">
                            <h3 class="product-name" style="-webkit-line-clamp: 1;">{{ $item->nama_toko }}</h3>
                            
                            <div class="product-info-list" style="margin-top: 0.75rem; display: flex; flex-direction: column; gap: 0.5rem;">
                                <div class="info-item">
                                    <x-heroicon-o-user style="width: 1rem; height: 1rem; color: #3b82f6; flex-shrink: 0;" />
                                    <span class="info-text" style="color: #475569;">{{ $item->nama_owner ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <x-heroicon-o-phone style="width: 1rem; height: 1rem; color: #10b981; flex-shrink: 0;" />
                                    <span class="info-text" style="color: #475569;">{{ $item->no_hp ?? '-' }}</span>
                                </div>
                            </div>
                            
                            {{-- Operational Hours Box --}}
                            <div style="margin-top: 1.25rem; background-color: #f0f9ff; border: 1px solid #e0f2fe; border-radius: 0.5rem; padding: 0.75rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                                <x-heroicon-o-clock style="width: 1.25rem; height: 1.25rem; color: #2563eb; flex-shrink: 0; margin-top: 0.125rem;" />
                                <div style="display: flex; flex-direction: column; gap: 0.125rem;">
                                    <span style="font-size: 0.875rem; font-weight: 600; color: #1e293b;">
                                        @if($jamBuka && $jamTutup)
                                            {{ $jamBuka }} - {{ $jamTutup }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                    @if($item->hari_operasional)
                                    <span style="font-size: 0.75rem; color: #64748b;">{{ $item->hari_operasional }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Full-width Button --}}
                            <button type="button" wire:click="mountAction('viewToko', { record: {{ $item->id }} })" class="lihat-detail-btn" style="width: 100%; margin-top: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.375rem; padding: 0.625rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; transition: background-color 0.2s; cursor: pointer; background-color: #ef4444; color: white; border: none;">
                                <x-heroicon-o-eye style="width: 1.125rem; height: 1.125rem;" />
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="pagination-container" style="margin-top: 2rem;">
                    <span class="pagination-info">
                        Menampilkan {{ $toko->firstItem() }}-{{ $toko->lastItem() }} dari {{ $toko->total() }} toko
                    </span>
                    
                    <div class="pagination-controls">
                        @if($toko->onFirstPage())
                            <span class="page-btn" style="opacity: 0.5; cursor: not-allowed;"><x-heroicon-o-chevron-left style="width: 1rem; height: 1rem;" /></span>
                        @else
                            <button wire:click="previousPage" class="page-btn"><x-heroicon-o-chevron-left style="width: 1rem; height: 1rem;" /></button>
                        @endif
                        
                        @foreach($toko->getUrlRange(max(1, $toko->currentPage()-2), min($toko->lastPage(), $toko->currentPage()+2)) as $page => $url)
                            @if($page == $toko->currentPage())
                                <button class="page-num-btn active">{{ $page }}</button>
                            @else
                                <button wire:click="gotoPage({{ $page }})" class="page-num-btn">{{ $page }}</button>
                            @endif
                        @endforeach
                        
                        @if($toko->hasMorePages())
                            <button wire:click="nextPage" class="page-btn"><x-heroicon-o-chevron-right style="width: 1rem; height: 1rem;" /></button>
                        @else
                            <span class="page-btn" style="opacity: 0.5; cursor: not-allowed;"><x-heroicon-o-chevron-right style="width: 1rem; height: 1rem;" /></span>
                        @endif
                    </div>
                    
                    <div class="per-page-dropdown">
                        <select wire:model.live="perPage" class="per-page-select">
                            <option value="8">8 / halaman</option>
                            <option value="12">12 / halaman</option>
                            <option value="16">16 / halaman</option>
                            <option value="24">24 / halaman</option>
                        </select>
                    </div>
                </div>
                
                @else
                <div class="empty-state" style="padding: 4rem 2rem; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 0.75rem;">
                    <div class="ts-empty-icon-wrapper">
                        <x-heroicon-o-building-storefront class="ts-empty-icon" />
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: #111827; margin: 0;">Tidak ada toko ditemukan</h3>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0 0 0.5rem 0;">
                        @if($search || $filterKecamatan || $statusFilter !== 'semua')
                            Tidak ada hasil yang sesuai dengan kriteria filter Anda.
                        @else
                            Belum ada data toko yang ditambahkan.
                        @endif
                    </p>
                    @if($search || $filterKecamatan || $statusFilter !== 'semua')
                    <button wire:click="$set('search', ''); $set('filterKecamatan', ''); $set('statusFilter', 'semua')" style="background: none; border: none; color: #dc2626; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                        <x-heroicon-o-x-circle style="width: 1.25rem; height: 1.25rem;" />
                        Reset semua filter
                    </button>
                    @endif
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom Empty State Styling */
    .ts-empty-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3.5rem;
        height: 3.5rem;
        background-color: #fee2e2;
        border-radius: 9999px;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.03);
        margin-bottom: 0.25rem;
        transition: all 0.2s ease-in-out;
    }
    .ts-empty-icon {
        width: 1.75rem;
        height: 1.75rem;
        color: #dc2626;
    }
    html.dark .ts-empty-icon-wrapper {
        background-color: rgba(220, 38, 38, 0.15);
    }
    html.dark .ts-empty-icon {
        color: #f87171;
    }
    html.dark .empty-state h3 {
        color: #f3f4f6 !important;
    }
    html.dark .empty-state p {
        color: #9ca3af !important;
    }

    /* Tabs */
    .tb-tab-container {
        display: inline-flex;
        background-color: #ffffff;
        border-radius: 0.75rem;
        padding: 0.375rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(229, 231, 235, 0.5);
        overflow-x: auto;
        max-width: 100%;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .tb-tab-container::-webkit-scrollbar {
        display: none;
    }
    .tb-tab-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.625rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.2s ease-in-out;
        border: none;
        cursor: pointer;
        outline: none;
    }
    .tb-tab-btn-active {
        background-color: #dc2626;
        color: white;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }
    .tb-tab-btn-inactive {
        background-color: transparent;
        color: #6b7280;
    }
    .tb-tab-btn-inactive:hover {
        background-color: #f9fafb;
        color: #111827;
    }

    .catalog-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        padding-bottom: 3rem;
    }

    .catalog-layout {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    @media (min-width: 1024px) {
        .catalog-layout {
            flex-direction: row;
            align-items: flex-start;
        }
    }

    /* Sidebar Styling */
    .catalog-sidebar {
        background-color: #ffffff;
        border-radius: 1rem;
        padding: 1.5rem;
        width: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
    }

    @media (min-width: 1024px) {
        .catalog-sidebar {
            flex: 0 0 16rem; /* 256px */
            position: sticky;
            top: 2rem; /* Adjusted for better sticky behavior without stats header */
        }
    }

    .sidebar-title {
        font-size: 1.125rem;
        font-weight: 800;
        color: #111827;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .filter-heading {
        font-size: 0.875rem;
        font-weight: 700;
        color: #374151;
        margin: 0 0 0.75rem 0;
    }

    .search-category {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 0.625rem 2.5rem 0.625rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
        font-size: 0.875rem;
        color: #374151;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.1);
        background-color: #ffffff;
    }

    .search-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    
    .status-toggles {
        display: flex;
        gap: 0.5rem;
        background: #f9fafb;
        padding: 0.375rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
    }
    
    .status-btn {
        flex: 1;
        text-align: center;
        padding: 0.5rem 0;
        border: none;
        background: transparent;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .status-btn:hover:not(.active) {
        color: #374151;
        background: #f3f4f6;
    }
    
    .status-btn.active {
        background: #fef2f2;
        color: #dc2626;
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    
    .reset-filter-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .reset-filter-btn:hover {
        background: #fee2e2;
    }

    /* Main Content */
    .catalog-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        min-width: 0;
    }

    .products-section {
        background-color: #ffffff;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .products-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    @media (min-width: 768px) {
        .products-header {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #111827;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .products-controls {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }

    @media (min-width: 640px) {
        .product-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (min-width: 1024px) {
        .product-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (min-width: 1280px) {
        .product-grid { grid-template-columns: repeat(3, 1fr); }
    }

    .product-card {
        background-color: #ffffff;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s, transform 0.2s, border-color 0.2s;
    }

    .product-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
        border-color: #d1d5db;
    }

    .product-image-wrapper {
        width: 100%;
        height: 12rem;
        background-color: #f3f4f6;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #f3f4f6;
    }
    
    /* Slider Styles */
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.7);
        border: none;
        border-radius: 50%;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #374151;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s, background 0.2s;
    }
    
    .product-image-wrapper:hover .slider-btn {
        opacity: 1;
    }
    
    .slider-btn:hover {
        background: rgba(255, 255, 255, 1);
        color: #dc2626;
    }
    
    .slider-prev { left: 0.5rem; }
    .slider-next { right: 0.5rem; }
    
    .slider-indicators {
        position: absolute;
        bottom: 0.75rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 0.25rem;
        z-index: 10;
        background: rgba(0,0,0,0.2);
        padding: 0.25rem 0.5rem;
        border-radius: 1rem;
    }
    
    .slider-dot {
        width: 0.375rem;
        height: 0.375rem;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .slider-dot.active {
        background: #ffffff;
        transform: scale(1.2);
    }
    
    .custom-badge {
        position: absolute;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background-color: #ffffff;
        padding: 0.375rem 0.625rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        border: 1px solid #f3f4f6;
    }
    
    .badge-top-left {
        top: 0.75rem;
        left: 0.75rem;
        color: #4b5563;
    }
    
    .badge-bottom-left {
        bottom: 0.75rem;
        left: 0.75rem;
    }
    
    .status-dot {
        width: 0.375rem;
        height: 0.375rem;
        border-radius: 50%;
    }

    .product-details {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-text {
        font-size: 0.875rem;
        color: #6b7280;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .detail-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        border: 1px solid #fca5a5;
        border-radius: 0.5rem;
        background-color: #ffffff;
        color: #dc2626;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .detail-btn:hover {
        background-color: #fef2f2;
        border-color: #ef4444;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        margin-top: 1.5rem;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f3f4f6;
    }

    @media (min-width: 768px) {
        .pagination-container {
            flex-direction: row;
        }
    }

    .pagination-info {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .page-btn, .page-num-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .page-btn:not([disabled]):hover, .page-num-btn:not(.active):hover {
        background-color: #f9fafb;
        border-color: #d1d5db;
        color: #111827;
    }
    
    .page-num-btn.active {
        background-color: #dc2626;
        border-color: #dc2626;
        color: #ffffff;
        font-weight: 600;
    }

    .per-page-dropdown .per-page-select {
        padding: 0.5rem 2.5rem 0.5rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        outline: none;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
    }

    /* Additional Custom Styles extracted from inline for dark mode support */
    .lihat-detail-btn {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
    }
    .lihat-detail-btn:hover {
        background-color: #fee2e2;
    }
    @media (min-width: 768px) {
        .kunjungan-card {
            flex-direction: row !important;
        }
    }

    /* Dark Mode Overrides */
    html.dark .tb-tab-container,
    html.dark .catalog-sidebar,
    html.dark .products-section,
    html.dark .product-card,
    html.dark .kunjungan-card,
    html.dark .per-page-select,
    html.dark .page-btn:not([disabled]),
    html.dark .page-num-btn:not(.active) {
        background-color: #18181b !important;
        border-color: #3f3f46 !important;
    }
    html.dark .page-btn:not([disabled]):hover,
    html.dark .page-num-btn:not(.active):hover {
        background-color: #27272a !important;
        border-color: #52525b !important;
        color: #f8fafc !important;
    }
    html.dark .product-image-wrapper {
        background-color: #27272a !important;
        border-color: #3f3f46 !important;
    }
    html.dark .sidebar-title,
    html.dark .section-title,
    html.dark .product-name,
    html.dark .page-num-btn:not(.active) {
        color: #f3f4f6 !important;
        border-color: #3f3f46 !important;
    }
    html.dark .filter-heading {
        color: #d1d5db !important;
    }
    html.dark .search-input {
        background-color: #27272a !important;
        border-color: #3f3f46 !important;
        color: #f3f4f6 !important;
    }
    html.dark .status-toggles {
        background-color: #27272a !important;
        border-color: #3f3f46 !important;
    }
    html.dark .status-btn {
        color: #9ca3af !important;
        border-color: #3f3f46 !important;
    }
    html.dark .status-btn:hover:not(.active) {
        background-color: #3f3f46 !important;
        color: #f3f4f6 !important;
    }
    
    html.dark .status-btn[wire\:click*="'semua'"].active {
        background-color: #3f3f46 !important;
        color: #f3f4f6 !important;
        border-color: #52525b !important;
    }
    html.dark .status-btn[wire\:click*="'sukses'"].active {
        background-color: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
        border-color: rgba(16, 185, 129, 0.3) !important;
    }
    html.dark .status-btn[wire\:click*="'gagal'"].active {
        background-color: rgba(239, 68, 68, 0.2) !important;
        color: #f87171 !important;
        border-color: rgba(239, 68, 68, 0.3) !important;
    }

    html.dark .custom-badge {
        background-color: #27272a !important;
        border-color: #3f3f46 !important;
        color: #d1d5db !important;
    }
    html.dark .custom-badge[style*="background-color: #dcfce7"] {
        background-color: rgba(22, 163, 74, 0.2) !important;
        border-color: rgba(22, 163, 74, 0.3) !important;
        color: #4ade80 !important;
    }
    html.dark .custom-badge[style*="background-color: #fee2e2"] {
        background-color: rgba(220, 38, 38, 0.2) !important;
        border-color: rgba(220, 38, 38, 0.3) !important;
        color: #f87171 !important;
    }
    
    html.dark .products-header {
        border-color: #3f3f46 !important;
    }
    
    /* Inline styles overrides */
    html.dark [style*="color: #111827"] {
        color: #f3f4f6 !important;
    }
    html.dark [style*="color: #374151"] {
        color: #d1d5db !important;
    }
    html.dark [style*="color: #6b7280"] {
        color: #9ca3af !important;
    }
    html.dark [style*="color: #475569"] {
        color: #94a3b8 !important;
    }
    html.dark [style*="color: #1e293b"] {
        color: #f8fafc !important;
    }
    html.dark [style*="color: #64748b"] {
        color: #cbd5e1 !important;
    }
    
    html.dark [style*="background: #f9fafb"],
    html.dark [style*="background-color: #f3f4f6"] {
        background: #27272a !important;
        background-color: #27272a !important;
        border-color: #3f3f46 !important;
    }
    
    html.dark [style*="background-color: #f0f9ff"] {
        background-color: rgba(37, 99, 235, 0.1) !important;
        border-color: rgba(37, 99, 235, 0.2) !important;
    }
    
    html.dark .lihat-detail-btn {
        background-color: rgba(220, 38, 38, 0.1) !important;
        border-color: rgba(220, 38, 38, 0.2) !important;
        color: #f87171 !important;
    }
    .lihat-detail-btn {
        background-color: #ef4444;
        color: white;
        border: none;
        position: relative;
        overflow: hidden;
    }
    .lihat-detail-btn:hover {
        background-color: #dc2626;
    }
</style>
    <x-filament-actions::modals />
</x-filament-panels::page>
