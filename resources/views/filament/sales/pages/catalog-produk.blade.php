<x-filament-panels::page>
    
    <div class="space-y-12 pb-10" x-data="{ activeTab: 'all' }">
        
        {{-- Kategori --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-4 border-l-4 border-red-600 pl-3">
                Kategori
            </h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <div @click="activeTab = activeTab === '{{ $category->id }}' ? 'all' : '{{ $category->id }}'" 
                         :class="{ 'ring-2 ring-red-600 shadow-md': activeTab === '{{ $category->id }}', 'border border-gray-200 hover:shadow-md': activeTab !== '{{ $category->id }}' }"
                         class="bg-white rounded-lg p-4 flex items-center shadow-sm transition-all cursor-pointer">
                        <div class="bg-red-50 text-red-600 p-2 rounded-md mr-3">
                            <x-heroicon-o-tag class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm line-clamp-1">{{ $category->nama_kategori }}</h3>
                            <p class="text-xs text-gray-500">{{ $category->barangs_count }} Produk</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Produk --}}
        <div class="pt-2">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 border-l-4 border-red-600 pl-3 whitespace-nowrap">
                    Produk
                </h2>
                
                {{-- Reset Filter Button --}}
                <div x-show="activeTab !== 'all'" style="display: none;" x-transition>
                    <button @click="activeTab = 'all'" class="text-sm font-semibold text-red-600 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-full flex items-center gap-1 transition-colors">
                        <x-heroicon-o-x-mark style="width: 1rem; height: 1rem;" />
                        Hapus Filter
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($newArrivals as $barang)
                    <div x-show="activeTab === 'all' || activeTab === '{{ $barang->kategori_barang_id }}'" 
                         class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all group flex flex-col h-full">
                        
                        <div class="w-full h-48 bg-gray-50 p-4 relative flex items-center justify-center border-b border-gray-100">
                            @if($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                <div style="display: none;" class="flex-col items-center justify-center text-gray-400">
                                    <x-heroicon-o-photo style="width: 3rem; height: 3rem;" />
                                    <span class="text-xs mt-1 font-medium">Gambar Rusak</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <x-heroicon-o-photo style="width: 3rem; height: 3rem;" />
                                    <span class="text-xs mt-1 font-medium">Tanpa Foto</span>
                                </div>
                            @endif
                            
                            <span class="absolute top-2 right-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase tracking-wide">
                                {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>
                        
                        <div class="p-4 flex flex-col flex-grow justify-between">
                            <h3 class="text-gray-900 font-bold text-sm mb-3 line-clamp-2 leading-snug group-hover:text-red-600 transition-colors" title="{{ $barang->nama_barang }}">
                                {{ $barang->nama_barang }}
                            </h3>
                            
                            <div class="mt-auto border-t border-gray-100 pt-3 flex flex-col gap-2">
                                @if($barang->stok > 0)
                                    <span class="text-xs text-green-700 font-semibold bg-green-50 border border-green-200 w-fit px-2 py-1 rounded">
                                        Sisa Stok: {{ $barang->stok }}
                                    </span>
                                @else
                                    <span class="text-xs text-red-700 font-semibold bg-red-50 border border-red-200 w-fit px-2 py-1 rounded">
                                        Stok Habis
                                    </span>
                                @endif
                                
                                <p class="text-lg font-black text-red-600 mt-1">
                                    Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 flex flex-col items-center justify-center text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                        <x-heroicon-o-archive-box-x-mark style="width: 3rem; height: 3rem; margin-bottom: 0.5rem;" />
                        <p class="font-medium text-lg">Belum ada produk di katalog.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-filament-panels::page>
