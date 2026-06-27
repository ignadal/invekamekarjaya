<x-filament-panels::page>
    <div x-data="catalogData()" class="catalog-wrapper">
        


        <div class="catalog-layout">
            <!-- Sidebar: Kategori -->
            <aside class="catalog-sidebar">
                <h2 class="sidebar-title">
                    <x-heroicon-o-tag class="title-icon" style="width: 1.5rem; height: 1.5rem; color: #dc2626;" />
                    <span>Kategori</span>
                </h2>
                
                <div class="search-category">
                    <input type="text" x-model="searchCategory" placeholder="Cari kategori..." class="search-input">
                    <x-heroicon-o-magnifying-glass class="search-icon" style="width: 1.25rem; height: 1.25rem;" />
                </div>
                
                <ul class="category-list">
                    <li @click="activeTab = 'all'; currentPage = 1" 
                        :class="{'active': activeTab === 'all'}" 
                        class="category-item all-category">
                        <span class="category-name">Semua Kategori</span>
                        <span class="category-count" :class="activeTab === 'all' ? 'badge-red' : 'badge-gray'">{{ $stats['total_produk'] }}</span>
                    </li>
                    
                    @foreach($categories as $category)
                        <li x-show="matchesCategorySearch('{{ addslashes($category->nama_kategori) }}')"
                            @click="activeTab = '{{ $category->id }}'; currentPage = 1" 
                            :class="{'active': activeTab === '{{ $category->id }}'}" 
                            class="category-item">
                            <span class="category-name">{{ $category->nama_kategori }}</span>
                            <span class="category-count" :class="activeTab === '{{ $category->id }}' ? 'badge-red' : 'badge-gray'">{{ $category->barangs_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <!-- Main Content -->
            <div class="catalog-main">
                


                <!-- Products Section -->
                <div class="products-section">
                    <div class="products-header">
                        <h2 class="section-title">
                            <x-heroicon-o-cube class="title-icon" style="width: 1.5rem; height: 1.5rem; color: #dc2626;" />
                            <span>Daftar Produk</span>
                        </h2>
                        
                        <div class="products-controls">
                            <div class="search-product">
                                <input type="text" x-model="searchProduct" placeholder="Cari produk..." class="search-input">
                                <x-heroicon-o-magnifying-glass class="search-icon" style="width: 1.25rem; height: 1.25rem;" />
                            </div>
                            
                            <div class="sort-dropdown">
                                <select x-model="sortBy" class="sort-select">
                                    <option value="newest">Urutkan: Terbaru</option>
                                    <option value="price_asc">Harga: Terendah</option>
                                    <option value="price_desc">Harga: Tertinggi</option>
                                </select>
                            </div>
                            
                            <div class="view-toggles">
                                <button @click="viewMode = 'grid'" :class="{'active': viewMode === 'grid'}" class="view-btn">
                                    <x-heroicon-o-squares-2x2 class="view-icon" style="width: 1.25rem; height: 1.25rem;" />
                                </button>
                                <button @click="viewMode = 'list'" :class="{'active': viewMode === 'list'}" class="view-btn">
                                    <x-heroicon-o-list-bullet class="view-icon" style="width: 1.25rem; height: 1.25rem;" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div :class="viewMode === 'grid' ? 'product-grid' : 'product-list'">
                        <template x-for="product in paginatedProducts" :key="product.id">
                            <div class="product-card">
                                <div class="product-image-wrapper">
                                    <template x-if="product.foto">
                                        <img :src="'/storage/' + product.foto" :alt="product.nama_barang" class="product-image" />
                                    </template>
                                    <template x-if="!product.foto">
                                        <div class="image-fallback">
                                            <x-heroicon-o-photo class="fallback-icon" style="width: 3rem; height: 3rem;" />
                                        </div>
                                    </template>
                                    
                                    <span class="category-badge" x-text="product.kategori_nama"></span>
                                </div>
                                
                                <div class="product-details">
                                    <h3 class="product-name" x-text="product.nama_barang" :title="product.nama_barang"></h3>
                                    
                                    <div class="product-stock-row">
                                        <span class="stock-badge in-stock" x-show="product.stok > 0" x-text="'Sisa Stok: ' + product.stok"></span>
                                        <span class="stock-badge out-of-stock" x-show="product.stok <= 0">Stok Habis</span>
                                    </div>
                                    
                                    <div class="product-footer">
                                        <p class="product-price" x-text="formatRupiah(product.harga_jual)"></p>
                                        <button class="more-btn" title="Opsi lainnya">
                                            <x-heroicon-o-ellipsis-horizontal class="more-icon" style="width: 1.25rem; height: 1.25rem;" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <div class="empty-state" x-show="paginatedProducts.length === 0" style="display: none;">
                            <x-heroicon-o-archive-box-x-mark class="empty-icon" style="width: 3rem; height: 3rem;" />
                            <p>Tidak ada produk ditemukan.</p>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pagination-container" x-show="filteredProducts.length > 0" style="display: none;">
                        <span class="pagination-info" x-text="`Menampilkan ${filteredProducts.length > 0 ? startIndex + 1 : 0}-${Math.min(endIndex, filteredProducts.length)} dari ${filteredProducts.length} produk`"></span>
                        
                        <div class="pagination-controls">
                            <button @click="prevPage()" :disabled="currentPage === 1" class="page-btn">
                                <x-heroicon-o-chevron-left class="page-icon" style="width: 1rem; height: 1rem;" />
                            </button>
                            
                            <template x-for="page in pagesArray" :key="page">
                                <button @click="page !== '...' ? currentPage = page : null" 
                                        :class="{'active': currentPage === page, 'dots': page === '...'}" 
                                        class="page-num-btn" x-text="page"
                                        :disabled="page === '...'"></button>
                            </template>
                            
                            <button @click="nextPage()" :disabled="currentPage === totalPages" class="page-btn">
                                <x-heroicon-o-chevron-right class="page-icon" style="width: 1rem; height: 1rem;" />
                            </button>
                        </div>
                        
                        <div class="per-page-dropdown">
                            <select x-model="perPage" @change="currentPage = 1" class="per-page-select">
                                <option value="10">10 / halaman</option>
                                <option value="20">20 / halaman</option>
                                <option value="50">50 / halaman</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('catalogData', () => ({
                activeTab: 'all',
                searchCategory: '',
                searchProduct: '',
                sortBy: 'newest',
                viewMode: 'grid',
                currentPage: 1,
                perPage: 10,
                products: @json($barangsData),
                
                get filteredProducts() {
                    let filtered = this.products;
                    
                    if (this.activeTab !== 'all') {
                        filtered = filtered.filter(p => p.kategori_barang_id == this.activeTab);
                    }
                    
                    if (this.searchProduct.trim() !== '') {
                        const search = this.searchProduct.toLowerCase();
                        filtered = filtered.filter(p => p.nama_barang.toLowerCase().includes(search));
                    }
                    
                    filtered = filtered.sort((a, b) => {
                        if (this.sortBy === 'price_asc') return a.harga_jual - b.harga_jual;
                        if (this.sortBy === 'price_desc') return b.harga_jual - a.harga_jual;
                        return new Date(b.created_at) - new Date(a.created_at);
                    });
                    
                    return filtered;
                },
                
                get totalPages() {
                    return Math.ceil(this.filteredProducts.length / this.perPage) || 1;
                },
                
                get pagesArray() {
                    let pages = [];
                    let total = this.totalPages;
                    let current = this.currentPage;
                    
                    if (total <= 5) {
                        for (let i = 1; i <= total; i++) pages.push(i);
                    } else {
                        if (current <= 3) {
                            pages = [1, 2, 3, 4, '...', total];
                        } else if (current >= total - 2) {
                            pages = [1, '...', total - 3, total - 2, total - 1, total];
                        } else {
                            pages = [1, '...', current - 1, current, current + 1, '...', total];
                        }
                    }
                    return pages;
                },
                
                get startIndex() {
                    return (this.currentPage - 1) * this.perPage;
                },
                
                get endIndex() {
                    return this.currentPage * this.perPage;
                },
                
                get paginatedProducts() {
                    if (this.currentPage > this.totalPages && this.totalPages > 0) {
                        this.currentPage = 1;
                    }
                    return this.filteredProducts.slice(this.startIndex, this.endIndex);
                },
                
                matchesCategorySearch(name) {
                    if (this.searchCategory.trim() === '') return true;
                    return name.toLowerCase().includes(this.searchCategory.toLowerCase());
                },
                
                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },
                
                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },
                
                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                }
            }))
        });
    </script>
    
    <style>
        .catalog-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            padding-bottom: 3rem;
        }

        .page-header {
            margin-bottom: 0.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111827;
            margin: 0;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
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
            padding: 1.25rem;
            width: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
        }

        @media (min-width: 1024px) {
            .catalog-sidebar {
                flex: 0 0 16rem; /* 256px */
                position: sticky;
                top: 5rem;
            }
        }

        .sidebar-title {
            font-size: 1.125rem;
            font-weight: 800;
            color: #111827;
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-category {
            position: relative;
            margin-bottom: 1.5rem;
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
        }

        .search-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .category-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .category-item:hover {
            background-color: #f9fafb;
        }

        .category-item.active {
            background-color: #fef2f2;
        }

        .category-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4b5563;
        }

        .category-item.active .category-name {
            color: #dc2626;
            font-weight: 700;
        }

        .category-count {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            min-width: 1.5rem;
            text-align: center;
        }

        .badge-red {
            background-color: #dc2626;
            color: #ffffff;
        }

        .badge-gray {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        /* Main Content */
        .catalog-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            min-width: 0; /* Prevent flex overflow */
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }

        @media (min-width: 1280px) {
            .stats-row { grid-template-columns: repeat(4, 1fr); }
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 1rem;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
        }

        .stat-icon-wrapper {
            width: 3rem;
            height: 3rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .bg-red-light { background-color: #fef2f2; }
        .text-red { color: #dc2626; }
        
        .bg-green-light { background-color: #f0fdf4; }
        .text-green { color: #16a34a; }
        
        .bg-yellow-light { background-color: #fefce8; }
        .text-yellow { color: #d97706; }
        
        .bg-blue-light { background-color: #eff6ff; }
        .text-blue { color: #2563eb; }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.125rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111827;
            line-height: 1.2;
        }

        .stat-desc {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.125rem;
        }

        /* Products Section */
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
        }

        @media (min-width: 768px) {
            .products-header {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 800;
            color: #111827;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .products-controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .search-product {
            position: relative;
            flex-grow: 1;
        }

        .sort-select {
            padding: 0.5rem 2rem 0.5rem 1rem;
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

        .view-toggles {
            display: flex;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 0.25rem;
            border-radius: 0.5rem;
            gap: 0.25rem;
        }

        .view-btn {
            padding: 0.375rem;
            border-radius: 0.375rem;
            border: none;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .view-btn.active {
            background-color: #fef2f2;
            color: #dc2626;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.25rem;
        }

        @media (min-width: 640px) {
            .product-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (min-width: 860px) {
            .product-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (min-width: 1280px) {
            .product-grid { grid-template-columns: repeat(4, 1fr); }
        }

        /* Product List */
        .product-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .product-list .product-card {
            flex-direction: row;
            height: 8rem;
        }
        
        .product-list .product-image-wrapper {
            width: 8rem;
            height: 100%;
            border-bottom: none;
            border-right: 1px solid #f3f4f6;
        }
        
        .product-list .product-details {
            flex-direction: row;
            align-items: center;
            padding: 1rem 1.5rem;
        }
        
        .product-list .product-name {
            width: 30%;
            margin: 0;
            -webkit-line-clamp: 1;
        }
        
        .product-list .product-stock-row {
            margin: 0;
            width: 20%;
        }
        
        .product-list .product-footer {
            margin-top: 0;
            border-top: none;
            padding-top: 0;
            width: 40%;
            justify-content: flex-end;
            gap: 1.5rem;
        }
        
        @media (max-width: 640px) {
            .product-list .product-card { flex-direction: column; height: auto; }
            .product-list .product-image-wrapper { width: 100%; height: 12rem; border-right: none; border-bottom: 1px solid #f3f4f6; }
            .product-list .product-details { flex-direction: column; align-items: flex-start; }
            .product-list .product-name { width: 100%; margin-bottom: 0.5rem; -webkit-line-clamp: 2; }
            .product-list .product-stock-row { width: 100%; margin-bottom: 1rem; }
            .product-list .product-footer { width: 100%; border-top: 1px solid #f3f4f6; padding-top: 1rem; justify-content: space-between; }
        }

        .product-card {
            background-color: #ffffff;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .product-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .product-image-wrapper {
            width: 100%;
            height: 12rem;
            background-color: #ffffff;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #f3f4f6;
            padding: 1.5rem;
        }

        .product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .category-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background-color: #dc2626;
            color: #ffffff;
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .product-details {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 0.5rem 0;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-stock-row {
            margin-bottom: 1.25rem;
        }

        .stock-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            display: inline-block;
        }

        .stock-badge.in-stock {
            color: #16a34a;
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .stock-badge.out-of-stock {
            color: #dc2626;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
        }

        .product-footer {
            margin-top: auto;
            border-top: 1px dashed #e5e7eb;
            padding-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .product-price {
            font-size: 1.125rem;
            font-weight: 800;
            color: #dc2626;
            margin: 0;
        }

        .more-btn {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 9999px;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s;
        }

        .more-btn:hover {
            background-color: #f9fafb;
            color: #111827;
            border-color: #d1d5db;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            margin-top: 1rem;
            gap: 1rem;
            padding-top: 1rem;
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
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            padding: 0 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .page-btn:hover:not(:disabled), .page-num-btn:hover:not(.active):not(.dots) {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        .page-num-btn.active {
            background-color: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }

        .page-num-btn.dots {
            border: none;
            background: transparent;
            cursor: default;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .per-page-select {
            padding: 0.375rem 2rem 0.375rem 0.75rem;
            border-radius: 0.375rem;
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
            background-size: 1.25em 1.25em;
        }
        
        .empty-state {
            padding: 4rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border-radius: 1rem;
            border: 1px dashed #d1d5db;
            color: #6b7280;
        }
        
        .empty-state p {
            margin-top: 1rem;
            font-weight: 500;
            font-size: 1.125rem;
        }
        
        [x-cloak] { display: none !important; }
    </style>
</x-filament-panels::page>
