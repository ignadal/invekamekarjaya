<?php

namespace App\Filament\Resources\Penjualans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PenjualansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_beli')
                    ->date()
                    ->sortable(),
                TextColumn::make('sales.nama_sales')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('buyer.nama_toko')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sudah_dibayar')
                    ->formatStateUsing(fn ($state, $record) => $record->metode === 'lunas' ? 'Bayar Lunas' : 'Rp ' . number_format($state ?? 0, 0, ',', '.')),
                TextColumn::make('sisa_pembayaran')
                    ->formatStateUsing(fn ($state, $record) => $record->metode === 'lunas' ? '-' : 'Rp ' . number_format($state ?? 0, 0, ',', '.')),
                TextColumn::make('total_penjualan')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status_bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'lunas' => 'success',
                        'sebagian' => 'warning',
                        'belum_dibayar' => 'danger',
                    }),
                TextColumn::make('status_persetujuan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->iconButton()
                    ->tooltip('Approve Penjualan')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status_persetujuan === 'pending')
                    ->action(function ($record) {
                        $record->update(['status_persetujuan' => 'disetujui']);
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->iconButton()
                    ->tooltip('Tolak Penjualan')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status_persetujuan === 'pending')
                    ->action(function ($record) {
                        $record->update(['status_persetujuan' => 'ditolak']);
                    }),
                Action::make('cicil')
                    ->label('Bayar Cicilan')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->iconButton()
                    ->tooltip('Bayar Cicilan')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('tanggal_bayar')
                            ->required()
                            ->default(now())
                            ->disabled()
                            ->dehydrated(),
                        \Filament\Forms\Components\TextInput::make('nominal')
                            ->numeric()
                            ->required()
                            ->maxValue(fn ($record) => $record->sisa_pembayaran),
                        \Filament\Forms\Components\Textarea::make('catatan'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->cicilans()->create([
                            'tanggal_bayar' => $data['tanggal_bayar'],
                            'nominal' => $data['nominal'],
                            'catatan' => $data['catatan'],
                        ]);
                        
                        $sudahDibayarBaru = $record->sudah_dibayar + $data['nominal'];
                        $sisaPembayaranBaru = $record->total_penjualan - $sudahDibayarBaru;
                        $status = 'belum_dibayar';
                        if ($sudahDibayarBaru >= $record->total_penjualan) {
                            $status = 'lunas';
                        } elseif ($sudahDibayarBaru > 0) {
                            $status = 'sebagian';
                        }
                        
                        $record->update([
                            'sudah_dibayar' => $sudahDibayarBaru,
                            'sisa_pembayaran' => $sisaPembayaranBaru,
                            'status_bayar' => $status,
                        ]);
                    })
                    ->visible(fn ($record) => $record->metode === 'cicil' && $record->sisa_pembayaran > 0),
                Action::make('riwayat_cicilan')
                    ->label('Riwayat Cicilan')
                    ->icon('heroicon-o-clock')
                    ->color('info')
                    ->iconButton()
                    ->tooltip('Riwayat Cicilan')
                    ->infolist([
                        \Filament\Infolists\Components\RepeatableEntry::make('cicilans')
                            ->label('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('tanggal_bayar')->date('d M Y'),
                                \Filament\Infolists\Components\TextEntry::make('nominal')->money('IDR'),
                                \Filament\Infolists\Components\TextEntry::make('catatan'),
                            ])
                            ->columns(3)
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn ($record) => $record->metode === 'cicil' && $record->cicilans()->exists()),
                Action::make('detail_barang')
                    ->label('Detail Barang')
                    ->icon('heroicon-o-shopping-bag')
                    ->color('secondary')
                    ->iconButton()
                    ->tooltip('Detail Barang')
                    ->infolist([
                        \Filament\Infolists\Components\RepeatableEntry::make('details')
                            ->label('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('barang.nama_barang')->label('Barang'),
                                \Filament\Infolists\Components\TextEntry::make('qty')->label('Qty'),
                                \Filament\Infolists\Components\TextEntry::make('harga_jual')->money('IDR')->label('Harga Satuan'),
                                \Filament\Infolists\Components\TextEntry::make('subtotal')->money('IDR')->label('Subtotal'),
                            ])
                            ->columns(4)
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
                EditAction::make()->iconButton()->tooltip('Edit'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
