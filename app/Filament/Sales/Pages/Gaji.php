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
    public $filterBulan = '';
    public $filterTahun = '';

    public function mount()
    {
        $this->filterBulan = (string) now()->month;
        $this->filterTahun = (string) now()->year;
    }

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
        $tahunList = [];
        if ($sales) {
            $payrollQuery = \App\Models\PayrollSales::where('sales_id', $sales->id);
            
            $tahunList = \App\Models\PayrollSales::where('sales_id', $sales->id)
                ->select('tahun')
                ->distinct()
                ->orderBy('tahun', 'desc')
                ->pluck('tahun')
                ->toArray();
                
            if ($this->filterBulan) {
                $payrollQuery->where('bulan', $this->filterBulan);
            }
            if ($this->filterTahun) {
                $payrollQuery->where('tahun', $this->filterTahun);
            }
            
            $payrollData = $payrollQuery->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        }

        return [
            'sales' => $sales,
            'payrollData' => $payrollData,
            'tahunList' => $tahunList ?: [now()->year]
        ];
    }
}
