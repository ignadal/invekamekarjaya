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
                //
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
                        \Filament\Forms\Components\TextInput::make('uang_makan')
                            ->numeric()
                            ->default(fn ($record) => $record->uang_makan)
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('uang_bensin')
                            ->numeric()
                            ->default(fn ($record) => $record->uang_bensin)
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $uangMakan = $data['uang_makan'];
                        $uangBensin = $data['uang_bensin'];
                        $totalGaji = $record->gaji_pokok + $record->bonus_nominal + $uangMakan + $uangBensin;
                        
                        $record->update([
                            'uang_makan' => $uangMakan,
                            'uang_bensin' => $uangBensin,
                            'total_gaji' => $totalGaji,
                        ]);
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
                ])->icon('heroicon-m-ellipsis-vertical')
            ]);
            // ->bulkActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ]);
    }
}
