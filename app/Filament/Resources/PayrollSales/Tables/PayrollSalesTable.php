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
            ->heading(function (\Livewire\Component $livewire) {
                $bulanArr = [
                    '1' => 'Januari', '2' => 'Februari', '3' => 'Maret',
                    '4' => 'April', '5' => 'Mei', '6' => 'Juni',
                    '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                ];
                
                $filters = $livewire->tableFilters ?? [];
                $bulan = $filters['bulan']['value'] ?? now()->month;
                $tahun = $filters['tahun']['value'] ?? now()->year;
                
                $bulanStr = $bulanArr[$bulan] ?? $bulan;
                
                return "Gaji Bulan {$bulanStr} {$tahun}";
            })
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
                    ->default((string) now()->month)
                    ->selectablePlaceholder(false)
                    ->indicateUsing(fn () => null),
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
                    ->default((string) now()->year)
                    ->selectablePlaceholder(false)
                    ->indicateUsing(fn () => null),
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
                    ->visible(fn ($record) => $record->status_pembayaran === 'belum')
                    ->action(function ($record, array $data) {
                        $tanggalBaru = $data['tanggal'];
                        $uangMakanBaru = $data['uang_makan_harian'];
                        $uangBensinBaru = $data['uang_bensin_harian'];
                        
                        $tanggalKehadiranAsli = $record->tanggal_kehadiran ?? [];
                        $finalDates = [];
                        $found = false;
                        
                        $totalUangMakanList = 0;
                        $totalUangBensinList = 0;
                        
                        foreach ($tanggalKehadiranAsli as $item) {
                            $dateStr = null;
                            $makan = $record->uang_makan_harian ?? 0;
                            $bensin = $record->uang_bensin_harian ?? 0;
                            
                            if (is_array($item)) {
                                $dateStr = $item['tanggal'] ?? null;
                                $makan = (int)($item['uang_makan'] ?? $makan);
                                $bensin = (int)($item['uang_bensin'] ?? $bensin);
                            } elseif (is_numeric($item)) {
                                $dateStr = \Carbon\Carbon::create($record->tahun, $record->bulan, (int)$item)->toDateString();
                            } else {
                                $dateStr = $item;
                            }
                            
                            if ($dateStr) {
                                if ($dateStr === $tanggalBaru) {
                                    $found = true;
                                    $makan = (int)$uangMakanBaru;
                                    $bensin = (int)$uangBensinBaru;
                                }
                                
                                $finalDates[] = [
                                    'tanggal' => $dateStr,
                                    'uang_makan' => $makan,
                                    'uang_bensin' => $bensin,
                                ];
                                $totalUangMakanList += $makan;
                                $totalUangBensinList += $bensin;
                            }
                        }
                        
                        if (!$found) {
                            $finalDates[] = [
                                'tanggal' => $tanggalBaru,
                                'uang_makan' => (int)$uangMakanBaru,
                                'uang_bensin' => (int)$uangBensinBaru,
                            ];
                            $totalUangMakanList += (int)$uangMakanBaru;
                            $totalUangBensinList += (int)$uangBensinBaru;
                        }
                        
                        // Sort array by date string
                        usort($finalDates, function ($a, $b) {
                            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
                        });
                        
                        $hariKerja = count($finalDates);
                        $uangMakan = $totalUangMakanList;
                        $uangBensin = $totalUangBensinList;
                        $totalGaji = $record->gaji_pokok + $record->bonus_nominal + $uangMakan + $uangBensin;
                        
                        $record->update([
                            'tanggal_kehadiran' => $finalDates,
                            'hari_kerja' => $hariKerja,
                            'uang_makan_harian' => (int)$uangMakanBaru,
                            'uang_bensin_harian' => (int)$uangBensinBaru,
                            'uang_makan' => $uangMakan,
                            'uang_bensin' => $uangBensin,
                            'total_gaji' => $totalGaji,
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Tunjangan berhasil ditambahkan')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status_pembayaran === 'belum'),

                Action::make('bayar')
                    ->label('Bayar')
                    ->icon('heroicon-o-check-circle')
                    ->outlined()
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
                    
                Action::make('lihat_riwayat_tunjangan')
                    ->label('Riwayat Tunjangan')
                    ->icon('heroicon-o-clock')
                    ->color('danger')
                    ->button()
                    ->outlined()
                    ->extraAttributes(['style' => 'flex: 1 1 30%; justify-content: center;'])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->fillForm(function ($record) {
                        $data = $record->tanggal_kehadiran ?? [];
                        $mapped = array_map(function ($item) use ($record) {
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
                        return ['tanggal_kehadiran' => $mapped];
                    })
                    ->form([
                        \Filament\Forms\Components\Repeater::make('tanggal_kehadiran')
                            ->disabled()
                            ->label('Daftar Tanggal Kehadiran & Tunjangan')
                            ->schema([
                                \Filament\Forms\Components\DatePicker::make('tanggal')->label('Tanggal')->readOnly(),
                                \Filament\Forms\Components\TextInput::make('uang_makan')->label('Uang Makan')->prefix('Rp')->numeric()->readOnly(),
                                \Filament\Forms\Components\TextInput::make('uang_bensin')->label('Uang Bensin')->prefix('Rp')->numeric()->readOnly(),
                            ])
                            ->columns(3)
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                    ])
                    ->visible(fn ($record) => $record->status_pembayaran === 'sudah_digaji'),
                    
                ActionGroup::make([
                    Action::make('riwayat_tunjangan')
                        ->label('Riwayat Tunjangan')
                        ->icon('heroicon-o-clock')
                        ->color('gray')
                        ->fillForm(function ($record) {
                            $data = $record->tanggal_kehadiran ?? [];
                            $mapped = array_map(function ($item) use ($record) {
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
                            return ['tanggal_kehadiran' => $mapped];
                        })
                        ->form([
                            \Filament\Forms\Components\Repeater::make('tanggal_kehadiran')
                                ->disabled(fn ($record) => $record && $record->status_pembayaran !== 'belum')
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
                            if ($record->status_pembayaran !== 'belum') {
                                return; // Do not save if already paid
                            }
                            $repeaterDates = $data['tanggal_kehadiran'] ?? [];
                            $tanggalKehadiran = [];
                            $totalUangMakanList = 0;
                            $totalUangBensinList = 0;
                            
                            foreach ($repeaterDates as $item) {
                                $dateStr = $item['tanggal'] ?? null;
                                if ($dateStr) {
                                    $makan = (int)($item['uang_makan'] ?? $record->uang_makan_harian ?? 0);
                                    $bensin = (int)($item['uang_bensin'] ?? $record->uang_bensin_harian ?? 0);
                                    
                                    $tanggalKehadiran[] = [
                                        'tanggal' => $dateStr,
                                        'uang_makan' => $makan,
                                        'uang_bensin' => $bensin,
                                    ];
                                    $totalUangMakanList += $makan;
                                    $totalUangBensinList += $bensin;
                                }
                            }
                            
                            $tanggalKehadiran = array_values($tanggalKehadiran);
                            $hariKerja = count($tanggalKehadiran);
                            
                            $uangMakan = $totalUangMakanList;
                            $uangBensin = $totalUangBensinList;
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
                        
                        EditAction::make()->color('gray')->visible(fn ($record) => $record->status_pembayaran === 'belum'),
                        \Filament\Actions\DeleteAction::make()->requiresConfirmation()->visible(fn ($record) => $record->status_pembayaran === 'belum'),
                ])->icon('heroicon-m-ellipsis-vertical')
                ->visible(fn ($record) => $record->status_pembayaran === 'belum')
            ]);
            // ->bulkActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ]);
    }
}
