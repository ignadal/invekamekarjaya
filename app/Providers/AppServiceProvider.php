<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Penjualan::observe(\App\Observers\PenjualanObserver::class);
        \App\Models\PembelianSupplierDetail::observe(\App\Observers\PembelianSupplierDetailObserver::class);

        \Filament\Support\Facades\FilamentIcon::register([
            'panels::sidebar.expand-button' => 'heroicon-o-bars-3',
            'panels::sidebar.collapse-button' => 'heroicon-o-bars-3',
        ]);
    }
}
