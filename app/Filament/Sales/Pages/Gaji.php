<?php

namespace App\Filament\Sales\Pages;

use Filament\Pages\Page;

class Gaji extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-wallet';

    protected string $view = 'filament.sales.pages.gaji';
    
    protected static ?string $navigationLabel = 'Gaji & Insentif';
    
    protected static ?string $title = 'Informasi Gaji & Insentif';
    
    protected static ?int $navigationSort = 4;

    public $activeTab = 'gaji_pokok';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    protected function getViewData(): array
    {
        $sales = \App\Models\Sales::where('user_id', auth()->id())->first();
        
        // Fallback khusus untuk superadmin yang sedang melakukan testing
        if (!$sales && auth()->user()->name === 'superadmin') {
            $sales = \App\Models\Sales::first();
        }

        $payrollData = [];
        if ($sales) {
            // Get all payrolls for the sales person, ordered by newest
            $payrollData = \App\Models\PayrollSales::where('sales_id', $sales->id)
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        }

        return [
            'sales' => $sales,
            'payrollData' => $payrollData
        ];
    }
}
