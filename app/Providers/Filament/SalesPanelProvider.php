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
                     /* === GLOBAL SOLID BACKGROUND === */
                    .sales-global-bg {
                        position: fixed;
                        top: 0; left: 0; right: 0; bottom: 0;
                        background-color: #ffffff !important;
                        z-index: -1;
                        pointer-events: none;
                    }
                    html.dark .sales-global-bg {
                        background-color: #09090b !important;
                    }
                    /* Force transparent background on containers so the fixed bg is visible */
                    body, .fi-layout, .fi-main {
                        background-color: transparent !important;
                        background-image: none !important;
                    }

                    /* === NAVBAR: Fixed rigid structure === */
                    .fi-topbar-ctn {
                        height: 4rem !important;
                        min-height: 4rem !important;
                        max-height: 4rem !important;
                        overflow: visible !important;
                    }
                    html:not(.dark) .fi-topbar {
                        background-color: #b91c1c !important;
                        border-bottom: none !important;
                        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1) !important;
                        height: 4rem !important;
                        min-height: 4rem !important;
                        max-height: 4rem !important;
                        position: relative !important;
                        display: flex !important;
                        align-items: center !important;
                        padding: 0 1rem !important;
                    }

                    /* Hide sidebar toggle buttons - not needed with top nav */
                    .fi-topbar .fi-topbar-open-sidebar-btn,
                    .fi-topbar .fi-topbar-close-sidebar-btn {
                        display: none !important;
                        width: 0 !important;
                        height: 0 !important;
                        overflow: hidden !important;
                        position: absolute !important;
                    }

                    /* Logo area - fixed width on left */
                    .fi-topbar .fi-topbar-start {
                        position: relative !important;
                        z-index: 2 !important;
                        flex: 0 0 auto !important;
                        display: flex !important;
                        align-items: center !important;
                        height: 4rem !important;
                        margin-left: 0 !important;
                        padding-left: 0 !important;
                    }
                    /* Remove default margins/padding that space the logo from the hidden sidebar toggle button */
                    .fi-topbar .fi-logo {
                        margin-left: 0 !important;
                        margin-inline-start: 0 !important;
                        padding-left: 0 !important;
                    }

                    /* === NAVBAR RESPONSIVE CONFIGURATION === */
                    @media (min-width: 1024px) {
                        /* Desktop layout: Nav links absolutely centered in header */
                        .fi-topbar .fi-topbar-nav-groups {
                            position: absolute !important;
                            left: 50% !important;
                            top: 50% !important;
                            transform: translate(-50%, -50%) !important;
                            display: flex !important;
                            flex-wrap: nowrap !important;
                            align-items: center !important;
                            gap: 0.125rem !important;
                            list-style: none !important;
                            margin: 0 !important;
                            padding: 0 !important;
                            z-index: 1 !important;
                            white-space: nowrap !important;
                        }

                        .fi-topbar .fi-topbar-item {
                            margin: 0 !important;
                            padding: 0 !important;
                        }

                        .fi-topbar .fi-topbar-item-btn {
                            padding: 0.5rem 0.75rem !important;
                            margin: 0 !important;
                            border: none !important;
                            outline: none !important;
                            box-sizing: border-box !important;
                            border-radius: 0.5rem !important;
                            transition: background-color 0.15s ease !important;
                        }

                        .fi-topbar .fi-topbar-item-icon {
                            width: 1.25rem !important;
                            height: 1.25rem !important;
                            flex-shrink: 0 !important;
                        }
                    }

                    @media (max-width: 1023px) {
                        /* Mobile layout: Bottom navigation bar */
                        .fi-topbar .fi-topbar-nav-groups {
                            position: fixed !important;
                            bottom: 0 !important;
                            left: 0 !important;
                            right: 0 !important;
                            top: auto !important;
                            transform: none !important;
                            width: 100% !important;
                            height: 4.5rem !important;
                            background-color: #b91c1c !important; /* same red */
                            display: flex !important;
                            flex-direction: row !important;
                            justify-content: space-around !important;
                            align-items: center !important;
                            padding: 0 !important; /* Reset padding to prevent left/right offset */
                            z-index: 99999 !important; /* Extremely high z-index to stay on top of all page content */
                            pointer-events: auto !important; /* Ensure clicks always register */
                            border-top: 1px solid rgba(255, 255, 255, 0.15) !important;
                            box-shadow: 0 -4px 10px rgba(0,0,0,0.1) !important;
                            margin: 0 !important;
                            list-style: none !important;
                            white-space: nowrap !important;
                        }

                        /* Dark mode bottom navigation */
                        html.dark .fi-topbar .fi-topbar-nav-groups {
                            background-color: #18181b !important;
                            border-top: 1px solid #3f3f46 !important;
                            box-shadow: 0 -4px 10px rgba(0,0,0,0.3) !important;
                        }

                        /* Ensure items spread evenly and are centered */
                        .fi-topbar .fi-topbar-item {
                            flex: 1 1 0% !important;
                            max-width: 20% !important;
                            margin: 0 !important;
                            padding: 0 0.25rem !important; /* Uniform side padding for symmetric gap between buttons */
                            display: flex !important;
                            justify-content: center !important;
                            align-items: center !important;
                        }

                        /* Style mobile bottom bar item buttons to be vertical (icon on top of label) */
                        .fi-topbar .fi-topbar-item-btn {
                            display: flex !important;
                            flex-direction: column !important;
                            align-items: center !important;
                            justify-content: center !important;
                            gap: 0.1rem !important;
                            padding: 0.35rem 0.1rem !important;
                            width: 100% !important; /* Fill the padded column area */
                            height: 4.2rem !important;
                            border-radius: 0.75rem !important; /* Match modern card/tab corner radius */
                            box-sizing: border-box !important;
                            transition: background-color 0.15s ease !important;
                            pointer-events: auto !important;
                        }

                        /* Set icon size for mobile */
                        .fi-topbar .fi-topbar-item-icon {
                            width: 1.4rem !important;
                            height: 1.4rem !important;
                            flex-shrink: 0 !important;
                            margin: 0 !important;
                        }

                        /* Style mobile labels - force fixed height and allow wrapping to center-align perfectly */
                        .fi-topbar .fi-topbar-item-btn span {
                            font-size: 0.58rem !important;
                            font-weight: 700 !important;
                            text-align: center !important;
                            white-space: normal !important; /* Allow wrapping to 2 lines */
                            line-height: 1.15 !important;
                            max-width: 100% !important;
                            height: 1.4rem !important; /* Fixed height for up to 2 lines of text */
                            display: block !important; /* Change from flex to block for reliable browser text centering */
                            overflow: hidden !important;
                            text-overflow: ellipsis !important;
                        }

                        /* Add padding to page container only when the topbar navbar exists */
                        body:has(.fi-topbar) {
                            padding-bottom: 4.5rem !important;
                        }
                    }

                    /* User menu area - fixed on right */
                    .fi-topbar .fi-topbar-end {
                        position: relative !important;
                        z-index: 2 !important;
                        flex: 0 0 auto !important;
                        margin-left: auto !important;
                        display: flex !important;
                        align-items: center !important;
                        height: 4rem !important;
                    }

                    /* === PREMIUM CARD & SECTION CONTAINER STYLING === */
                    html:not(.dark) .fi-card,
                    html:not(.dark) .fi-section,
                    html:not(.dark) .fi-ta-ctn,
                    html:not(.dark) .fi-wi-stats-overview-stat {
                        background-color: #ffffff !important;
                        border: 1px solid rgba(185, 28, 28, 0.08) !important; /* soft red-tinted border to match branding */
                        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02) !important;
                        border-radius: 0.75rem !important;
                        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
                    }
                    html:not(.dark) .fi-card:hover,
                    html:not(.dark) .fi-wi-stats-overview-stat:hover {
                        transform: translateY(-2px) !important;
                        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.06), 0 10px 10px -5px rgba(0, 0, 0, 0.03) !important;
                    }


                    /* === COLORS === */
                    html:not(.dark) .fi-topbar span,
                    html:not(.dark) .fi-topbar svg,
                    html:not(.dark) .fi-topbar a,
                    html:not(.dark) .fi-topbar div.fi-logo {
                        color: white !important;
                    }

                    /* Active state - only background color change */
                    html:not(.dark) .fi-topbar .fi-topbar-item.fi-active .fi-topbar-item-btn {
                        background-color: rgba(255,255,255,0.25) !important;
                    }
                    html:not(.dark) .fi-topbar .fi-topbar-item-btn:hover {
                        background-color: rgba(255,255,255,0.1) !important;
                    }
                    html:not(.dark) .fi-topbar .fi-topbar-item.fi-active .fi-topbar-item-btn:hover {
                        background-color: rgba(255,255,255,0.3) !important;
                    }

                    /* Dropdown panels - readable in light mode */
                    html:not(.dark) .fi-topbar .fi-dropdown-panel span,
                    html:not(.dark) .fi-topbar .fi-dropdown-panel svg,
                    html:not(.dark) .fi-topbar .fi-dropdown-panel a {
                        color: #1f2937 !important;
                    }
                    html:not(.dark) .fi-topbar .fi-dropdown-panel {
                        background-color: white !important;
                    }
                    html:not(.dark) .fi-topbar .fi-dropdown-panel a:hover,
                    html:not(.dark) .fi-topbar .fi-dropdown-panel button:hover {
                        background-color: #f3f4f6 !important;
                    }

                    /* Badges */
                    html:not(.dark) .fi-topbar .fi-badge,
                    html:not(.dark) .fi-topbar .fi-badge span {
                        background-color: white !important;
                        color: #b91c1c !important;
                        font-weight: 900 !important;
                        border: none !important;
                    }

                    /* Dark Mode */
                    html.dark .fi-topbar {
                        background-color: #18181b !important;
                        border-bottom: 1px solid #3f3f46 !important;
                    }
                </style>'
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::BODY_START,
                fn (): string => '<div class="sales-global-bg"></div>'
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
