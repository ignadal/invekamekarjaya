<?php

namespace App\Filament\Sales\Widgets;

use Livewire\Attributes\On;
use Filament\Widgets\Widget;

class SalesDashboardFilterWidget extends Widget
{
    protected static ?int $sort = 0;

    protected string $view = 'filament.sales.widgets.sales-dashboard-filter-widget';

    protected int|string|array $columnSpan = 'full';

    public ?string $bulan = '';
    public ?string $tahun = '';

    public function getTahunOptions(): array
    {
        $years = [];
        for ($i = (int) date('Y'); $i >= 2020; $i--) {
            $years[$i] = (string) $i;
        }
        return $years;
    }

    public function getBulanOptions(): array
    {
        return [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    public function resetFilter(): void
    {
        $this->bulan = '';
        $this->tahun = '';

        $this->dispatch(
            'sales-dashboard-filter-changed',
            bulan: null,
            tahun: null,
        );
    }

    public function updated(): void
    {
        $this->dispatch(
            'sales-dashboard-filter-changed',
            bulan: $this->bulan ?: null,
            tahun: $this->tahun ?: null,
        );
    }
}
