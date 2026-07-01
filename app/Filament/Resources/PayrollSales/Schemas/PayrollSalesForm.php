<?php

namespace App\Filament\Resources\PayrollSales\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Penjualan;
use App\Models\Sales;

class PayrollSalesForm
{
    public static function configure(Schema $schema): Schema
    {
        $calculateGaji = function (Get $get, Set $set) {
            $salesId = $get('sales_id');
            $bulan = $get('bulan');
            $tahun = $get('tahun');

            if ($salesId && $bulan && $tahun) {
                $totalPenjualan = \App\Models\CicilanBuyer::whereHas('penjualan', function ($query) use ($salesId) {
                        $query->where('sales_id', $salesId);
                    })
                    ->whereMonth('tanggal_bayar', $bulan)
                    ->whereYear('tanggal_bayar', $tahun)
                    ->sum('nominal');
                
                $set('total_penjualan', $totalPenjualan);

                $bonusPersen = 0;
                if ($totalPenjualan >= 100000000) {
                    $bonusPersen = 1;
                } elseif ($totalPenjualan >= 75000000) {
                    $bonusPersen = 0.5;
                }
                
                $set('bonus_persen', $bonusPersen);
                $bonusNominal = ($totalPenjualan * $bonusPersen) / 100;
                $set('bonus_nominal', $bonusNominal);

                $sales = Sales::find($salesId);
                $gajiPokok = $sales ? $sales->gaji_pokok : 0;
                $set('gaji_pokok', $gajiPokok);
            }

            $uangMakan = (float) $get('uang_makan');
            $uangBensin = (float) $get('uang_bensin');

            $gajiPokok = (float) $get('gaji_pokok');
            $bonusNominal = (float) $get('bonus_nominal');

            $totalGaji = $gajiPokok + $bonusNominal + $uangMakan + $uangBensin;
            $set('total_gaji', $totalGaji);
        };

        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Pemilihan Sales & Periode')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                Select::make('sales_id')
                                    ->relationship('sales', 'nama_sales', modifyQueryUsing: function (\Illuminate\Database\Eloquent\Builder $query, $get, ?\Illuminate\Database\Eloquent\Model $record) {
                                        $bulan = $get('bulan') ?? now()->month;
                                        $tahun = $get('tahun') ?? now()->year;
                                        
                                        $query->where(function ($q) use ($bulan, $tahun, $record) {
                                            // Disabled temporarily to show all sales
                                            // $q->whereDoesntHave('payrollSales', function ($q2) use ($bulan, $tahun) {
                                            //     $q2->where('bulan', $bulan)
                                            //       ->where('tahun', $tahun);
                                            // });
                                            if ($record) {
                                                $q->orWhere('id', $record->sales_id);
                                            }
                                        });

                                    })
                                    ->unique(modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule, $get) {
                                        return $rule
                                            ->where('bulan', $get('bulan') ?? now()->month)
                                            ->where('tahun', $get('tahun') ?? now()->year);
                                    }, ignoreRecord: true)
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated($calculateGaji),
                                
                                Select::make('bulan')
                                    ->options([
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
                                    ])
                                    ->required()
                                    ->default(now()->month)
                                    ->disabled()
                                    ->dehydrated(),

                                TextInput::make('tahun')
                                    ->numeric()
                                    ->required()
                                    ->default(now()->year)
                                    ->disabled()
                                    ->dehydrated(),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Rincian Gaji & Bonus')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('gaji_pokok')
                                    ->numeric()
                                    ->readOnly()
                                    ->default(0)
                                    ->prefix('Rp')
                                    ->dehydrated(),

                                TextInput::make('total_penjualan')
                                    ->label('Total Penagihan')
                                    ->numeric()
                                    ->readOnly()
                                    ->default(0)
                                    ->prefix('Rp')
                                    ->dehydrated(),

                                TextInput::make('bonus_persen')
                                    ->numeric()
                                    ->readOnly()
                                    ->default(0)
                                    ->suffix('%')
                                    ->dehydrated(),

                                TextInput::make('bonus_nominal')
                                    ->numeric()
                                    ->readOnly()
                                    ->default(0)
                                    ->prefix('Rp')
                                    ->dehydrated(),

                                TextInput::make('hari_kerja')
                                    ->numeric()
                                    ->default(0)
                                    ->readOnly()
                                    ->suffix('Hari')
                                    ->dehydrated(),

                                TextInput::make('uang_makan')
                                    ->label('Total Uang Makan')
                                    ->numeric()
                                    ->readOnly()
                                    ->default(0)
                                    ->prefix('Rp')
                                    ->dehydrated(),

                                TextInput::make('uang_bensin')
                                    ->label('Total Uang Bensin')
                                    ->numeric()
                                    ->readOnly()
                                    ->default(0)
                                    ->prefix('Rp')
                                    ->dehydrated(),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Total Gaji Diterima')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                TextInput::make('total_gaji')
                                    ->numeric()
                                    ->readOnly()
                                    ->default(0)
                                    ->prefix('Rp')
                                    ->dehydrated()
                                    ->extraInputAttributes(['style' => 'font-weight: bold; font-size: 1.25rem;']),
                            ]),
                    ]),
            ]);
    }
}
