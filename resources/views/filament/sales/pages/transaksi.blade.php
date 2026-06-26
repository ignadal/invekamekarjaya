<x-filament-panels::page>
    <style>

        /* Tabs */
        .ts-tab-container {
            display: inline-flex;
            background-color: #ffffff;
            border-radius: 9999px;
            padding: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        html.dark .ts-tab-container {
            background-color: #18181b;
            border-color: #27272a;
        }
        .ts-tab-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
            outline: none;
        }
        .ts-tab-btn-active {
            background-color: #E30613;
            color: white;
            box-shadow: 0 4px 10px rgba(227, 6, 19, 0.3);
        }
        .ts-tab-btn-inactive {
            background-color: transparent;
            color: #6b7280;
        }
        .ts-tab-btn-inactive:hover {
            background-color: #f9fafb;
            color: #111827;
        }
        html.dark .ts-tab-btn-inactive:hover {
            background-color: #27272a;
            color: white;
        }
        
        /* Stats Widgets */
        .ts-stats-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        @media (min-width: 768px) {
            .ts-stats-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1.25rem; }
        }
        .ts-stat-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
            border: 1px solid rgba(229, 231, 235, 0.5);
            padding: 0.75rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            transition: transform 0.2s;
        }
        @media (min-width: 768px) {
            .ts-stat-card {
                padding: 1.5rem;
                flex-direction: row;
                align-items: center;
                gap: 1.25rem;
            }
        }
        .ts-stats-grid > div:nth-child(1) { border-top: 2px solid rgba(225, 29, 72, 0.5); }
        .ts-stats-grid > div:nth-child(2) { border-top: 2px solid rgba(16, 185, 129, 0.5); }
        .ts-stats-grid > div:nth-child(3) { border-top: 2px solid rgba(37, 99, 235, 0.5); }
        .ts-stats-grid > div:nth-child(4) { border-top: 2px solid rgba(217, 119, 6, 0.5); }
        
        .ts-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        }
        html.dark .ts-stat-card {
            background-color: #18181b;
            border-color: #27272a;
        }
        html.dark .ts-stats-grid > div:nth-child(1) { border-top: 1px solid rgba(225, 29, 72, 0.4); }
        html.dark .ts-stats-grid > div:nth-child(2) { border-top: 1px solid rgba(16, 185, 129, 0.4); }
        html.dark .ts-stats-grid > div:nth-child(3) { border-top: 1px solid rgba(37, 99, 235, 0.4); }
        html.dark .ts-stats-grid > div:nth-child(4) { border-top: 1px solid rgba(217, 119, 6, 0.4); }
        .ts-stat-icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .ts-stat-icon { width: 1.25rem; height: 1.25rem; }
        
        @media (min-width: 768px) {
            .ts-stat-icon-wrapper { width: 3.5rem; height: 3.5rem; }
            .ts-stat-icon { width: 1.75rem; height: 1.75rem; }
        }
        
        .ts-icon-red { background-color: #fff1f2; color: #e11d48; }
        .ts-icon-green { background-color: #f0fdf4; color: #16a34a; }
        .ts-icon-blue { background-color: #eff6ff; color: #2563eb; }
        .ts-icon-yellow { background-color: #fffbeb; color: #d97706; }

        html.dark .ts-icon-red { background-color: rgba(225, 29, 72, 0.1); border: 1px solid rgba(225, 29, 72, 0.2); }
        html.dark .ts-icon-green { background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); }
        html.dark .ts-icon-blue { background-color: rgba(37, 99, 235, 0.1); border: 1px solid rgba(37, 99, 235, 0.2); }
        html.dark .ts-icon-yellow { background-color: rgba(217, 119, 6, 0.1); border: 1px solid rgba(217, 119, 6, 0.2); }
        
        .ts-stat-title { font-size: 0.7rem; font-weight: 600; color: #6b7280; margin-bottom: 0.125rem; }
        @media (min-width: 768px) { .ts-stat-title { font-size: 0.75rem; margin-bottom: 0.25rem; } }
        html.dark .ts-stat-title { color: #a1a1aa; }
        
        .ts-stat-value { font-size: 1.125rem; font-weight: 800; color: #111827; margin-bottom: 0.25rem; white-space: nowrap; letter-spacing: -0.025em; }
        @media (min-width: 768px) { .ts-stat-value { font-size: 1.5rem; margin-bottom: 0.5rem; letter-spacing: normal; } }
        html.dark .ts-stat-value { color: white; }
        
        .ts-stat-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 0.25rem; font-size: 0.65rem; color: #9ca3af; }
        @media (min-width: 768px) { .ts-stat-meta { font-size: 0.75rem; gap: 0.5rem; } }
        
        .ts-stat-badge { display: inline-flex; align-items: center; padding: 0.125rem 0.375rem; border-radius: 9999px; font-weight: 700; font-size: 0.65rem;}
        @media (min-width: 768px) { .ts-stat-badge { font-size: 0.7rem; } }
        .ts-badge-success { background-color: #dcfce7; color: #16a34a; }
        .ts-badge-danger { background-color: #fee2e2; color: #dc2626; }
        
        html.dark .ts-badge-success { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
        html.dark .ts-badge-danger { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; }
        
        /* Dynamic Text Colors */
        .ts-text-strong { color: #111827; }
        html.dark .ts-text-strong { color: #f3f4f6; }
        
        .ts-text-muted-strong { color: #374151; }
        html.dark .ts-text-muted-strong { color: #9ca3af; }
        
        /* Top Filter Bar */
        .ts-top-filter-bar { display: flex; flex-direction: column; gap: 1rem; background-color: white; border-radius: 1rem; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; border: 1px solid rgba(229, 231, 235, 0.5); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03); }
        @media (min-width: 1024px) { .ts-top-filter-bar { flex-direction: row; align-items: flex-end; justify-content: space-between; } }
        html.dark .ts-top-filter-bar { background-color: #18181b; border-color: #27272a; }
        
        .ts-filter-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; flex: 1; }
        @media (min-width: 1024px) { .ts-filter-grid { grid-template-columns: repeat(4, 1fr); gap: 1rem; } }
        
        .ts-filter-item { display: flex; flex-direction: column; }
        .ts-filter-label { display: flex; align-items: center; gap: 0.375rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; }
        html.dark .ts-filter-label { color: #a1a1aa; }
        .ts-filter-icon { width: 1rem; height: 1rem; color: #9ca3af; }
        
        .ts-filter-input { width: 100%; border-radius: 0.5rem; border: 1px solid #e5e7eb; padding: 0.625rem 0.75rem; font-size: 0.875rem; font-weight: 600; background-color: white; color: #111827; outline: none; transition: border-color 0.2s;}
        html.dark .ts-filter-input { background-color: #09090b; border-color: #27272a; color: white; }
        .ts-filter-input:focus { border-color: #E30613; box-shadow: 0 0 0 1px #E30613; }
        
        .ts-filter-actions { display: flex; align-items: center; gap: 1.25rem; margin-top: 1rem; }
        @media (min-width: 1024px) { .ts-filter-actions { margin-top: 0; } }
        
        .ts-filter-reset { color: #E30613; font-size: 0.875rem; font-weight: 600; background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.375rem; transition: color 0.2s;}
        .ts-filter-reset:hover { color: #b91c1c; }
        
        .ts-filter-submit { background-color: #E30613; color: white; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; border: none; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem; white-space: nowrap; }
        .ts-filter-submit:hover { background-color: #c80511; box-shadow: 0 4px 12px rgba(227, 6, 19, 0.2); }
        
        /* Main Content Box */
        .ts-main-content { flex: 1; min-width: 0; background-color: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03); border: 1px solid rgba(229, 231, 235, 0.5); display: flex; flex-direction: column; overflow: hidden; }
        html.dark .ts-main-content { background-color: #18181b; border-color: #27272a; }
        
        .ts-table-header { padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f3f4f6; }
        html.dark .ts-table-header { border-color: #27272a; }
        
        .ts-search-container { position: relative; width: 280px; display: flex; align-items: center; }
        @media (min-width: 640px) { .ts-search-container { width: 320px; } }
        .ts-search-icon { position: absolute; left: 0.875rem; width: 1.25rem; height: 1.25rem; color: #9ca3af; pointer-events: none; }
        .ts-search-input { width: 100%; border-radius: 9999px; border: 1px solid #e5e7eb; background-color: #f9fafb; padding: 0.625rem 1rem 0.625rem 2.75rem; font-size: 0.875rem; color: #111827; outline: none; transition: all 0.2s ease-in-out; }
        .ts-search-input:focus { background-color: white; border-color: #E30613; box-shadow: 0 0 0 3px rgba(227, 6, 19, 0.1); }
        html.dark .ts-search-input { background-color: #09090b; border-color: #27272a; color: white; }
        html.dark .ts-search-input:focus { background-color: #09090b; border-color: #E30613; }
        
        /* Custom Table */
        .ts-table-container { width: 100%; overflow-x: auto; padding: 1rem; }
        .ts-table { width: 100%; border-collapse: separate; border-spacing: 0 0.5rem; }
        .ts-table th { padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-align: left; background-color: #fff5f6; }
        .ts-table th:first-child { border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem; }
        .ts-table th:last-child { border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; }
        html.dark .ts-table th { background-color: #18181b; color: #9ca3af; border-bottom: 1px solid #27272a; }
        
        .ts-table td { padding: 1rem; background-color: white; border-top: 1px solid #f3f4f6; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        html.dark .ts-table td { background-color: transparent; border-top-color: #18181b; border-bottom-color: #27272a; }
        
        .ts-table td:first-child { border-left: 1px solid #f3f4f6; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem; position: relative; }
        html.dark .ts-table td:first-child { border-left-color: transparent; }
        .ts-table td:last-child { border-right: 1px solid #f3f4f6; border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; }
        html.dark .ts-table td:last-child { border-right-color: transparent; }
        
        /* Row Status Left Borders */
        .row-status-border { position: absolute; left: 0; top: 0.25rem; bottom: 0.25rem; width: 4px; border-radius: 0 4px 4px 0; }
        .border-disetujui { background-color: #10b981; } /* Green */
        .border-pending { background-color: #f59e0b; } /* Yellow/Orange */
        
        /* Calendar Block */
        .ts-cal-block { width: 3rem; height: 3rem; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; line-height: 1.1; flex-shrink: 0;}
        html.dark .ts-cal-block { background-color: #09090b; border-color: #27272a; }
        .ts-cal-day { font-size: 1.125rem; font-weight: 800; color: #111827; }
        html.dark .ts-cal-day { color: white; }
        .ts-cal-month { font-size: 0.65rem; font-weight: 700; color: #6b7280; text-transform: uppercase; }
        
        /* Text Dots */
        .ts-dot-text { display: inline-flex; align-items: center; gap: 0.375rem; font-weight: 600; font-size: 0.875rem; padding: 0.25rem 0.5rem; border-radius: 0.5rem;}
        .ts-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; }
        
        .text-lunas { color: #10b981; background-color: #ecfdf5;}
        .dot-lunas { background-color: #10b981; }
        html.dark .text-lunas { background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; }
        
        .text-cicil { color: #f59e0b; background-color: #fffbeb;}
        .dot-cicil { background-color: #f59e0b; }
        html.dark .text-cicil { background-color: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); color: #f59e0b; }
        
        .text-pending { color: #f97316; background-color: #fff7ed;}
        .dot-pending { background-color: #f97316; }
        html.dark .text-pending { background-color: rgba(249, 115, 22, 0.1); border: 1px solid rgba(249, 115, 22, 0.2); color: #f97316; }
        
        .text-disetujui { color: #10b981; background-color: #ecfdf5;}
        .dot-disetujui { background-color: #10b981; }
        html.dark .text-disetujui { background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; }
        
        .text-ditolak { color: #ef4444; background-color: #fef2f2;}
        .dot-ditolak { background-color: #ef4444; }
        html.dark .text-ditolak { background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; }

        .ts-action-btn { padding: 0.5rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; background: white; color: #6b7280; cursor: pointer; transition: all 0.2s;}
        .ts-action-btn:hover { background: #f3f4f6; color: #111827;}
        html.dark .ts-action-btn { background: #09090b; border-color: #27272a; color: #a1a1aa; }
        html.dark .ts-action-btn:hover { background: #27272a; color: white; }

        /* Pagination Footer */
        .ts-pagination-footer { display: flex; flex-direction: column; gap: 1rem; align-items: center; justify-content: space-between; border-top: 1px solid #f3f4f6; padding-top: 1.25rem; margin-top: 0.5rem; }
        @media (min-width: 640px) { .ts-pagination-footer { flex-direction: row; } }
        html.dark .ts-pagination-footer { border-color: #27272a; }
        
        .ts-paginator-info { font-size: 0.875rem; font-weight: 600; color: #6b7280; }
        html.dark .ts-paginator-info { color: #a1a1aa; }
        
        .ts-paginator-controls { display: flex; align-items: center; gap: 0.5rem; }
        .ts-page-btn { display: flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s; border: 1px solid transparent; background: transparent; }
        .ts-page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .ts-page-nav { border-color: #e5e7eb; background: white; color: #374151; }
        .ts-page-nav:not(:disabled):hover { background: #f9fafb; border-color: #d1d5db; }
        html.dark .ts-page-nav { border-color: #27272a; background: #09090b; color: #a1a1aa; }
        html.dark .ts-page-nav:not(:disabled):hover { background: #27272a; color: white; }
        
        .ts-page-active { background: #E30613; color: white; border-color: #E30613; }
        
        .ts-per-page-wrapper { position: relative; margin-left: 0.5rem; }
        .ts-per-page-select { appearance: none; background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.375rem 2rem 0.375rem 1rem; font-size: 0.875rem; font-weight: 600; color: #374151; outline: none; cursor: pointer; }
        html.dark .ts-per-page-select { background: #09090b; border-color: #27272a; color: #a1a1aa; }
        .ts-per-page-icon { position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); width: 1rem; height: 1rem; color: #9ca3af; pointer-events: none; }

        /* Mobile Layout Utilities */
        .ts-mobile-list-container { display: flex; flex-direction: column; gap: 0.75rem; padding: 0.75rem; }
        .ts-mobile-card {
            position: relative;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 95px;
            padding: 0.75rem;
            align-items: center;
            gap: 0.5rem;
        }
        html.dark .ts-mobile-card { background: #18181b; border-color: #27272a; }
        
        .ts-mobile-card .row-status-border { top: 1rem; bottom: 1rem; left: 0; }
        
        .ts-mobile-card-group-left { display: flex; align-items: center; gap: 0.75rem; width: 100%; min-width: 0; margin-left: 0.25rem; }
        .ts-mobile-card .ts-cal-block { flex-shrink: 0; width: 3rem; height: 3rem; }
        
        .ts-mobile-card-col-left { display: flex; flex-direction: column; gap: 0.25rem; width: calc(100% - 3.75rem); min-width: 0; }
        
        .ts-mobile-card-col-right { display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem; min-width: 0; max-width: 95px; }
        .ts-mobile-card-col-right .ts-text-strong { text-align: right; line-height: 1.2; word-break: break-word; }
        
        @media (max-width: 1023px) {
            .ts-desktop-table { display: none !important; }
            .ts-table-header { flex-wrap: wrap; gap: 1rem; }
            .ts-header-right-actions { flex: 1; display: flex; gap: 0.5rem; min-width: 240px; justify-content: flex-end; }
            .ts-search-container { flex: 1; }
            .ts-filter-actions { justify-content: flex-end; }
        }
        @media (min-width: 1024px) {
            .ts-mobile-list-container { display: none !important; }
            .ts-desktop-table { display: table !important; width: 100%; border-collapse: separate; border-spacing: 0 0.5rem; }
            .ts-filter-mobile-title { display: none !important; }
            .ts-action-btn-mobile { display: none !important; }
        }

        /* Custom Modal Form Component Overrides */
        
        /* Tambah Barang Button */
        button[wire\:click*="addRepeaterItem"] {
            border: 1px solid #fca5a5 !important;
            background-color: transparent !important;
            color: #dc2626 !important;
            border-radius: 0.5rem !important;
            padding: 0.375rem 1rem !important;
        }
        button[wire\:click*="addRepeaterItem"]:hover {
            background-color: #fef2f2 !important;
        }

        /* Hapus Semua Button (Repeater Delete) */
        button[wire\:click*="deleteRepeaterItem"] {
            border: 1px solid #fca5a5 !important;
            background-color: transparent !important;
            color: #dc2626 !important;
            border-radius: 0.5rem !important;
            padding: 0.25rem 0.75rem !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.375rem !important;
            width: auto !important;
        }
        button[wire\:click*="deleteRepeaterItem"] .sr-only {
            display: none !important;
        }
        button[wire\:click*="deleteRepeaterItem"]::after {
            content: "Hapus Semua" !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
        }
        button[wire\:click*="deleteRepeaterItem"]:hover {
            background-color: #fef2f2 !important;
        }
        
        /* File Upload Box (Foto Nota) */
        .fi-fo-file-upload-dropzone {
            border: 1px dashed #fca5a5 !important;
            background-color: #fff !important;
            border-radius: 0.5rem !important;
            padding: 2rem !important;
        }
        .fi-fo-file-upload-dropzone-icon {
            color: #dc2626 !important;
            width: 2rem !important;
            height: 2rem !important;
        }
        /* Style the hint/label in the dropzone */
        .fi-fo-file-upload-dropzone .text-sm,
        .fi-fo-file-upload-dropzone .font-medium {
            color: #4b5563 !important;
            font-size: 0.875rem !important;
        }
        .fi-fo-file-upload-dropzone .text-primary-600 {
            color: #dc2626 !important;
            font-weight: 600 !important;
        }
    </style>

    <div style="margin-bottom: 2rem;">
        <div class="ts-tab-container">
            <!-- Penjualan Tab -->
            <button 
                wire:click="setTab('penjualan')"
                class="ts-tab-btn {{ $activeTab === 'penjualan' ? 'ts-tab-btn-active' : 'ts-tab-btn-inactive' }}"
            >
                <x-heroicon-o-shopping-cart class="ts-icon" />
                Penjualan
            </button>

            <!-- Penagihan Tab -->
            <button 
                wire:click="setTab('penagihan')"
                class="ts-tab-btn {{ $activeTab === 'penagihan' ? 'ts-tab-btn-active' : 'ts-tab-btn-inactive' }}"
            >
                <x-heroicon-o-document-text class="ts-icon" />
                Penagihan Berkala
            </button>
        </div>
    </div>

    <div>
        @if ($activeTab === 'penjualan')
            <!-- TOP FILTER BAR -->
            <div class="ts-top-filter-bar">
                <div class="ts-filter-mobile-title" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding-bottom: 0.5rem;">
                    <div style="font-weight: 700; font-size: 0.875rem;" class="ts-text-strong">Filter</div>
                    <x-heroicon-o-funnel style="width: 1.25rem; height: 1.25rem; color: #E30613;" />
                </div>
                <div class="ts-filter-grid">
                    <div class="ts-filter-item">
                        <label class="ts-filter-label"><x-heroicon-o-calendar class="ts-filter-icon" /> Tanggal</label>
                        <input type="date" wire:model="filterTanggal" class="ts-filter-input" />
                    </div>

                    <div class="ts-filter-item">
                        <label class="ts-filter-label"><x-heroicon-o-building-storefront class="ts-filter-icon" /> Toko</label>
                        <select wire:model="filterToko" class="ts-filter-input">
                            <option value="">Semua Toko</option>
                            @foreach($tokos ?? [] as $toko)
                                <option value="{{ $toko->id }}">{{ $toko->nama_toko }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="ts-filter-item">
                        <label class="ts-filter-label"><x-heroicon-o-credit-card class="ts-filter-icon" /> Metode</label>
                        <select wire:model="filterMetode" class="ts-filter-input">
                            <option value="">Semua Metode</option>
                            <option value="lunas">Lunas</option>
                            <option value="cicil">Cicil</option>
                        </select>
                    </div>

                    <div class="ts-filter-item">
                        <label class="ts-filter-label"><x-heroicon-o-clipboard-document-check class="ts-filter-icon" /> Status</label>
                        <select wire:model="filterStatus" class="ts-filter-input">
                            <option value="">Semua Status</option>
                            <option value="pending">Diproses</option>
                            <option value="disetujui">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>

                <div class="ts-filter-actions">
                    <button type="button" wire:click="resetFilters" class="ts-filter-reset">
                        Reset <x-heroicon-o-arrow-path style="width:1rem;height:1rem;" />
                    </button>
                    <button type="button" wire:click="applyFilters" class="ts-filter-submit">
                        <x-heroicon-o-funnel style="width:1.25rem;height:1.25rem;" /> Terapkan Filter
                    </button>
                </div>
            </div>

            <!-- STATS WIDGETS -->
            <div class="ts-stats-grid">
                <!-- Total Penjualan -->
                <div class="ts-stat-card">
                    <div class="ts-stat-icon-wrapper ts-icon-red">
                        <x-heroicon-o-shopping-bag class="ts-stat-icon" />
                    </div>
                    <div class="ts-stat-info">
                        <div class="ts-stat-title">Total Penjualan</div>
                        <div class="ts-stat-value">{{ $stats['total_order'] ?? 0 }}</div>
                        <div class="ts-stat-meta">
                            <span class="ts-stat-desc">Order</span>
                            <span class="ts-stat-badge {{ ($stats['order_growth'] ?? 0) >= 0 ? 'ts-badge-success' : 'ts-badge-danger' }}">
                                @if(($stats['order_growth'] ?? 0) >= 0) &uarr; @else &darr; @endif
                                {{ abs($stats['order_growth'] ?? 0) }}%
                            </span>
                        </div>
                        <div class="ts-stat-meta" style="margin-top: 0.125rem;">
                            <span class="ts-stat-desc">dari bulan lalu</span>
                        </div>
                    </div>
                </div>

                <!-- Total Pendapatan -->
                <div class="ts-stat-card">
                    <div class="ts-stat-icon-wrapper ts-icon-green">
                        <x-heroicon-o-wallet class="ts-stat-icon" />
                    </div>
                    <div class="ts-stat-info">
                        <div class="ts-stat-title">Total Pendapatan</div>
                        <div class="ts-stat-value">Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}</div>
                        <div class="ts-stat-meta">
                            <span class="ts-stat-desc">dari {{ $stats['total_order'] ?? 0 }} order</span>
                            <span class="ts-stat-badge {{ ($stats['pendapatan_growth'] ?? 0) >= 0 ? 'ts-badge-success' : 'ts-badge-danger' }}">
                                @if(($stats['pendapatan_growth'] ?? 0) >= 0) &uarr; @else &darr; @endif
                                {{ abs($stats['pendapatan_growth'] ?? 0) }}%
                            </span>
                        </div>
                        <div class="ts-stat-meta" style="margin-top: 0.125rem;">
                            <span class="ts-stat-desc">dari bulan lalu</span>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Order -->
                <div class="ts-stat-card">
                    <div class="ts-stat-icon-wrapper ts-icon-blue">
                        <x-heroicon-o-credit-card class="ts-stat-icon" />
                    </div>
                    <div class="ts-stat-info">
                        <div class="ts-stat-title">Rata-rata Order</div>
                        <div class="ts-stat-value">Rp {{ number_format($stats['avg_order'] ?? 0, 0, ',', '.') }}</div>
                        <div class="ts-stat-meta">
                            <span class="ts-stat-desc">per order</span>
                        </div>
                    </div>
                </div>

                <!-- Konversi Pembayaran -->
                <div class="ts-stat-card">
                    <div class="ts-stat-icon-wrapper ts-icon-yellow">
                        <x-heroicon-o-clock class="ts-stat-icon" />
                    </div>
                    <div class="ts-stat-info">
                        <div class="ts-stat-title">Konversi Pembayaran</div>
                        <div class="ts-stat-value">{{ $stats['konversi'] ?? 0 }}%</div>
                        <div class="ts-stat-meta">
                            <span class="ts-stat-desc">{{ $stats['lunas_count'] ?? 0 }} dari {{ $stats['total_order'] ?? 0 }} order</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CUSTOM TABLE SECTION -->
                <div class="ts-main-content">
                    <div class="ts-table-header">
                        <h2 class="ts-content-title" style="margin: 0; white-space: nowrap;">Daftar Penjualan</h2>
                        <div class="ts-header-right-actions">
                            <div class="ts-search-container">
                                <x-heroicon-o-magnifying-glass class="ts-search-icon" />
                                <input type="text" wire:model.live.debounce.500ms="search" class="ts-search-input" placeholder="Cari order, toko..." />
                            </div>
                            <button class="ts-action-btn ts-action-btn-mobile">
                                <x-heroicon-o-adjustments-horizontal style="width: 1.25rem; height: 1.25rem;" />
                            </button>
                        </div>
                    </div>
                    
                    <div class="ts-table-container">
                        <table class="ts-table ts-desktop-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Toko</th>
                                    <th>Metode</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($records as $record)
                                    @php
                                        $statusClass = $record->status_persetujuan === 'pending' ? 'pending' : ($record->status_persetujuan === 'disetujui' ? 'disetujui' : 'ditolak');
                                        $metodeClass = $record->metode === 'lunas' ? 'lunas' : 'cicil';
                                        
                                        // Border logic based ONLY on status_persetujuan
                                        $borderClass = $record->status_persetujuan === 'disetujui' ? 'border-disetujui' : 'border-pending';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="row-status-border {{ $borderClass }}"></div>
                                            <div style="display:flex; align-items:center; gap: 0.75rem;">
                                                <div class="ts-cal-block">
                                                    <span class="ts-cal-day">{{ \Carbon\Carbon::parse($record->tanggal_beli)->format('d') }}</span>
                                                    <span class="ts-cal-month">{{ \Carbon\Carbon::parse($record->tanggal_beli)->format('M') }}</span>
                                                </div>
                                                <div>
                                                    <div class="ts-text-strong" style="font-size:0.875rem; font-weight:700;">
                                                        {{ \Carbon\Carbon::parse($record->tanggal_beli)->format('d M Y') }}
                                                    </div>
                                                    <div style="font-size:0.75rem; color:#6b7280;">
                                                        {{ \Carbon\Carbon::parse($record->created_at)->format('H:i') }} WIB
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="ts-text-muted-strong" style="display:flex; align-items:center; gap: 0.5rem; font-weight: 600; font-size: 0.875rem;">
                                                <x-heroicon-o-building-storefront style="width:1.25rem; height:1.25rem; color:#9ca3af;" />
                                                {{ $record->buyer->nama_toko ?? 'Unknown' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="ts-dot-text text-{{ $metodeClass }}">
                                                <span class="ts-dot dot-{{ $metodeClass }}"></span>
                                                {{ ucfirst($record->metode) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="ts-text-strong" style="font-weight: 600; font-size: 0.875rem;">
                                                IDR {{ number_format($record->total_penjualan, 2, '.', ',') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="ts-dot-text text-{{ $statusClass }}">
                                                <span class="ts-dot dot-{{ $statusClass }}"></span>
                                                @if ($record->status_persetujuan === 'pending')
                                                    Diproses
                                                @elseif ($record->status_persetujuan === 'disetujui')
                                                    Diterima
                                                @else
                                                    Ditolak
                                                @endif
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            <button type="button" class="ts-action-btn">
                                                <x-heroicon-o-ellipsis-horizontal style="width:1.25rem;height:1.25rem;" />
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 3rem 1rem; color: #6b7280;">
                                            <x-heroicon-o-inbox style="width:3rem; height:3rem; margin: 0 auto 1rem auto; color: #9ca3af;" />
                                            Belum ada data penjualan ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <!-- Mobile List View -->
                        <div class="ts-mobile-list-container">
                            @forelse($records as $record)
                                @php
                                    $statusClass = $record->status_persetujuan === 'pending' ? 'pending' : ($record->status_persetujuan === 'disetujui' ? 'disetujui' : 'ditolak');
                                    $metodeClass = $record->metode === 'lunas' ? 'lunas' : 'cicil';
                                    $borderClass = $record->status_persetujuan === 'disetujui' ? 'border-disetujui' : 'border-pending';
                                @endphp
                                <div class="ts-mobile-card">
                                    <div class="row-status-border {{ $borderClass }}"></div>
                                    <div class="ts-mobile-card-group-left">
                                        <div class="ts-cal-block">
                                            <span class="ts-cal-day">{{ \Carbon\Carbon::parse($record->tanggal_beli)->format('d') }}</span>
                                            <span class="ts-cal-month">{{ \Carbon\Carbon::parse($record->tanggal_beli)->format('M') }}</span>
                                        </div>
                                        <div class="ts-mobile-card-col-left">
                                            <div class="ts-text-strong" style="font-size:0.875rem; font-weight:700;">
                                                {{ \Carbon\Carbon::parse($record->tanggal_beli)->format('d M Y') }}
                                            </div>
                                            <div style="font-size:0.75rem; color:#6b7280;">
                                                {{ \Carbon\Carbon::parse($record->created_at)->format('H:i') }} WIB
                                            </div>
                                            <div style="display:flex; align-items:center; justify-content:space-between; gap: 0.5rem; margin-top: 0.25rem; width: 100%;">
                                                <div class="ts-text-muted-strong" style="display:flex; align-items:center; gap: 0.25rem; font-weight: 600; font-size: 0.875rem; flex: 1; min-width: 0;">
                                                    <x-heroicon-o-building-storefront style="width:1rem; height:1rem; color:#9ca3af; flex-shrink: 0;" />
                                                    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $record->buyer->nama_toko ?? 'Unknown' }}</span>
                                                </div>
                                                <span class="ts-dot-text text-{{ $metodeClass }}" style="padding: 0.125rem 0.375rem; font-size: 0.7rem; flex-shrink: 0;">
                                                    <span class="ts-dot dot-{{ $metodeClass }}"></span>
                                                    {{ ucfirst($record->metode) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ts-mobile-card-col-right">
                                        <span class="ts-text-strong" style="font-weight: 600; font-size: 0.875rem;">
                                            IDR {{ number_format($record->total_penjualan, 2, '.', ',') }}
                                        </span>
                                        <button class="ts-action-btn" type="button" style="padding: 0.375rem;">
                                            <x-heroicon-o-ellipsis-horizontal style="width:1.25rem; height:1.25rem;" />
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 2rem; color: #6b7280;">Tidak ada data penjualan ditemukan.</div>
                            @endforelse
                        </div>
                        
                        <div class="ts-pagination-footer">
                            <div class="ts-paginator-info">
                                Menampilkan {{ $records->firstItem() ?? 0 }}–{{ $records->lastItem() ?? 0 }} dari {{ $records->total() }} data
                            </div>
                            
                            <div class="ts-paginator-controls">
                                <button wire:click="previousPage" @if($records->onFirstPage()) disabled @endif class="ts-page-btn ts-page-nav">
                                    <x-heroicon-o-chevron-left style="width:1rem;height:1rem;"/>
                                </button>
                                
                                <button class="ts-page-btn ts-page-active">
                                    {{ $records->currentPage() }}
                                </button>
                                
                                <button wire:click="nextPage" @if(!$records->hasMorePages()) disabled @endif class="ts-page-btn ts-page-nav">
                                    <x-heroicon-o-chevron-right style="width:1rem;height:1rem;"/>
                                </button>
                                
                                <div class="ts-per-page-wrapper">
                                    <select wire:model.live="perPage" class="ts-per-page-select">
                                        <option value="10">10 / halaman</option>
                                        <option value="20">20 / halaman</option>
                                        <option value="50">50 / halaman</option>
                                    </select>
                                    <x-heroicon-o-chevron-down class="ts-per-page-icon" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        @elseif ($activeTab === 'penagihan')
            <div class="ts-sidebar" style="width: 100%;">
                <h2 class="ts-content-title">Daftar Penagihan Berkala</h2>
                <div style="text-align: center; padding: 3rem; color: #6b7280;">
                    <x-heroicon-o-inbox style="width:3rem; height:3rem; margin: 0 auto 1rem auto; color: #9ca3af;" />
                    <p style="margin: 0;">Modul penagihan berkala akan ditampilkan di sini.</p>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const updateUploadText = () => {
                const dropzoneLabels = document.querySelectorAll('.fi-fo-file-upload-dropzone .text-sm, .fi-fo-file-upload-dropzone p');
                dropzoneLabels.forEach(label => {
                    if(label.innerHTML.includes('browse')) return;
                    label.innerHTML = '<span style="color: #374151; font-weight: 500; font-size: 0.875rem;">Drag & Drop foto nota di sini</span><br><span style="color: #6b7280; font-size: 0.875rem;">atau klik untuk <span style="color: #dc2626; font-weight: 600;">browse</span></span>';
                });
            };
            
            setTimeout(updateUploadText, 100);
            
            Livewire.hook('morph.updated', () => {
                setTimeout(updateUploadText, 50);
            });
        });
    </script>
</x-filament-panels::page>
