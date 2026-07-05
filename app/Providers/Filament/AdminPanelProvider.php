<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\LabaChart;
use App\Filament\Widgets\PengeluaranChart;
use App\Filament\Widgets\PenjualanChart;
use App\Filament\Widgets\TopSalesWidget;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ->brandname('Mekar Jaya')
            ->brandLogo(asset('images/woi.png'))
            ->brandLogoHeight('4rem')
            ->sidebarFullyCollapsibleOnDesktop()
            ->sidebarWidth('17rem')
            ->default()
            ->id('admin')
            ->path('admin')
            ->spa()
            ->login(\App\Filament\Pages\Auth\CustomLogin::class)
            ->colors([
                'primary' => \Filament\Support\Colors\Color::Red,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::BODY_START,
                fn (): string => request()->path() === 'admin' 
                    ? \Illuminate\Support\Facades\Blade::render('@livewire(\App\Livewire\JatuhTempoNotification::class)')
                    : ''
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_START,
                fn (): string => '<style>
                    /* Navbar Styling (White, No Border) */
                    html:not(.dark) .fi-topbar { border-bottom: none !important; box-shadow: none !important; background: white !important; }

                    /* Topbar Left Corner Red (Dynamic Width) - Layout Applies to Both Modes */
                    @media (min-width: 1024px) {
                        .fi-topbar { padding-left: 0 !important; }
                        
                        /* Base layout for Topbar Start */
                        .fi-topbar-start {
                            height: 4rem !important;
                            padding-left: 1.5rem !important;
                            padding-right: 1.5rem !important;
                            box-sizing: border-box;
                        }
                        
                        /* Layout when sidebar is OPEN */
                        body:has(.fi-main-ctn-sidebar-open) .fi-topbar-start { width: var(--sidebar-width, 17rem) !important; }
                        body:has(.fi-main-ctn-sidebar-open) .fi-topbar-start .fi-logo { margin-left: 0 !important; }
                        
                        /* Layout when sidebar is COLLAPSED */
                        body:not(:has(.fi-main-ctn-sidebar-open)) .fi-topbar-start { 
                            width: auto !important; 
                            padding-left: 1.5rem !important; 
                            padding-right: 1.5rem !important;
                        }
                        body:not(:has(.fi-main-ctn-sidebar-open)) .fi-topbar-start .fi-logo { 
                            display: none !important;
                        }

                        /* =======================================
                           COLORS FOR LIGHT MODE (Red Box)
                           ======================================= */
                        html:not(.dark) .fi-topbar-start { 
                            background-color: #b91c1c !important;
                            background-image: linear-gradient(135deg, #7f1d1d 0%, #dc2626 50%, #991b1b 100%) !important;
                            background-attachment: fixed !important;
                        }
                        html:not(.dark) .fi-topbar-start button { color: white !important; }
                        html:not(.dark) .fi-topbar-start button:hover { background-color: rgba(255,255,255,0.1) !important; }
                        html:not(.dark):has(.fi-main-ctn-sidebar-open) .fi-topbar-start .fi-logo { color: white !important; }
                        
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) .fi-topbar-start { 
                            background-color: transparent !important; 
                            background-image: none !important;
                        }
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) .fi-topbar-start button { color: #b91c1c !important; }
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) .fi-topbar-start button:hover { background-color: rgba(185,28,28,0.1) !important; }
                    }

                    /* Sidebar Background (Red Gradient Seamless) */
                    html:not(.dark) aside.fi-sidebar {
                        background-color: #b91c1c !important;
                        background-image: linear-gradient(135deg, #7f1d1d 0%, #dc2626 50%, #991b1b 100%) !important;
                        background-attachment: fixed !important;
                        box-shadow: inset -5px 0 15px rgba(0,0,0,0.1) !important;
                    }
                    html:not(.dark) aside.fi-sidebar nav,
                    html:not(.dark) aside.fi-sidebar section,
                    html:not(.dark) aside.fi-sidebar header { background-color: transparent !important; }

                    /* Sidebar Text & Icons */
                    html:not(.dark) aside.fi-sidebar span,
                    html:not(.dark) aside.fi-sidebar svg,
                    html:not(.dark) aside.fi-sidebar a,
                    html:not(.dark) aside.fi-sidebar div.fi-logo { color: white !important; }
                    
                    /* Sidebar Group labels */
                    html:not(.dark) aside.fi-sidebar .fi-sidebar-group-label span { color: rgba(255,255,255,0.8) !important; }

                    /* Sidebar Active button */
                    html:not(.dark) aside.fi-sidebar .fi-sidebar-item-active > a,
                    html:not(.dark) aside.fi-sidebar .fi-sidebar-item-active > button,
                    html:not(.dark) aside.fi-sidebar .fi-active > a,
                    html:not(.dark) aside.fi-sidebar .fi-active > button { background-color: rgba(255,255,255,0.25) !important; border-radius: 0.5rem; }
                    
                    html:not(.dark) aside.fi-sidebar .fi-sidebar-item-active span,
                    html:not(.dark) aside.fi-sidebar .fi-sidebar-item-active svg,
                    html:not(.dark) aside.fi-sidebar .fi-sidebar-item-active a,
                    html:not(.dark) aside.fi-sidebar .fi-active span,
                    html:not(.dark) aside.fi-sidebar .fi-active svg,
                    html:not(.dark) aside.fi-sidebar .fi-active a { color: white !important; }

                    /* Sidebar Hover button background */
                    html:not(.dark) aside.fi-sidebar a:hover:not(.fi-sidebar-item-active > a),
                    html:not(.dark) aside.fi-sidebar button:hover:not(.fi-sidebar-item-active > button) { background-color: rgba(255,255,255,0.1) !important; }

                    /* Sidebar Scrollbar Styling */
                    html:not(.dark) aside.fi-sidebar { scrollbar-color: rgba(255, 255, 255, 0.3) transparent !important; scrollbar-width: thin; }
                    html:not(.dark) aside.fi-sidebar *::-webkit-scrollbar { width: 6px; height: 6px; }
                    html:not(.dark) aside.fi-sidebar *::-webkit-scrollbar-track { background: transparent !important; }
                    html:not(.dark) aside.fi-sidebar *::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3) !important; border-radius: 4px; }
                    html:not(.dark) aside.fi-sidebar *::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.5) !important; }

                    /* Sidebar Collapsed State (White background, Red icons) */
                    @media (min-width: 1024px) {
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar {
                            background: white !important;
                            border-right: 1px solid #fecaca !important;
                        }
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar span,
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar svg,
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar a {
                            color: #b91c1c !important;
                        }
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar .fi-sidebar-item-active > a,
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar .fi-sidebar-item-active > button,
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar .fi-active > a,
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar .fi-active > button {
                            background-color: rgba(185, 28, 28, 0.1) !important;
                        }
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar a:hover:not(.fi-sidebar-item-active > a),
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar button:hover:not(.fi-sidebar-item-active > button) { 
                            background-color: rgba(185, 28, 28, 0.05) !important; 
                        }
                        
                        /* Scrollbar when collapsed (Red tinted) */
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar { scrollbar-color: rgba(185, 28, 28, 0.3) transparent !important; }
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar *::-webkit-scrollbar-thumb { background: rgba(185, 28, 28, 0.3) !important; }
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) aside.fi-sidebar *::-webkit-scrollbar-thumb:hover { background: rgba(185, 28, 28, 0.5) !important; }
                    }

                    /* Dashboard Filter Bar Styling - Red Gradient Header */
                    .fi-page-header > form,
                    .fi-page-header form.fi-form,
                    div:has(> .red-gradient-filter),
                    form:has(.red-gradient-filter) { 
                        width: 100% !important; 
                        max-width: 100% !important; 
                    }
                    
                    /* Apply Red Gradient in Light Mode (Brighter Red) */
                    html:not(.dark) .red-gradient-filter { 
                        background: linear-gradient(to right, #991b1b, #dc2626, #b91c1c, #991b1b) !important; 
                        background-size: 300% 300% !important;
                        animation: gradient-animation 8s ease infinite !important;
                        border-radius: 0.75rem !important;
                        margin-bottom: 1.5rem !important;
                        border: none !important;
                    }
                    
                    /* Apply VERY Dark Red Gradient in Dark Mode (Very Dark Red) */
                    html.dark .red-gradient-filter { 
                        background: linear-gradient(to right, #450a0a, #991b1b, #450a0a) !important; 
                        background-size: 300% 300% !important;
                        animation: gradient-animation 8s ease infinite !important;
                        border-radius: 0.75rem !important;
                        margin-bottom: 1.5rem !important;
                        border: none !important;
                    }
                    @keyframes gradient-animation {
                        0% { background-position: 0% 50%; }
                        50% { background-position: 100% 50%; }
                        100% { background-position: 0% 50%; }
                    }
                    .red-gradient-filter .fi-section-header,
                    .red-gradient-filter header,
                    .red-gradient-filter hr { 
                        border-bottom: none !important; 
                        border-bottom-width: 0 !important; 
                        border-top-width: 0 !important;
                    }
                    
                    /* Force inner section containers to be transparent so the gradient shows */
                    .red-gradient-filter,
                    .red-gradient-filter > div,
                    .red-gradient-filter section,
                    .red-gradient-filter header,
                    .red-gradient-filter header > div {
                        background-color: transparent !important;
                    }
                    
                    /* Reset Filter Button */
                    .reset-filter-btn {
                        background-color: #171717 !important;
                        color: white !important;
                        border: none !important;
                        box-shadow: none !important;
                        margin-bottom: 2px !important;
                    }
                    .reset-filter-btn:hover { background-color: #262626 !important; }
                    
                    html.dark .reset-filter-btn {
                        background-color: #3f3f46 !important; /* Lighter black for dark mode */
                    }
                    html.dark .reset-filter-btn:hover { background-color: #52525b !important; }
                    
                    /* Make the text white so it contrasts with the red gradient */
                    html:not(.dark) .red-gradient-filter header h3,
                    html:not(.dark) .red-gradient-filter header p,
                    html:not(.dark) .red-gradient-filter .fi-fo-field-wrp-label span {
                        color: white !important;
                    }
                    /* Table Toolbar Background (Behind Search) - Light Mode Only */
                    html:not(.dark) .fi-ta-header-toolbar {
                        background-color: #dc2626 !important; /* Brighter Red */
                        border-bottom: none !important;
                    }
                    /* Make action icon buttons in toolbar (like column toggle/filters) white */
                    html:not(.dark) .fi-ta-header-toolbar .fi-icon-btn,
                    html:not(.dark) .fi-ta-header-toolbar .fi-icon-btn svg {
                        color: white !important;
                    }
                    
                    /* Form Section Headers (e.g. Detail Kategori) - Light Mode Only */
                    html:not(.dark) .fi-section-header {
                        background-color: #dc2626 !important;
                        border-bottom: none !important;
                        border-top-left-radius: calc(0.75rem - 1px) !important;
                        border-top-right-radius: calc(0.75rem - 1px) !important;
                        padding: 1rem 1.5rem !important;
                    }
                    html:not(.dark) .fi-section-header .fi-section-header-heading,
                    html:not(.dark) .fi-section-header .fi-section-header-description,
                    html:not(.dark) .fi-section-header .fi-icon-btn,
                    html:not(.dark) .fi-section-header .fi-icon-btn svg {
                        color: white !important;
                    }

                    /* Page Title Text Color - Light Mode Only */
                    html:not(.dark) .fi-header-heading {
                        color: #dc2626 !important;
                    }
                    
                    /* Table Header Background and Text Color - Light Mode Only */
                    html:not(.dark) .fi-ta-header {
                        background-color: #dc2626 !important;
                    }
                    html:not(.dark) .fi-ta-header-heading,
                    html:not(.dark) .fi-ta-header-description {
                        color: white !important;
                    }
                    
                    /* Table Checkboxes Border (Light Mode Only) */
                    html:not(.dark) .fi-checkbox-input {
                        border: 2px solid #dc2626 !important;
                    }
                    html:not(.dark) .fi-checkbox-input:checked {
                        background-color: #dc2626 !important;
                    }
                    /* Radio Button Border (Light Mode Only) */
                    html:not(.dark) .fi-radio-input {
                        border-color: #dc2626 !important;
                    }
                    html:not(.dark) .fi-radio-input:checked {
                        background-color: #dc2626 !important;
                    }
                    
                    /* Table Header Styling (Red) - Light Mode Only */
                    html:not(.dark) .fi-ta-table thead,
                    html:not(.dark) .fi-ta-table thead tr,
                    html:not(.dark) .fi-ta-table thead th,
                    html:not(.dark) .fi-ta-table-stacked-header-row,
                    html:not(.dark) .fi-ta-table-stacked-header-cell {
                        background-color: #dc2626 !important; /* Brighter Red */
                        border-bottom: none !important;
                    }
                    
                    /* Force text color to white for ALL header contents */
                    html:not(.dark) .fi-ta-table thead th,
                    html:not(.dark) .fi-ta-table thead th *,
                    html:not(.dark) .fi-ta-table thead th span,
                    html:not(.dark) .fi-ta-table-stacked-header-cell,
                    html:not(.dark) .fi-ta-table-stacked-header-cell *,
                    html:not(.dark) .fi-ta-table-stacked-header-cell span {
                        color: #ffffff !important;
                    }

                    /* We leave the select dropdowns alone so they follow Filament default styles */

                    /* Stat Card Bottom Border - Both Light and Dark Mode */
                    .fi-wi-stats-overview-stat { border-bottom: 3px solid #dc2626 !important; border-radius: 0.75rem; overflow: hidden; }
                    .fi-wi-stats-overview-stat:nth-child(2) { border-bottom-color: #ef4444 !important; }
                    .fi-wi-stats-overview-stat:nth-child(3) { border-bottom-color: #f87171 !important; }
                    .fi-wi-stats-overview-stat:nth-child(4) { border-bottom-color: #b91c1c !important; }
                    .fi-wi-stats-overview-stat:nth-child(5) { border-bottom-color: #991b1b !important; }
                    .fi-wi-stats-overview-stat:nth-child(6) { border-bottom-color: #7f1d1d !important; }
                    .fi-wi-stats-overview-stat:nth-child(7) { border-bottom-color: #fca5a5 !important; }
                    .fi-wi-stats-overview-stat:nth-child(8) { border-bottom-color: #f59e0b !important; }

                    /* Center actions in Barangs grid ONLY */
                    .barangs-grid-card .fi-ta-record-actions,
                    .barangs-grid-card .fi-ta-actions {
                        justify-content: center !important;
                    }

                    /* Edge-to-edge images in Grid Cards */
                    .custom-square-wrapper {
                        margin: -1rem -1rem 1rem -1rem !important;
                        width: calc(100% + 2rem) !important;
                        max-width: none !important;
                        display: flex !important;
                        justify-content: center !important;
                    }
                    .custom-square-wrapper img {
                        width: 100% !important;
                        max-width: 100% !important;
                        aspect-ratio: 1/1 !important;
                        height: auto !important;
                        object-fit: cover !important;
                        border-radius: 0.75rem 0.75rem 0 0 !important;
                    }

                    .custom-rect-wrapper {
                        margin: -1rem -1rem 1rem -1rem !important;
                        width: calc(100% + 2rem) !important;
                        max-width: none !important;
                        display: flex !important;
                        justify-content: center !important;
                    }
                    .custom-rect-wrapper img {
                        width: 100% !important;
                        max-width: 100% !important;
                        height: 250px !important;
                        object-fit: cover !important;
                        border-radius: 0.75rem 0.75rem 0 0 !important;
                    }

                    /* Red borders on outermost container - Light Mode Only */
                    html:not(.dark) .fi-ta-ctn {
                        border: 2px solid #dc2626 !important;
                        border-radius: 0.75rem !important;
                        overflow: hidden !important;
                        box-shadow: none !important;
                    }
                    /* Remove outer border if its a card grid layout */
                    html:not(.dark) .fi-ta-ctn:has(.fi-ta-content-grid) {
                        border: none !important;
                    }
                    html:not(.dark) .fi-ta-content-grid .fi-ta-record {
                        border: 2px solid #dc2626 !important;
                        border-radius: 0.75rem !important;
                    }
                    html:not(.dark) .fi-ta-table {
                        border: none !important;
                        border-radius: 0 !important;
                        width: 100% !important;
                    }
                    html:not(.dark) .fi-ta-table td {
                        border-bottom: 1px solid #fecaca !important;
                    }
                    /* Force grid images to stretch full width and crop */
                    .fi-ta-content-grid .fi-ta-image {
                        width: 100% !important;
                        max-width: 100% !important;
                        justify-content: center;
                    }
                    .fi-ta-content-grid .fi-ta-image img {
                        width: 100% !important;
                        max-width: 100% !important;
                        object-fit: cover !important;
                        height: 250px !important;
                        border-radius: 0.75rem 0.75rem 0 0 !important;
                    }

                    /* =========================================
                       SIDEBAR BADGES VISIBILITY FIX (MAX SPECIFICITY)
                       ========================================= */
                    html:not(.dark) body aside.fi-sidebar .fi-sidebar-item-active .fi-sidebar-item-badge,
                    html:not(.dark) body aside.fi-sidebar .fi-sidebar-item-active .fi-sidebar-item-badge span,
                    html:not(.dark) body aside.fi-sidebar .fi-sidebar-item-badge,
                    html:not(.dark) body aside.fi-sidebar .fi-sidebar-item-badge span,
                    html:not(.dark) body aside.fi-sidebar .fi-badge,
                    html:not(.dark) body aside.fi-sidebar .fi-badge span {
                        background-color: white !important;
                        color: #b91c1c !important; /* Dark Red Text */
                        font-weight: 900 !important;
                        border: none !important;
                    }

                    /* Warning Badges */
                    html:not(.dark) body aside.fi-sidebar .fi-sidebar-item-active [class*="warning"] .fi-sidebar-item-badge,
                    html:not(.dark) body aside.fi-sidebar .fi-sidebar-item-active [class*="warning"] .fi-sidebar-item-badge span,
                    html:not(.dark) body aside.fi-sidebar [class*="warning"] .fi-sidebar-item-badge,
                    html:not(.dark) body aside.fi-sidebar [class*="warning"] .fi-sidebar-item-badge span,
                    html:not(.dark) body aside.fi-sidebar .fi-badge[class*="warning"],
                    html:not(.dark) body aside.fi-sidebar .fi-badge[class*="warning"] span {
                        background-color: white !important;
                        color: #b91c1c !important;
                        border: none !important;
                    }

                    /* Avatar styling - Red Border for Admin */
                    html .fi-topbar .fi-avatar,
                    html .fi-topbar img.fi-avatar,
                    html .fi-topbar img.rounded-full {
                        border: 2px solid #E30613 !important;
                        border-radius: 50% !important;
                        box-sizing: content-box !important;
                    }
                </style>'
            )
            ->plugins([
                FilamentApexChartsPlugin::make(),
            ])
            ->userMenuItems([
                'profile' => \Filament\Navigation\MenuItem::make()
                    ->label('Profil Saya')
                    ->url(fn (): string => \App\Filament\Pages\Profile::getUrl())
                    ->icon('heroicon-m-user-circle'),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                DashboardStatsOverview::class,
                LabaChart::class,
                PengeluaranChart::class,
                PenjualanChart::class,
                TopSalesWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
