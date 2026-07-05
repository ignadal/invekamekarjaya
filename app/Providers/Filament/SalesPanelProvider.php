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

                    /* Wavy Bottom Edge for Navbar (Light Mode) */
                    html:not(.dark) .fi-topbar {
                        box-shadow: none !important;
                        filter: none !important;
                    }
                    html:not(.dark) .fi-topbar::after {
                        content: "" !important;
                        position: absolute !important;
                        bottom: -40px !important;
                        left: 0 !important;
                        right: 0 !important;
                        height: 40px !important;
                        background-image: url("data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1440 160%22 preserveAspectRatio=%22none%22%3E%3Cpath d=%22M0,30 C200,180 400,-20 720,40 C1000,100 1250,-10 1440,30 L1440,0 L0,0 Z%22 fill=%22%23b91c1c%22/%3E%3C/svg%3E") !important;
                        background-size: 100% 100% !important;
                        background-repeat: no-repeat !important;
                        z-index: -1 !important;
                        pointer-events: none !important;
                        filter: drop-shadow(0 4px 4px rgba(0,0,0,0.1)) !important;
                    }

                    /* Wavy Bottom Edge for Navbar (Dark Mode) */
                    html.dark .fi-topbar {
                        box-shadow: none !important;
                        filter: none !important;
                        background-color: #18181b !important;
                        border-bottom: 1px solid #3f3f46 !important;
                        height: 4rem !important;
                        min-height: 4rem !important;
                        max-height: 4rem !important;
                        position: fixed !important;
                        top: 0 !important;
                        left: 0 !important;
                        right: 0 !important;
                        z-index: 50 !important;
                        display: flex !important;
                        align-items: center !important;
                        padding: 0 1rem !important;
                        width: 100% !important;
                    }
                    html.dark .fi-topbar::after {
                        content: "" !important;
                        position: absolute !important;
                        bottom: -40px !important;
                        left: 0 !important;
                        right: 0 !important;
                        height: 40px !important;
                        background-image: url("data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1440 160%22 preserveAspectRatio=%22none%22%3E%3Cpath d=%22M0,30 C200,180 400,-20 720,40 C1000,100 1250,-10 1440,30 L1440,0 L0,0 Z%22 fill=%22%2318181b%22/%3E%3C/svg%3E") !important;
                        background-size: 100% 100% !important;
                        background-repeat: no-repeat !important;
                        z-index: -1 !important;
                        pointer-events: none !important;
                        filter: drop-shadow(0 4px 4px rgba(0,0,0,0.3)) !important;
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
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                            position: relative !important;
                        }

                        /* Hover Animation */
                        .fi-topbar .fi-topbar-item-btn:hover {
                            transform: translateY(-2px) !important;
                        }

                        /* Active State Animation */
                        .fi-topbar .fi-topbar-item.fi-active .fi-topbar-item-btn {
                            transform: translateY(-2px) scale(1.03) !important;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
                        }

                        .fi-topbar .fi-topbar-item-icon {
                            width: 1.25rem !important;
                            height: 1.25rem !important;
                            flex-shrink: 0 !important;
                        }

                    }

                    @media (max-width: 1023px) {
                        /* Mobile layout: Bottom navigation bar (Floating Pill) */
                        .fi-topbar .fi-topbar-nav-groups {
                            position: fixed !important;
                            bottom: 1.25rem !important;
                            left: 1rem !important;
                            right: 1rem !important;
                            top: auto !important;
                            width: calc(100% - 2rem) !important;
                            height: 4rem !important; /* Reduced from 4.5rem since no text */
                            background-color: #b91c1c !important; /* same red */
                            display: flex !important;
                            flex-direction: row !important;
                            justify-content: space-around !important;
                            align-items: center !important;
                            padding: 0 0.5rem !important;
                            z-index: 99999 !important; /* Extremely high z-index to stay on top of all page content */
                            pointer-events: auto !important; /* Ensure clicks always register */
                            border: 1px solid rgba(255, 255, 255, 0.15) !important;
                            box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
                            border-radius: 1.5rem !important;
                            margin: 0 !important;
                            list-style: none !important;
                            white-space: nowrap !important;
                            backdrop-filter: blur(8px) !important;
                        }

                        /* Mobile Sliding Indicator */
                        .mobile-magic-indicator {
                            position: absolute !important;
                            width: 3rem !important;
                            height: 3rem !important;
                            border-radius: 50% !important;
                            background-color: rgba(255, 255, 255, 0.25) !important;
                            z-index: 0 !important;
                            pointer-events: none !important;
                            top: 0.5rem !important; /* Vertically centered: (4rem - 3rem) / 2 */
                            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
                        }
                        html.dark .mobile-magic-indicator {
                            background-color: rgba(255, 255, 255, 0.15) !important;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
                        }

                        /* Dark mode bottom navigation */
                        html.dark .fi-topbar .fi-topbar-nav-groups {
                            background-color: rgba(24, 24, 27, 0.95) !important;
                            border: 1px solid #3f3f46 !important;
                            box-shadow: 0 10px 25px rgba(0,0,0,0.4) !important;
                        }

                        /* Add padding to page container only when the topbar navbar exists */
                        body:has(.fi-topbar) {
                            padding-bottom: 6.5rem !important;
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
                            padding: 0 !important;
                            width: 3.5rem !important;
                            height: 3.5rem !important;
                            border-radius: 50% !important;
                            box-sizing: border-box !important;
                            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                            pointer-events: auto !important;
                        }

                        /* Active State for Mobile - Only affect icon */
                        .fi-topbar .fi-topbar-item.fi-active .fi-topbar-item-btn {
                            background-color: transparent !important;
                            box-shadow: none !important;
                            transform: none !important;
                        }
                        html.dark .fi-topbar .fi-topbar-item.fi-active .fi-topbar-item-btn {
                            background-color: transparent !important;
                            box-shadow: none !important;
                        }

                        /* Set icon size for mobile */
                        .fi-topbar .fi-topbar-item-icon {
                            width: 1.4rem !important;
                            height: 1.4rem !important;
                            flex-shrink: 0 !important;
                            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), color 0.2s ease !important;
                        }

                        /* Icon grows when active */
                        .fi-topbar .fi-topbar-item.fi-active .fi-topbar-item-icon {
                            transform: scale(1.3) !important;
                            color: white !important;
                        }

                        /* Hide labels completely on mobile */
                        .fi-topbar .fi-topbar-item-label {
                            display: none !important;
                        }

                        /* Hide original body padding rule since we moved it above */
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
                        margin-right: 0.5rem !important;
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

                    /* Dark Mode (Basic Topbar Overrides Removed as they are merged above) */
                    html.dark .fi-topbar-nav-groups {
                        /* Background handled in media query */
                    }
                </style>'
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::BODY_START,
                fn (): string => '<div class="sales-global-bg"></div>'
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::BODY_END,
                fn (): string => '<script>
                    const initStatsAnimation = () => {
                        const statElements = document.querySelectorAll(".fi-wi-stats-overview-stat-value:not(.has-animated), .sales-stat-value:not(.has-animated)");
                        statElements.forEach(el => {
                            el.classList.add("has-animated");
                            const originalHTML = el.innerHTML;
                            const originalText = el.innerText.trim();
                            
                            const match = originalText.match(/^([^\d]*)((?:\d{1,3}(?:[.,]\d{3})*|\d+)(?:[.,]\d+)?)([^\d]*)$/);
                            if (match) {
                                const prefix = match[1];
                                const numberString = match[2];
                                const suffix = match[3];
                                
                                const isIndonesian = numberString.indexOf(".") !== -1 && (numberString.indexOf(",") === -1 || numberString.indexOf(".") < numberString.indexOf(","));
                                
                                let cleanNumberString = numberString;
                                if (isIndonesian) {
                                    cleanNumberString = cleanNumberString.replace(/\./g, "").replace(",", ".");
                                } else {
                                    cleanNumberString = cleanNumberString.replace(/,/g, "");
                                }
                                
                                const targetNumber = parseFloat(cleanNumberString);
                                
                                if (!isNaN(targetNumber) && targetNumber > 0) {
                                    const duration = 2000;
                                    const start = performance.now();
                                    
                                    const formatNumber = (num) => {
                                        if (isIndonesian) {
                                            return Math.floor(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                        } else {
                                            return Math.floor(num).toLocaleString("en-US");
                                        }
                                    };
                                    
                                    const update = (currentTime) => {
                                        const elapsed = currentTime - start;
                                        const progress = Math.min(elapsed / duration, 1);
                                        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                                        const currentNumber = targetNumber * easeOutQuart;
                                        
                                        el.innerText = prefix + formatNumber(currentNumber) + suffix;
                                        
                                        if (progress < 1) {
                                            requestAnimationFrame(update);
                                        } else {
                                            el.innerHTML = originalHTML;
                                        }
                                    };
                                    requestAnimationFrame(update);
                                }
                            }
                        });
                    };

                    const initMobileMagicIndicator = () => {
                        if (window.innerWidth >= 1024) return;
                        
                        const navGroups = document.querySelector(".fi-topbar-nav-groups");
                        if (!navGroups) return;

                        let indicator = document.getElementById("mobile-magic-indicator");
                        if (!indicator) {
                            indicator = document.createElement("div");
                            indicator.id = "mobile-magic-indicator";
                            indicator.className = "mobile-magic-indicator";
                            navGroups.appendChild(indicator);
                        }

                        const items = Array.from(navGroups.querySelectorAll(".fi-topbar-item"));
                        const activeItem = navGroups.querySelector(".fi-active");
                        
                        if (!activeItem) return;

                        const moveIndicator = (element, animate = true) => {
                            if (!animate) {
                                indicator.style.transition = "none";
                            } else {
                                indicator.style.transition = "left 0.25s cubic-bezier(0.4, 0, 0.2, 1)";
                            }
                            
                            const itemRect = element.getBoundingClientRect();
                            const navRect = navGroups.getBoundingClientRect();
                            const width = 48; // 3rem = 48px
                            const left = (itemRect.left - navRect.left) + (itemRect.width / 2) - (width / 2);
                            
                            indicator.style.left = left + "px";
                        };

                        // Snap immediately without animation on page load
                        moveIndicator(activeItem, false);
                        void indicator.offsetWidth;

                        items.forEach((item) => {
                            item.addEventListener("click", () => {
                                // Provide instant snappy feedback before page navigates
                                navGroups.querySelectorAll(".fi-active").forEach(el => el.classList.remove("fi-active"));
                                item.classList.add("fi-active");
                                moveIndicator(item, true);
                            });
                        });
                    };

                    document.addEventListener("DOMContentLoaded", () => {
                        setTimeout(initStatsAnimation, 100);
                        setTimeout(initMobileMagicIndicator, 100);
                    });
                    
                    document.addEventListener("livewire:navigated", () => {
                        setTimeout(initStatsAnimation, 100);
                        setTimeout(initMobileMagicIndicator, 100);
                    });
                    
                    window.addEventListener("resize", () => setTimeout(initMobileMagicIndicator, 100));
                    
                    const observer = new MutationObserver(() => {
                        if (document.querySelector(".fi-wi-stats-overview-stat-value:not(.has-animated), .sales-stat-value:not(.has-animated)")) {
                            initStatsAnimation();
                        }
                    });
                    observer.observe(document.body, { childList: true, subtree: true });
                </script>'
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
