<?php

namespace App\Filament\Resources\PayrollSales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class PayrollSalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('tahun', 'desc')
            ->columns([
                Stack::make([
                    TextColumn::make('sales.nama_sales')
                        ->weight('bold')
                        ->size('lg')
                        ->icon('heroicon-m-user-circle')
                        ->iconColor('danger')
                        ->searchable(),
                    
                    TextColumn::make('periode')
                        ->getStateUsing(function ($record) {
                            $bulanArr = [
                                '1' => 'Januari', '2' => 'Februari', '3' => 'Maret',
                                '4' => 'April', '5' => 'Mei', '6' => 'Juni',
                                '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ];
                            $bulanStr = $bulanArr[$record->bulan] ?? $record->bulan;
                            return "Periode: {$bulanStr} {$record->tahun}";
                        })
                        ->color('gray')
                        ->size('sm'),

                    TextColumn::make('status_pembayaran')
                        ->badge()
                        ->color(fn ($state) => $state === 'sudah_digaji' ? 'success' : 'danger')
                        ->formatStateUsing(fn ($state) => $state === 'sudah_digaji' ? 'Lunas' : 'Belum Dibayar'),

                    TextColumn::make('total_gaji')
                        ->money('IDR')
                        ->weight('bold')
                        ->size('xl')
                        ->color('danger')
                        ->description(fn ($record) => 'Total Gaji Pokok & Tunjangan', position: 'above'),

                    TextColumn::make('gaji_pokok')
                        ->money('IDR')
                        ->label('Gaji Pokok & Bonus')
                        ->getStateUsing(fn ($record) => $record->gaji_pokok + $record->bonus_nominal)
                        ->color('gray')
                        ->size('sm')
                        ->icon('heroicon-o-banknotes'),

                    TextColumn::make('tunjangan')
                        ->money('IDR')
                        ->label('Tunjangan Bensin & Makan')
                        ->getStateUsing(fn ($record) => $record->uang_bensin + $record->uang_makan)
                        ->color('gray')
                        ->size('sm')
                        ->icon('heroicon-o-truck'),
                ])->space(3)
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '1' => 'Januari', '2' => 'Februari', '3' => 'Maret',
                        '4' => 'April', '5' => 'Mei', '6' => 'Juni',
                        '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
                        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                    ])
                    ->default((string) now()->month),
                \Filament\Tables\Filters\SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(function () {
                        $tahunList = \App\Models\PayrollSales::select('tahun')
                            ->distinct()
                            ->orderBy('tahun', 'desc')
                            ->pluck('tahun', 'tahun')
                            ->toArray();
                        return $tahunList ?: [now()->year => now()->year];
                    })
                    ->default((string) now()->year),
            ])
            ->recordActions([
                Action::make('tambah_tunjangan')
                    ->label('Tunjangan')
                    ->icon('heroicon-o-plus')
                    ->color('danger')
                    ->button()
                    ->modalSubmitActionLabel('Kirim')
                    ->extraAttributes(['style' => 'flex: 1 1 30%; justify-content: center;'])
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('tanggal')
                            ->label('Tambah Tanggal Baru (Catat Hari Baru)')
                            ->minDate(fn ($record) => \Carbon\Carbon::create($record->tahun, $record->bulan, 1)->startOfMonth())
                            ->maxDate(function ($record) {
                                $endOfMonth = \Carbon\Carbon::create($record->tahun, $record->bulan, 1)->endOfMonth();
                                $today = now();
                                return $endOfMonth->min($today);
                            })
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('uang_makan_harian')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('uang_bensin_harian')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $tanggalBaru = $data['tanggal'];
                        $uangMakanHarian = $data['uang_makan_harian'];
                        $uangBensinHarian = $data['uang_bensin_harian'];
                        
                        $tanggalKehadiran = $record->tanggal_kehadiran ?? [];
                        
                        // Konversi semua format lama ke string tanggal Y-m-d
                        $tanggalKehadiran = array_map(function ($item) use ($record) {
                            if (is_array($item)) {
                                return $item['tanggal'] ?? null;
                            }
                            if (is_numeric($item)) {
                                return \Carbon\Carbon::create($record->tahun, $record->bulan, (int)$item)->toDateString();
                            }
                            return $item;
                        }, $tanggalKehadiran);
                        $tanggalKehadiran = array_filter($tanggalKehadiran);
                        
                        if (!in_array($tanggalBaru, $tanggalKehadiran)) {
                            $tanggalKehadiran[] = $tanggalBaru;
                        }
                        
                        // Mapped to objects with new daily rates
                        $finalDates = [];
                        foreach ($tanggalKehadiran as $d) {
                            if ($d) {
                                $finalDates[] = [
                                    'tanggal' => $d,
                                    'uang_makan' => (int)$uangMakanHarian,
                                    'uang_bensin' => (int)$uangBensinHarian,
                                ];
                            }
                        }
                        
                        $finalDates = array_values($finalDates);
                        $hariKerja = count($finalDates);
                        
                        $uangMakan = $hariKerja * $uangMakanHarian;
                        $uangBensin = $hariKerja * $uangBensinHarian;
                        $totalGaji = $record->gaji_pokok + $record->bonus_nominal + $uangMakan + $uangBensin;
                        
                        $record->update([
                            'tanggal_kehadiran' => $finalDates,
                            'hari_kerja' => $hariKerja,
                            'uang_makan_harian' => $uangMakanHarian,
                            'uang_bensin_harian' => $uangBensinHarian,
                            'uang_makan' => $uangMakan,
                            'uang_bensin' => $uangBensin,
                            'total_gaji' => $totalGaji,
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Tunjangan berhasil ditambahkan')
                            ->success()
                            ->send();
                    }),

                Action::make('bayar')
                    ->label('Bayar')
                    ->icon('heroicon-o-check-circle')
                    ->color('danger')
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 30%; justify-content: center;'])
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pembayaran Gaji')
                    ->modalDescription('Apakah Anda yakin ingin menandai gaji ini sebagai Lunas?')
                    ->modalSubmitActionLabel('Ya')
                    ->modalCancelActionLabel('Cancel')
                    ->action(function ($record) {
                        $record->update(['status_pembayaran' => 'sudah_digaji']);
                    })
                    ->visible(function ($record) {
                        if ($record->status_pembayaran !== 'belum') {
                            return false;
                        }
                        $tanggalGajian = \Carbon\Carbon::create($record->tahun, $record->bulan, 28)->startOfDay();
                        return now()->greaterThanOrEqualTo($tanggalGajian);
                    }),
                    
                ActionGroup::make([
                    EditAction::make()->color('gray'),
                    Action::make('riwayat_tunjangan')
                        ->label('Riwayat Tunjangan')
                        ->icon('heroicon-o-clock')
                        ->color('gray')
                        ->modalSubmitActionLabel('Simpan')
                        ->form([
                            \Filament\Forms\Components\Repeater::make('tanggal_kehadiran')
                                ->label('Daftar Tanggal Kehadiran & Tunjangan')
                                ->schema([
                                    \Filament\Forms\Components\DatePicker::make('tanggal')
                                        ->label('Tanggal')
                                        ->readOnly(),
                                    \Filament\Forms\Components\TextInput::make('uang_makan')
                                        ->label('Uang Makan')
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->readOnly(),
                                    \Filament\Forms\Components\TextInput::make('uang_bensin')
                                        ->label('Uang Bensin')
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->readOnly(),
                                ])
                                ->columns(3)
                                ->addable(false)
                                ->deletable()
                                ->reorderable(false)
                                ->default(function ($record) {
                                    $data = $record->tanggal_kehadiran ?? [];
                                    return array_map(function ($item) use ($record) {
                                        $dateStr = null;
                                        $makan = $record->uang_makan_harian ?? 0;
                                        $bensin = $record->uang_bensin_harian ?? 0;
                                        
                                        if (is_array($item)) {
                                            $dateStr = $item['tanggal'] ?? null;
                                            $makan = $item['uang_makan'] ?? $makan;
                                            $bensin = $item['uang_bensin'] ?? $bensin;
                                        } elseif (is_numeric($item)) {
                                            $dateStr = \Carbon\Carbon::create($record->tahun, $record->bulan, (int)$item)->toDateString();
                                        } else {
                                            $dateStr = $item;
                                        }
                                        
                                        return [
                                            'tanggal' => $dateStr,
                                            'uang_makan' => $makan,
                                            'uang_bensin' => $bensin,
                                        ];
                                    }, $data);
                                })
                                ->deleteAction(
                                    fn ($action) => $action
                                        ->requiresConfirmation()
                                        ->modalHeading('Hapus Tanggal Kehadiran')
                                        ->modalDescription('Apakah Anda yakin ingin menghapus tanggal ini dari riwayat?')
                                        ->modalSubmitActionLabel('Ya, Hapus')
                                        ->modalCancelActionLabel('Batal')
                                ),
                        ])
                        ->action(function ($record, array $data) {
                            $repeaterDates = $data['tanggal_kehadiran'] ?? [];
                            $tanggalKehadiran = [];
                            foreach ($repeaterDates as $item) {
                                $dateStr = $item['tanggal'] ?? null;
                                if ($dateStr) {
                                    $tanggalKehadiran[] = [
                                        'tanggal' => $dateStr,
                                        'uang_makan' => (int)($item['uang_makan'] ?? $record->uang_makan_harian ?? 0),
                                        'uang_bensin' => (int)($item['uang_bensin'] ?? $record->uang_bensin_harian ?? 0),
                                    ];
                                }
                            }
                            
                            $tanggalKehadiran = array_values($tanggalKehadiran);
                            $hariKerja = count($tanggalKehadiran);
                            
                            $uangMakan = $hariKerja * $record->uang_makan_harian;
                            $uangBensin = $hariKerja * $record->uang_bensin_harian;
                            $totalGaji = $record->gaji_pokok + $record->bonus_nominal + $uangMakan + $uangBensin;
                            
                            $record->update([
                                'tanggal_kehadiran' => $tanggalKehadiran,
                                'hari_kerja' => $hariKerja,
                                'uang_makan' => $uangMakan,
                                'uang_bensin' => $uangBensin,
                                'total_gaji' => $totalGaji,
                            ]);

                            \Filament\Notifications\Notification::make()
                                ->title('Riwayat tunjangan berhasil disimpan')
                                ->success()
                                ->send();
                        }),
                ])->icon('heroicon-m-ellipsis-vertical')
            ]);
            // ->bulkActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ]);
    }
}
