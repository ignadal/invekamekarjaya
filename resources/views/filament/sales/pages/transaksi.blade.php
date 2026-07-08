<x-filament-panels::page>
    <style>

        /* Tabs */
        .ts-tab-container {
            display: inline-flex;
            background-color: #ffffff;
            border-radius: 0.75rem;
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
            border-radius: 0.5rem;
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
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        @media (min-width: 640px) {
            .ts-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
            }
        }
        @media (min-width: 1024px) {
            .ts-stats-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 1.25rem;
            }
        }
        .ts-stat-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
            border: 1px solid rgba(229, 231, 235, 0.5);
            padding: 0.75rem;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0.75rem;
            transition: transform 0.2s;
        }
        @media (min-width: 768px) {
            .ts-stat-card {
                padding: 1.25rem;
                gap: 1rem;
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
        .ts-top-filter-bar { 
            position: relative;
            overflow: hidden;
            display: flex; flex-direction: column; gap: 1rem; 
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 50%, #b91c1c 100%);
            border-radius: 1rem; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; border: none; 
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); 
        }
        .ts-top-filter-bar > * { position: relative; z-index: 10; }
        .ts-top-filter-bar > .wave-bg { position: absolute !important; top: 0; left: 0; width: 100%; line-height: 0; z-index: 0 !important; pointer-events: none; transform: scaleY(-1); margin: 0; padding: 0; }
        
        @media (min-width: 1024px) { .ts-top-filter-bar { flex-direction: row; align-items: flex-end; justify-content: space-between; } }
        html.dark .ts-top-filter-bar { background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #7f1d1d 100%); border: none; }
        
        /* Animated wave CSS */
        .parallax-dashboard > use { animation: move-forever-dashboard 25s cubic-bezier(.55,.5,.45,.5) infinite; }
        @keyframes move-forever-dashboard { 0% { transform: translate3d(-90px,0,0); } 100% { transform: translate3d(85px,0,0); } }
        .parallax-dashboard > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; fill: rgba(127, 29, 29, 0.3); }
        .parallax-dashboard > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; fill: rgba(127, 29, 29, 0.5); }
        .parallax-dashboard > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; fill: rgba(127, 29, 29, 0.7); }
        .parallax-dashboard > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; fill: rgba(127, 29, 29, 0.9); }
        
        .ts-filter-grid { display: grid; grid-template-columns: repeat(1, 1fr); gap: 0.75rem; flex: 1; }
        @media (min-width: 640px) { .ts-filter-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; } }
        @media (min-width: 1024px) { .ts-filter-grid { grid-template-columns: repeat(4, 1fr); gap: 1rem; } }
        
        .ts-filter-item { display: flex; flex-direction: column; }
        .ts-filter-label { display: flex; align-items: center; gap: 0.375rem; font-size: 0.75rem; font-weight: 600; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem; }
        html.dark .ts-filter-label { color: rgba(255, 255, 255, 0.9); }
        .ts-filter-icon { width: 1rem; height: 1rem; color: rgba(255, 255, 255, 0.8); }
        
        .ts-filter-input { width: 100%; border-radius: 0.5rem; border: none; padding: 0.625rem 0.75rem; font-size: 0.875rem; font-weight: 600; background-color: white; color: #111827; outline: none; transition: box-shadow 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.1);}
        html.dark .ts-filter-input { background-color: #09090b; border: 1px solid #27272a; color: white; }
        .ts-filter-input:focus { box-shadow: 0 0 0 2px white; }
        html.dark .ts-filter-input:focus { box-shadow: 0 0 0 2px #3f3f46; }
        
        .ts-filter-actions { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-top: 1rem; width: 100%; }
        @media (min-width: 1024px) { .ts-filter-actions { width: auto; justify-content: flex-end; margin-top: 0; } }
        
        .ts-filter-reset { color: white; font-size: 0.875rem; font-weight: 600; background-color: #1f2937; padding: 0.625rem 1.25rem; border-radius: 0.5rem; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.375rem; transition: background-color 0.2s;}
        .ts-filter-reset:hover { background-color: #111827; }
        html.dark .ts-filter-reset { background-color: #27272a; border: 1px solid #3f3f46; }
        
        .ts-filter-submit { background-color: white; color: #E30613; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 700; font-size: 0.875rem; border: none; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem; white-space: nowrap; flex-grow: 1; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        @media (min-width: 1024px) { .ts-filter-submit { flex-grow: 0; } }
        .ts-filter-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        html.dark .ts-filter-submit { background-color: #27272a; color: white; border: 1px solid #3f3f46; }
        
        /* Info Alert Box */
        .ts-info-alert { background-color: #fff1f2; border: 1px solid #fecdd3; border-radius: 0.75rem; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 0.75rem; }
        html.dark .ts-info-alert { background-color: rgba(225, 29, 72, 0.1); border-color: rgba(225, 29, 72, 0.2); }
        .ts-info-icon { width: 1.5rem; height: 1.5rem; color: #e11d48; flex-shrink: 0; margin-top: 0.125rem; }
        html.dark .ts-info-icon { color: #fb7185; }
        .ts-info-title { font-weight: 700; color: #9f1239; font-size: 0.875rem; margin-bottom: 0.25rem; }
        html.dark .ts-info-title { color: #fecdd3; }
        .ts-info-desc { color: #be123c; font-size: 0.8125rem; line-height: 1.4; }
        html.dark .ts-info-desc { color: #fda4af; }
        
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
        .border-disetujui { background-color: #16a34a; } /* Green */
        .border-pending { background-color: #94a3b8; } /* Gray */
        
        /* Calendar Block */
        .ts-cal-block { width: 3rem; height: 3rem; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; line-height: 1.1; flex-shrink: 0;}
        html.dark .ts-cal-block { background-color: #09090b; border-color: #27272a; }
        .ts-cal-day { font-size: 1.125rem; font-weight: 800; color: #111827; }
        html.dark .ts-cal-day { color: white; }
        .ts-cal-month { font-size: 0.65rem; font-weight: 700; color: #6b7280; text-transform: uppercase; }
        
        /* Text Dots */
        .ts-dot-text { display: inline-flex; align-items: center; gap: 0.375rem; font-weight: 600; font-size: 0.875rem; padding: 0.25rem 0.5rem; border-radius: 0.5rem;}
        .ts-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; }
        
        .text-lunas { color: #111827; background-color: #f3f4f6;}
        .dot-lunas { background-color: #111827; }
        html.dark .text-lunas { background-color: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white; }
        
        .text-cicil { color: #d97706; background-color: #fffbeb;}
        .dot-cicil { background-color: #d97706; }
        html.dark .text-cicil { background-color: rgba(217, 119, 6, 0.2); border: 1px solid rgba(217, 119, 6, 0.3); color: #fcd34d; }
        
        .text-pending { color: #475569; background-color: #f1f5f9; }
        .dot-pending { background-color: #475569; }
        html.dark .text-pending { background-color: rgba(71, 85, 105, 0.2); border: 1px solid rgba(71, 85, 105, 0.3); color: #94a3b8; }
        
        .text-disetujui { color: #16a34a; background-color: #f0fdf4;}
        .dot-disetujui { background-color: #16a34a; }
        html.dark .text-disetujui { background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #6ee7b7; }
        
        .text-ditolak { color: #1f2937; background-color: #f3f4f6;}
        .dot-ditolak { background-color: #1f2937; }
        html.dark .text-ditolak { background-color: rgba(31, 41, 55, 0.4); border: 1px solid rgba(31, 41, 55, 0.5); color: #d1d5db; }

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
        
        .billing-progress-card { background-color: #f9fafb; border: 1px solid #f3f4f6; }
        html.dark .billing-progress-card { background-color: rgba(24, 24, 27, 0.5); border-color: #27272a; }
        
        .billing-divider { border-top: 1px dashed #d1d5db; }
        html.dark .billing-divider { border-color: #3f3f46; }
        
        .info-block { background: #fffcfc; border-color: #fef2f2; }
        html.dark .info-block { background: rgba(127, 29, 29, 0.1); border-color: rgba(127, 29, 29, 0.2); }
        
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

        /* Custom Empty State Styling */
        .ts-empty-state-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        .ts-empty-icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3.5rem;
            height: 3.5rem;
            background-color: #fee2e2;
            border-radius: 9999px;
            box-shadow: 0 4px 10px rgba(227, 6, 19, 0.03);
            transition: all 0.2s ease-in-out;
        }
        .ts-empty-icon {
            width: 1.75rem;
            height: 1.75rem;
            color: #E30613;
        }
        html.dark .ts-empty-icon-wrapper {
            background-color: rgba(227, 6, 19, 0.15);
        }
        html.dark .ts-empty-icon {
            color: #ef4444;
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
                <div class="wave-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto" style="position: relative; width: 100%; height: 60px; margin-top: -7px; min-height: 60px; max-height: 80px;">
                        <defs><path id="gentle-wave-dashboard" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
                        <g class="parallax-dashboard">
                            <use xlink:href="#gentle-wave-dashboard" x="48" y="0" />
                            <use xlink:href="#gentle-wave-dashboard" x="48" y="3" />
                            <use xlink:href="#gentle-wave-dashboard" x="48" y="5" />
                            <use xlink:href="#gentle-wave-dashboard" x="48" y="7" />
                        </g>
                    </svg>
                </div>
                <div class="ts-filter-mobile-title" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding-bottom: 0.5rem;">
                    <div style="font-weight: 700; font-size: 0.875rem; color: white;">Filter</div>
                    <x-heroicon-o-funnel style="width: 1.25rem; height: 1.25rem; color: white;" />
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
                            <option value="pending">Pending</option>
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
                                                    Pending
                                                @elseif ($record->status_persetujuan === 'disetujui')
                                                    Diterima
                                                @else
                                                    Ditolak
                                                @endif
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            {{ ($this->viewPenjualanAction)(['penjualan_id' => $record->id]) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="padding: 4rem 1rem; text-align: center;">
                                            <div class="ts-empty-state-wrapper">
                                                <div class="ts-empty-icon-wrapper">
                                                    <x-heroicon-o-inbox class="ts-empty-icon" />
                                                </div>
                                                <div style="font-weight: 600; color: #4b5563; font-size: 0.875rem;" class="ts-text-muted-strong">
                                                    Belum ada data penjualan.
                                                </div>
                                                <p style="color: #9ca3af; font-size: 0.75rem;">Lakukan penjualan pertama untuk menambahkan data.</p>
                                            </div>
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
                                        <div style="margin-top: 0.25rem;">
                                            {{ ($this->viewPenjualanAction)(['penjualan_id' => $record->id]) }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div style="padding: 3rem 1rem;" class="ts-empty-state-wrapper">
                                    <div class="ts-empty-icon-wrapper">
                                        <x-heroicon-o-inbox class="ts-empty-icon" />
                                    </div>
                                    <div style="font-weight: 600; color: #4b5563; font-size: 0.875rem;" class="ts-text-muted-strong">
                                        Tidak ada data penjualan ditemukan.
                                    </div>
                                </div>
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
            <!-- TOP FILTER BAR (PENAGIHAN) -->
            <div class="ts-top-filter-bar" style="margin-bottom: 2rem;">
                <div class="wave-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto" style="position: relative; width: 100%; height: 60px; margin-top: -7px; min-height: 60px; max-height: 80px;">
                        <defs><path id="gentle-wave-dashboard" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
                        <g class="parallax-dashboard">
                            <use xlink:href="#gentle-wave-dashboard" x="48" y="0" />
                            <use xlink:href="#gentle-wave-dashboard" x="48" y="3" />
                            <use xlink:href="#gentle-wave-dashboard" x="48" y="5" />
                            <use xlink:href="#gentle-wave-dashboard" x="48" y="7" />
                        </g>
                    </svg>
                </div>
                <div class="ts-filter-mobile-title" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding-bottom: 0.5rem;">
                    <div style="font-weight: 700; font-size: 0.875rem; color: white;">Filter</div>
                    <x-heroicon-o-funnel style="width: 1.25rem; height: 1.25rem; color: white;" />
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
                        <label class="ts-filter-label"><x-heroicon-o-clipboard-document-check class="ts-filter-icon" /> Status</label>
                        <select wire:model="filterStatus" class="ts-filter-input">
                            <option value="">Semua Status</option>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="lunas">Lunas</option>
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

            <!-- Informasi Pembaruan Cicilan Box -->
            <div class="ts-info-alert">
                <x-heroicon-o-information-circle class="ts-info-icon" />
                <div>
                    <div class="ts-info-title">Informasi Pembaruan Cicilan</div>
                    <div class="ts-info-desc">
                        Jika terdapat pembayaran tagihan baru dari pelanggan, silakan hubungi <b>Admin/Owner</b> untuk mencatat dan memperbarui progres cicilan. Hanya Admin yang memiliki akses sistem untuk menambahkan data pembayaran.
                    </div>
                </div>
            </div>

            <div class="ts-main-content">
                <div class="ts-table-header">
                    <h2 class="ts-content-title" style="margin: 0; white-space: nowrap;">Daftar Penagihan Berkala</h2>
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
                    <!-- Desktop Table -->
                    <table class="ts-desktop-table ts-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Toko / Pelanggan</th>
                                <th>Total Tagihan</th>
                                <th>Progres Pembayaran</th>
                                <th style="text-align: right;">Sisa Tagihan</th>
                                <th style="text-align: center;">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                                @php
                                    $progress = $record->total_penjualan > 0 ? ($record->sudah_dibayar / $record->total_penjualan) * 100 : 0;
                                    $progress = min(100, max(0, $progress));
                                    $sisa = $record->total_penjualan - $record->sudah_dibayar;
                                    $sisa = max(0, $sisa);
                                    $isLunas = $sisa <= 0;
                                    $borderClass = $isLunas ? 'border-disetujui' : 'border-pending';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="row-status-border {{ $borderClass }}"></div>
                                        <div style="display:flex; align-items:center; gap: 0.75rem;">
                                            <div class="ts-cal-block">
                                                <span class="ts-cal-day">{{ \Carbon\Carbon::parse($record->tanggal_beli)->format('d') }}</span>
                                                <span class="ts-cal-month">{{ strtoupper(\Carbon\Carbon::parse($record->tanggal_beli)->format('M')) }}</span>
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
                                        <div style="display:flex; align-items:center; gap: 0.5rem;">
                                            <x-heroicon-o-building-storefront style="width:1.25rem; height:1.25rem; color:#9ca3af;" />
                                            <div>
                                                <div class="ts-text-strong" style="font-weight: 600; font-size: 0.875rem;">{{ $record->buyer->nama_toko ?? 'Unknown' }}</div>
                                                <div style="font-size: 0.75rem; color: #9ca3af;">Store</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="ts-text-strong">IDR {{ number_format($record->total_penjualan, 2, '.', ',') }}</span>
                                    </td>
                                    <td style="width: 200px;">
                                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                            <div style="display: flex; justify-content: space-between; font-size: 0.75rem; font-weight: 600;">
                                                <span class="ts-text-strong" style="color: #6b7280;">IDR {{ number_format($record->sudah_dibayar, 0, '.', ',') }}</span>
                                                <span style="color: #E30613;">{{ number_format($progress, 1) }}%</span>
                                            </div>
                                            <div style="width: 100%; height: 0.375rem; background-color: #f3f4f6; border-radius: 9999px; overflow: hidden;">
                                                <div style="height: 100%; background-color: {{ $isLunas ? '#111827' : '#E30613' }}; width: {{ $progress }}%; transition: width 0.3s ease;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">
                                        <span class="ts-text-strong" style="font-weight: 700; color: #ef4444;">IDR {{ number_format($sisa, 2, '.', ',') }}</span>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($isLunas)
                                            <span class="ts-stat-badge" style="background-color: #111827; color: white;">Lunas</span>
                                        @else
                                            <span class="ts-stat-badge" style="background-color: #f1f5f9; color: #475569;">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right; min-width: 200px;">
                                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                            {{ ($this->detailAction)(['penjualan_id' => $record->id]) }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="padding: 4rem 1rem; text-align: center;">
                                        <div class="ts-empty-state-wrapper">
                                            <div class="ts-empty-icon-wrapper">
                                                <x-heroicon-o-check-circle class="ts-empty-icon" />
                                            </div>
                                            <div style="font-weight: 600; color: #4b5563; font-size: 0.875rem;" class="ts-text-muted-strong">
                                                Belum ada data penagihan cicilan.
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <!-- Mobile View -->
                    <div class="ts-mobile-list-container">
                        @forelse($records as $record)
                            @php
                                $progress = $record->total_penjualan > 0 ? ($record->sudah_dibayar / $record->total_penjualan) * 100 : 0;
                                $progress = min(100, max(0, $progress));
                                $sisa = $record->total_penjualan - $record->sudah_dibayar;
                                $sisa = max(0, $sisa);
                                $isLunas = $sisa <= 0;
                                $borderClass = $isLunas ? 'border-disetujui' : 'border-pending';
                            @endphp
                            <div class="ts-mobile-card" style="grid-template-columns: 1fr; gap: 0.75rem; padding: 1rem;">
                                <div class="row-status-border {{ $borderClass }}"></div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <div class="ts-text-strong" style="font-size:0.875rem;">{{ \Carbon\Carbon::parse($record->tanggal_beli)->format('d M Y') }}</div>
                                        <div class="ts-text-muted-strong" style="display:flex; align-items:center; gap: 0.25rem; font-weight: 600; font-size: 0.75rem; margin-top: 0.25rem;">
                                            <x-heroicon-o-building-storefront style="width:1rem; height:1rem; color:#9ca3af;" />
                                            {{ $record->buyer->nama_toko ?? 'Unknown' }}
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        @if($isLunas)
                                            <span class="ts-stat-badge" style="background-color: #111827; color: white;">Lunas</span>
                                        @else
                                            <span class="ts-stat-badge" style="background-color: #f1f5f9; color: #475569;">Belum Lunas</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="billing-progress-card" style="padding: 0.75rem; border-radius: 0.5rem;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                                        <span style="font-size: 0.75rem; color: #6b7280;">Total Tagihan</span>
                                        <span class="ts-text-strong" style="font-size: 0.75rem;">IDR {{ number_format($record->total_penjualan, 0, '.', ',') }}</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                        <span style="font-size: 0.75rem; color: #6b7280;">Sudah Dibayar</span>
                                        <span style="font-size: 0.75rem; font-weight: 700; color: #111827;">IDR {{ number_format($record->sudah_dibayar, 0, '.', ',') }}</span>
                                    </div>
                                    
                                    <div style="width: 100%; height: 0.375rem; background-color: #e5e7eb; border-radius: 9999px; overflow: hidden; margin-bottom: 0.5rem;">
                                        <div style="height: 100%; background-color: {{ $isLunas ? '#111827' : '#E30613' }}; width: {{ $progress }}%; transition: width 0.3s ease;"></div>
                                    </div>
                                    
                                    <div class="billing-divider" style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.5rem;">
                                        <div>
                                            <span style="display: block; font-size: 0.75rem; font-weight: 600; color: #374151;">Sisa Tagihan</span>
                                            <span style="display: block; font-size: 0.875rem; font-weight: 700; color: #ef4444;">IDR {{ number_format($sisa, 0, '.', ',') }}</span>
                                        </div>
                                        <div style="display: flex; gap: 0.5rem;">
                                            {{ ($this->detailAction)(['penjualan_id' => $record->id]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="padding: 3rem 1rem;" class="ts-empty-state-wrapper">
                                <div class="ts-empty-icon-wrapper">
                                    <x-heroicon-o-check-circle class="ts-empty-icon" />
                                </div>
                                <div style="font-weight: 600; color: #4b5563; font-size: 0.875rem;" class="ts-text-muted-strong">
                                    Belum ada data penagihan cicilan.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($records->hasPages())
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
                    @endif
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
