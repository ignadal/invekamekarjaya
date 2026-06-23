<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\DashboardFilterWidget::class,
            \App\Filament\Widgets\DashboardStatsOverview::class,
            \App\Filament\Widgets\LabaChart::class,
            \App\Filament\Widgets\PengeluaranChart::class,
            \App\Filament\Widgets\PenjualanChart::class,
            \App\Filament\Widgets\TopSalesWidget::class,
        ];
    }

    public function getMaxContentWidth(): \Filament\Support\Enums\Width | string | null
    {
        return 'full';
    }
}
