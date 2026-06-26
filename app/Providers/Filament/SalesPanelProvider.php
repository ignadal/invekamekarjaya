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
                    /* === GLOBAL ANIMATED BACKGROUND === */
                    .sales-global-bg {
                        position: fixed;
                        top: 0; left: 0; right: 0; bottom: 0;
                        background: linear-gradient(120deg, #ffffff, #ffe0e8, #ffffff, #ffb3c6, #ffffff, #ffe0e8);
                        background-size: 300% 300%;
                        animation: salesGradientBG 20s ease-in-out infinite;
                        z-index: -1;
                        pointer-events: none;
                    }
                    html.dark .sales-global-bg {
                        background-image: linear-gradient(120deg, #09090b, #1f0b0e, #09090b, #300d14, #09090b, #1f0b0e);
                    }
                    @keyframes salesGradientBG {
                        0% { background-position: 0% 0%; }
                        25% { background-position: 100% 50%; }
                        50% { background-position: 100% 100%; }
                        75% { background-position: 0% 50%; }
                        100% { background-position: 0% 0%; }
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
                    }

                    /* Nav links - absolute center so it NEVER shifts */
                    .fi-topbar .fi-topbar-nav-groups {
                        position: absolute !important;
                        left: 50% !important;
                        top: 50% !important;
                        transform: translate(-50%, -50%) !important;
                        display: flex !important;
                        align-items: center !important;
                        gap: 0.125rem !important;
                        list-style: none !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        z-index: 1 !important;
                        white-space: nowrap !important;
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

                    /* Nav item buttons - fixed padding, no size change on active */
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
