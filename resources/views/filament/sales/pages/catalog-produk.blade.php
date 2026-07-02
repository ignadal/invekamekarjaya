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
                        <div class="products-title-area">
                            <h2 class="section-title">
                                <x-heroicon-o-shopping-bag class="title-icon" style="width: 1.5rem; height: 1.5rem; color: #b91c1c;" />
                                <span>Daftar Produk</span>
                            </h2>
                            <p class="section-subtitle" x-text="filteredProducts.length + ' produk ditemukan'"></p>
                        </div>
                        
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
                                        <span class="stock-badge in-stock" x-show="product.stok > 0">
                                            <span class="stock-dot dot-green"></span>
                                            <span x-text="'Stok: ' + product.stok"></span>
                                        </span>
                                        <span class="stock-badge out-of-stock" x-show="product.stok <= 0">
                                            <span class="stock-dot dot-red"></span>
                                            <span>Stok Habis</span>
                                        </span>
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
                        
                        <div class="empty-state-container" x-show="paginatedProducts.length === 0" style="display: none;">
                            <div class="empty-state-content">
                                <div class="empty-icon-wrapper">
                                    <x-heroicon-o-archive-box class="empty-icon" style="width: 2.5rem; height: 2.5rem; color: #b91c1c;" />
                                </div>
                                <h3 class="empty-title">Belum ada produk.</h3>
                                <p class="empty-description">Produk akan muncul setelah admin menambahkan katalog.</p>
                            </div>
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
        :root {
            --primary-color: #b91c1c;
            --primary-light: #fef2f2;
            --bg-color: #f8fafc;
            --card-color: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #475569;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -4px rgba(0, 0, 0, 0.04);
            --radius-md: 0.5rem;
            --radius-lg: 1rem;
        }

        html.dark {
            --primary-light: rgba(185, 28, 28, 0.15);
            --bg-color: #09090b;
            --card-color: #18181b;
            --text-dark: #f8fafc;
            --text-gray: #cbd5e1;
            --text-light: #94a3b8;
            --border-color: #27272a;
            --border-light: #27272a;
        }

        .catalog-wrapper {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            color: var(--text-gray);
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
            background-color: var(--card-color);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            width: 100%;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
        }

        @media (min-width: 1024px) {
            .catalog-sidebar {
                flex: 0 0 17rem; /* 272px compact sidebar */
                position: sticky;
                top: 6rem; /* sticky under navbar */
                max-height: calc(100vh - 8rem);
                overflow-y: auto;
            }
        }

        .sidebar-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .search-category {
            position: relative;
            margin-bottom: 1rem;
        }

        .search-category .search-input {
            width: 100%;
            padding: 0.5rem 2.25rem 0.5rem 0.75rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            background-color: var(--bg-color);
            font-size: 0.875rem;
            color: var(--text-dark);
            outline: none;
            transition: all 0.2s ease;
        }

        .search-category .search-input:focus {
            border-color: var(--primary-color);
            background-color: var(--card-color);
            box-shadow: 0 0 0 2px rgba(185, 28, 28, 0.1);
        }

        .search-category .search-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            pointer-events: none;
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
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.2s ease;
            border-left: 2px solid transparent;
        }

        .category-item:hover {
            background-color: var(--border-light);
        }

        .category-item.active {
            background-color: var(--primary-light);
            border-left-color: var(--primary-color);
        }

        .category-name {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-gray);
            transition: color 0.2s ease;
        }

        .category-item.active .category-name {
            color: var(--primary-color);
            font-weight: 600;
        }

        .category-count {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            min-width: 1.5rem;
            text-align: center;
            transition: all 0.2s ease;
        }

        .badge-red {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        .badge-gray {
            background-color: var(--border-light);
            color: var(--text-light);
        }

        .category-item.active .badge-gray {
            background-color: rgba(185, 28, 28, 0.1);
            color: var(--primary-color);
        }

        /* Main Content */
        .catalog-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            min-width: 0;
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
            background-color: var(--card-color);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
        }

        .stat-icon-wrapper {
            width: 3rem;
            height: 3rem;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .bg-red-light { background-color: var(--primary-light); }
        .text-red { color: var(--primary-color); }
        
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
            color: var(--text-light);
            margin-bottom: 0.125rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .stat-desc {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-top: 0.125rem;
        }

        /* Products Section */
        .products-section {
            background-color: var(--card-color);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .products-header {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            border-bottom: 1px solid var(--border-light);
            padding-bottom: 1.25rem;
        }

        @media (min-width: 768px) {
            .products-header {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .products-title-area {
            display: flex;
            flex-direction: column;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-subtitle {
            font-size: 0.875rem;
            color: var(--text-light);
            margin: 0.25rem 0 0 0;
            font-weight: 500;
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
            min-width: 220px;
        }

        .search-product .search-input {
            width: 100%;
            height: 2.5rem;
            padding: 0.5rem 2.25rem 0.5rem 0.75rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            background-color: var(--bg-color);
            font-size: 0.875rem;
            color: var(--text-dark);
            outline: none;
            transition: all 0.2s ease;
        }

        .search-product .search-input:focus {
            border-color: var(--primary-color);
            background-color: var(--card-color);
            box-shadow: 0 0 0 2px rgba(185, 28, 28, 0.1);
        }

        .search-product .search-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            pointer-events: none;
        }

        .sort-select {
            height: 2.5rem;
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            background-color: var(--card-color);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-gray);
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25rem 1.25rem;
            transition: all 0.2s ease;
        }

        .sort-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(185, 28, 28, 0.1);
        }

        .view-toggles {
            display: flex;
            background-color: var(--border-light);
            border: 1px solid var(--border-color);
            padding: 0.25rem;
            border-radius: var(--radius-md);
            gap: 0.25rem;
            height: 2.5rem;
            align-items: center;
        }

        .view-btn {
            width: 2rem;
            height: 2rem;
            border-radius: 0.375rem;
            border: none;
            background: transparent;
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .view-btn:hover {
            color: var(--text-dark);
            background-color: rgba(0, 0, 0, 0.02);
        }

        .view-btn.active {
            background-color: var(--card-color);
            color: var(--primary-color);
            box-shadow: var(--shadow-sm);
        }

        /* Product Grid Layout */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .product-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (min-width: 1200px) {
            .product-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (min-width: 1440px) {
            .product-grid { grid-template-columns: repeat(4, 1fr); }
        }

        /* Product List Layout */
        .product-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .product-list .product-card {
            flex-direction: row;
            align-items: center;
            height: auto;
            padding: 0.75rem;
            gap: 1.25rem;
        }
        
        .product-list .product-image-wrapper {
            width: 6rem;
            height: 6rem;
            aspect-ratio: 1 / 1;
            flex-shrink: 0;
            border-radius: 0.75rem;
            border: 1px solid var(--border-light);
            padding: 0.5rem;
        }
        
        .product-list .product-details {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 0;
            width: 100%;
        }
        
        .product-list .product-name {
            width: 40%;
            margin: 0;
            height: auto;
            -webkit-line-clamp: 1;
        }
        
        .product-list .product-stock-row {
            margin: 0;
            width: 25%;
        }
        
        .product-list .product-footer {
            margin-top: 0;
            border-top: none;
            padding-top: 0;
            width: 35%;
            justify-content: flex-end;
            gap: 1.5rem;
        }
        
        @media (max-width: 640px) {
            .product-list .product-card { 
                flex-direction: column; 
                height: auto; 
                align-items: stretch;
            }
            .product-list .product-image-wrapper { 
                width: 100%; 
                aspect-ratio: 1 / 1;
                border-right: none; 
                border-bottom: 1px solid var(--border-light); 
                border-radius: var(--radius-lg) var(--radius-lg) 0 0;
                padding: 1.25rem;
            }
            .product-list .product-details { 
                flex-direction: column; 
                align-items: stretch;
                padding: 1rem;
            }
            .product-list .product-name { 
                width: 100%; 
                margin-bottom: 0.5rem; 
                -webkit-line-clamp: 2; 
                height: 2.85rem;
            }
            .product-list .product-stock-row { 
                width: 100%; 
                margin-bottom: 1rem; 
            }
            .product-list .product-footer { 
                width: 100%; 
                border-top: 1px solid var(--border-light); 
                padding-top: 1rem; 
                justify-content: space-between; 
            }
        }

        /* Product Cards */
        .product-card {
            background-color: var(--card-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        }

        .product-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
            border-color: var(--border-color);
        }

        .product-image-wrapper {
            width: 100%;
            aspect-ratio: 1 / 1;
            background-color: var(--bg-color);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border-light);
            overflow: hidden;
            padding: 1.25rem;
        }

        .product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .product-card:hover .product-image {
            transform: scale(1.04);
        }

        .image-fallback {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
        }

        .category-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background-color: rgba(185, 28, 28, 0.9);
            color: #ffffff;
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius-md);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            backdrop-filter: blur(4px);
            z-index: 2;
        }

        .product-details {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.85rem;
        }

        .product-stock-row {
            margin-bottom: 1rem;
            display: flex;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
        }

        .stock-badge.in-stock {
            color: #16a34a;
            background-color: #f0fdf4;
            border: 1px solid #dcfce7;
        }

        .stock-badge.out-of-stock {
            color: var(--primary-color);
            background-color: var(--primary-light);
            border: 1px solid #fee2e2;
        }

        .stock-dot {
            width: 0.375rem;
            height: 0.375rem;
            border-radius: 50%;
        }

        .dot-green {
            background-color: #16a34a;
        }

        .dot-red {
            background-color: var(--primary-color);
        }

        .product-footer {
            margin-top: auto;
            border-top: 1px solid var(--border-light);
            padding-top: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .product-price {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .more-btn {
            background-color: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 2.25rem;
            height: 2.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .more-btn:hover {
            background-color: var(--border-light);
            color: var(--text-dark);
            border-color: #cbd5e1;
        }

        /* Empty State */
        .empty-state-container {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5rem 2rem;
            background-color: var(--card-color);
            border-radius: var(--radius-lg);
            border: 1px dashed var(--border-color);
            min-height: 350px;
            box-shadow: var(--shadow-sm);
        }

        .empty-state-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 320px;
        }

        .empty-icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background-color: var(--primary-light);
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
        }

        .empty-description {
            font-size: 0.875rem;
            color: var(--text-light);
            margin: 0;
            line-height: 1.5;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            margin-top: 2rem;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-light);
        }

        @media (min-width: 768px) {
            .pagination-container {
                flex-direction: row;
            }
        }

        .pagination-info {
            font-size: 0.875rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .page-btn, .page-num-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.25rem;
            height: 2.25rem;
            padding: 0 0.5rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            background-color: var(--card-color);
            color: var(--text-gray);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .page-btn:hover:not(:disabled), .page-num-btn:hover:not(.active):not(.dots) {
            background-color: var(--bg-color);
            border-color: #cbd5e1;
            color: var(--text-dark);
        }

        .page-num-btn.active {
            background-color: var(--primary-color);
            color: #ffffff;
            border-color: var(--primary-color);
        }

        .page-num-btn.dots {
            border: none;
            background: transparent;
            cursor: default;
            color: var(--text-light);
        }

        .page-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .per-page-select {
            height: 2.25rem;
            padding: 0.375rem 2rem 0.375rem 0.75rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            background-color: var(--card-color);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-gray);
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.625rem center;
            background-repeat: no-repeat;
            background-size: 1.25rem 1.25rem;
            transition: all 0.2s ease;
        }

        .per-page-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(185, 28, 28, 0.1);
        }
        
        [x-cloak] { display: none !important; }
    </style>
</x-filament-panels::page>
