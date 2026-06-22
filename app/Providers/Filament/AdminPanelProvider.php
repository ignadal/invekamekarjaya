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
            ->brandname('Mekar Jaya')
            ->sidebarFullyCollapsibleOnDesktop()
            ->sidebarWidth('19rem')
            ->default()
            ->id('admin')
            ->path('admin')
            ->spa()
            ->login()
            ->colors([
                'primary' => \Filament\Support\Colors\Color::Red,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_START,
                fn (): string => '<style>
                    /* Navbar Styling (White, No Border) */
                    html:not(.dark) .fi-topbar { border-bottom: none !important; box-shadow: none !important; background: white !important; }

                    /* Topbar Left Corner Red (Always Red, Dynamic Width) */
                    @media (min-width: 1024px) {
                        html:not(.dark) .fi-topbar { padding-left: 0 !important; }
                        
                        /* Base styling for the Red Box */
                        html:not(.dark) .fi-topbar-start {
                            background-color: #b91c1c !important;
                            height: 4rem !important;
                            padding-left: 1.5rem !important;
                            padding-right: 1.5rem !important;
                            box-sizing: border-box;
                            margin-right: 1.5rem !important;
                        }
                        html:not(.dark) .fi-topbar-start button { color: white !important; }
                        html:not(.dark) .fi-topbar-start button:hover { background-color: rgba(255,255,255,0.1) !important; }

                        /* 1. When sidebar is OPEN */
                        html:not(.dark):has(.fi-main-ctn-sidebar-open) .fi-topbar-start { width: var(--sidebar-width) !important; }
                        html:not(.dark):has(.fi-main-ctn-sidebar-open) .fi-topbar-start .fi-logo { color: white !important; margin-left: 0 !important; }
                        
                        /* 2. When sidebar is COLLAPSED */
                        html:not(.dark):not(:has(.fi-main-ctn-sidebar-open)) .fi-topbar-start { width: calc(var(--collapsed-sidebar-width) + 15px) !important; }
                        body:not(:has(.fi-main-ctn-sidebar-open)) .fi-topbar-start .fi-logo { 
                            display: none !important;
                        }
                    }

                    /* Sidebar Background (Darker Red) */
                    html:not(.dark) aside.fi-sidebar { background: #b91c1c !important; }
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
                    html:not(.dark) aside.fi-sidebar *::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3) !important; border-radius: 10px; }
                    html:not(.dark) aside.fi-sidebar *::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.5) !important; }

                    /* Dashboard Filter Bar Styling - Red Gradient Header */
                    .fi-page-header > form { width: 100% !important; max-width: 100% !important; }
                    
                    .red-gradient-filter { 
                        background: linear-gradient(135deg, #991b1b, #dc2626) !important;
                        border-radius: 0.75rem !important;
                        margin-bottom: 1.5rem !important;
                        border: none !important;
                        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1) !important;
                    }
                    /* Remove default backgrounds from Filament Section inner wrappers */
                    .red-gradient-filter,
                    .red-gradient-filter > div,
                    .red-gradient-filter header,
                    .red-gradient-filter header > div {
                        background-color: transparent !important;
                        border-color: transparent !important;
                    }
                    .red-gradient-filter * { color: white !important; }
                    .red-gradient-filter .fi-input { background: rgba(255,255,255,0.15) !important; border: 1px solid rgba(255,255,255,0.3) !important; color: white !important; }
                    .red-gradient-filter .fi-input:focus { border-color: white !important; }
                    .red-gradient-filter select, .red-gradient-filter option { color: #111827 !important; }
                    .red-gradient-filter .fi-select-trigger { background: rgba(255,255,255,0.15) !important; border: 1px solid rgba(255,255,255,0.3) !important; }
                    .red-gradient-filter .fi-select-trigger * { color: white !important; }

                    /* Stat Card Bottom Border - Both Light and Dark Mode */
                    .fi-wi-stats-overview-stat { border-bottom: 3px solid #dc2626 !important; border-radius: 0.75rem; overflow: hidden; }
                    .fi-wi-stats-overview-stat:nth-child(2) { border-bottom-color: #ef4444 !important; }
                    .fi-wi-stats-overview-stat:nth-child(3) { border-bottom-color: #f87171 !important; }
                    .fi-wi-stats-overview-stat:nth-child(4) { border-bottom-color: #b91c1c !important; }
                    .fi-wi-stats-overview-stat:nth-child(5) { border-bottom-color: #991b1b !important; }
                    .fi-wi-stats-overview-stat:nth-child(6) { border-bottom-color: #7f1d1d !important; }
                    .fi-wi-stats-overview-stat:nth-child(7) { border-bottom-color: #fca5a5 !important; }
                    .fi-wi-stats-overview-stat:nth-child(8) { border-bottom-color: #f59e0b !important; }
                </style>'
            )
            ->plugins([
                FilamentApexChartsPlugin::make(),
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
