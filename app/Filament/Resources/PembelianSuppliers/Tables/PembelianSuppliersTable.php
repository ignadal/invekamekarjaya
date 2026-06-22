<?php

namespace App\Filament\Resources\PembelianSuppliers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PembelianSuppliersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_pembelian')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('supplier.nama_supplier')
                    ->label('Supplier')
                    ->searchable(),

                TextColumn::make('metode')
                    ->badge(),

                TextColumn::make('sudah_dibayar')
                    ->formatStateUsing(fn ($state, $record) => $record->metode === 'lunas' ? 'Bayar Lunas' : 'Rp ' . number_format($state ?? 0, 0, ',', '.')),

                TextColumn::make('sisa_pembayaran')
                    ->formatStateUsing(fn ($state, $record) => $record->metode === 'lunas' ? '-' : 'Rp ' . number_format($state ?? 0, 0, ',', '.')),

                TextColumn::make('total_pembelian')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(function (string $state, $record) {
                        if ($record->metode === 'lunas') return 'Lunas';
                        if ($state !== 'lunas' && $record->jatuh_tempo && \Carbon\Carbon::parse($record->jatuh_tempo)->startOfDay()->isBefore(now()->startOfDay())) {
                            return 'Telat Bayar';
                        }
                        return ucwords(str_replace('_', ' ', $state));
                    })
                    ->color(function (string $state, $record) {
                        if ($record->metode === 'lunas') return 'success';
                        if ($state !== 'lunas' && $record->jatuh_tempo && \Carbon\Carbon::parse($record->jatuh_tempo)->startOfDay()->isBefore(now()->startOfDay())) {
                            return 'danger';
                        }
                        return match ($state) {
                            'lunas' => 'success',
                            'sebagian' => 'warning',
                            'belum_dibayar' => 'danger',
                            default => 'gray',
                        };
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\Action::make('cicil')
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
                        $sisaPembayaranBaru = $record->total_pembelian - $sudahDibayarBaru;
                        $status = 'belum_dibayar';
                        if ($sudahDibayarBaru >= $record->total_pembelian) {
                            $status = 'lunas';
                        } elseif ($sudahDibayarBaru > 0) {
                            $status = 'sebagian';
                        }
                        
                        $record->update([
                            'sudah_dibayar' => $sudahDibayarBaru,
                            'sisa_pembayaran' => $sisaPembayaranBaru,
                            'status' => $status,
                        ]);
                    })
                    ->visible(fn ($record) => $record->metode === 'nyicil' && $record->sisa_pembayaran > 0),
                \Filament\Actions\Action::make('riwayat_cicilan')
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
                    ->visible(fn ($record) => $record->metode === 'nyicil' && $record->cicilans()->exists()),
                \Filament\Actions\Action::make('detail_barang')
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
                                \Filament\Infolists\Components\TextEntry::make('harga_beli')->money('IDR')->label('Harga Satuan'),
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
