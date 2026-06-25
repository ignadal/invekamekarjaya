<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Sales\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SalesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('sales')
            ->path('')
            ->brandLogo(asset('images/woi.png'))
            ->brandLogoHeight('4rem')
            ->topNavigation()
            ->login(\App\Filament\Pages\Auth\CustomSalesLogin::class)
            ->colors([
                'primary' => Color::Red,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_START,
                fn (): string => '<style>
                    /* Navbar Styling (Red Background) */
                    html:not(.dark) .fi-topbar { 
                        background-color: #b91c1c !important; 
                        border-bottom: none !important; 
                        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important; 
                    }

                    /* Navbar Text & Icons */
                    html:not(.dark) .fi-topbar span,
                    html:not(.dark) .fi-topbar svg,
                    html:not(.dark) .fi-topbar a,
                    html:not(.dark) .fi-topbar div.fi-logo { 
                        color: white !important; 
                    }

                    /* Exceptions for dropdowns inside topbar so they remain readable in light mode */
                    html:not(.dark) .fi-topbar .fi-dropdown-panel span,
                    html:not(.dark) .fi-topbar .fi-dropdown-panel svg,
                    html:not(.dark) .fi-topbar .fi-dropdown-panel a {
                        color: #1f2937 !important; /* gray-800 */
                    }
                    
                    html:not(.dark) .fi-topbar .fi-dropdown-panel {
                        background-color: white !important;
                    }

                    html:not(.dark) .fi-topbar .fi-dropdown-panel a:hover,
                    html:not(.dark) .fi-topbar .fi-dropdown-panel button:hover {
                        background-color: #f3f4f6 !important; /* gray-100 */
                    }

                    /* Top Navigation Items (Active & Hover) */
                    html:not(.dark) .fi-topbar .fi-active > a,
                    html:not(.dark) .fi-topbar .fi-active > button,
                    html:not(.dark) .fi-topbar .fi-tabs-item-active > a,
                    html:not(.dark) .fi-topbar .fi-tabs-item-active > button,
                    html:not(.dark) .fi-topbar a.bg-gray-50,
                    html:not(.dark) .fi-topbar a.bg-white,
                    html:not(.dark) .fi-topbar button.bg-gray-50,
                    html:not(.dark) .fi-topbar button.bg-white { 
                        background-color: rgba(255, 255, 255, 0.25) !important; 
                        border-radius: 0.5rem; 
                    }
                    
                    html:not(.dark) .fi-topbar a:hover,
                    html:not(.dark) .fi-topbar button:hover { 
                        background-color: rgba(255, 255, 255, 0.1) !important; 
                        border-radius: 0.5rem;
                    }
                    
                    /* Reset hover for dropdown items */
                    html:not(.dark) .fi-topbar .fi-dropdown-panel button:hover,
                    html:not(.dark) .fi-topbar .fi-dropdown-panel a:hover {
                        background-color: #f3f4f6 !important;
                    }

                    /* Badges in Navbar */
                    html:not(.dark) .fi-topbar .fi-badge,
                    html:not(.dark) .fi-topbar .fi-badge span {
                        background-color: white !important;
                        color: #b91c1c !important;
                        font-weight: 900 !important;
                        border: none !important;
                    }

                    /* Dark Mode Enhancements for Navbar */
                    html.dark .fi-topbar {
                        background-color: #18181b !important;
                        border-bottom: 1px solid #3f3f46 !important;
                    }
                </style>'
            )
            ->discoverResources(in: app_path('Filament/Sales/Resources'), for: 'App\Filament\Sales\Resources')
            ->discoverPages(in: app_path('Filament/Sales/Pages'), for: 'App\Filament\Sales\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Sales/Widgets'), for: 'App\Filament\Sales\Widgets')
            ->widgets([
            ])
            ->userMenuItems([
                'profile' => \Filament\Navigation\MenuItem::make()
                    ->label('Profil Saya')
                    ->url(fn (): string => \App\Filament\Sales\Pages\Profile::getUrl())
                    ->icon('heroicon-m-user-circle'),
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
