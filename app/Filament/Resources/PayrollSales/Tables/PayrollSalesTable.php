<?php

namespace App\Filament\Resources\PayrollSales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PayrollSalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sales.nama_sales')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bulan')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
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
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('tahun')
                    ->sortable(),
                TextColumn::make('total_gaji')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sudah_digaji' => 'success',
                        'belum' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sudah_digaji' => 'Sudah Digaji',
                        'belum' => 'Belum',
                        default => $state,
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('tambah_tunjangan')
                    ->label('Tambah Bensin & Makan')
                    ->icon('heroicon-o-plus-circle')
                    ->color('warning')
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
                \Filament\Actions\ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                Action::make('bayar')
                    ->label('Bayar Gaji')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
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
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
