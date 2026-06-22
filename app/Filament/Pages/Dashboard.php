<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $form): Schema
    {
        $currentMonth = (int) now()->month;
        $currentYear = (int) now()->year;

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
        }

        $years = [];
        for ($i = $currentYear - 4; $i <= $currentYear; $i++) {
            $years[$i] = (string) $i;
        }

        return $form
            ->columns(1)
            ->schema([
                \Filament\Schemas\Components\Section::make('Filter')
                    ->description('Filter data berdasarkan periode')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)->schema([
                            Select::make('bulan')
                                ->label('Bulan')
                                ->options($months)
                                ->default($currentMonth)
                                ->selectablePlaceholder(false),
                            Select::make('tahun')
                                ->label('Tahun')
                                ->options($years)
                                ->default($currentYear)
                                ->selectablePlaceholder(false),
                        ])
                    ])
                    ->extraAttributes(['class' => 'red-gradient-filter w-full']),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\DashboardStatsOverview::class,
            \App\Filament\Widgets\LabaChart::class,
            \App\Filament\Widgets\PengeluaranChart::class,
            \App\Filament\Widgets\PenjualanChart::class,
        ];
    }

    public function getFiltersFormContentComponent(): \Filament\Schemas\Components\Component
    {
        return \Filament\Schemas\Components\EmbeddedSchema::make('filtersForm')
            ->columnSpan('full');
    }

    public function updated($property): void
    {
        if (str_starts_with($property, 'filters')) {
            $this->dispatch('dashboard-filter-changed',
                bulan: $this->filters['bulan'] ?? null,
                tahun: $this->filters['tahun'] ?? null,
            );
        }
    }

    public function getMaxContentWidth(): \Filament\Support\Enums\Width | string | null
    {
        return 'full';
    }
}
