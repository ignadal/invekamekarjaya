<?php

namespace App\Filament\Resources\Penjualans\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;

class PenjualansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 2,
            ])
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 20, 50])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(fn ($query) => $query->orderByRaw("
                CASE 
                    WHEN status_persetujuan = 'pending' THEN 1
                    WHEN metode = 'cicil' AND status_bayar IN ('belum_dibayar', 'sebagian') THEN 2
                    ELSE 3
                END ASC
            ")->orderBy('created_at', 'desc'))
            ->columns([
                Stack::make([
                    ImageColumn::make('foto_nota')
                        ->disk('public')
                        ->alignment('center')
                        ->extraAttributes(['class' => 'custom-rect-wrapper'])
                        ->extraImgAttributes(['class' => 'w-full object-cover rounded-t-xl'])
                        ->defaultImageUrl(url('/images/no-nota.png')),

                    Stack::make([
                        TextColumn::make('status_persetujuan')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                            })
                            ->alignEnd(),
                    ])->alignment('end'),

                    TextColumn::make('buyer.nama_toko')
                        ->formatStateUsing(fn ($record) => "{$record->buyer->nama_toko} - " . ($record->buyer->kecamatan->nama_kecamatan ?? ''))
                        ->weight('bold')
                        ->size('lg')
                        ->icon('heroicon-m-building-storefront')
                        ->iconColor('danger')
                        ->searchable()
                        ->sortable(),

                    Split::make([
                        Stack::make([
                            TextColumn::make('tanggal_beli')
                                ->date('d M Y')
                                ->icon('heroicon-m-calendar')
                                ->color('gray')
                                ->sortable(),
                            TextColumn::make('jatuh_tempo')
                                ->html()
                                ->size('xs')
                                ->formatStateUsing(function ($state, $record) {
                                    if ($record->metode !== 'cicil' || !$state || $record->status_bayar === 'lunas') return '';
                                    
                                    $jatuhTempo = \Carbon\Carbon::parse($state)->startOfDay();
                                    $sekarang = now()->startOfDay();
                                    
                                    if ($jatuhTempo->isBefore($sekarang)) {
                                        return "<span class='text-danger-600 font-medium'>Tempo: {$jatuhTempo->format('d M Y')} (Telat)</span>";
                                    }
                                    if ($sekarang->diffInDays($jatuhTempo) <= 3) {
                                        return "<span class='text-warning-600 font-medium'>Tempo: {$jatuhTempo->format('d M Y')} (Segera)</span>";
                                    }
                                    return "<span class='text-gray-500'>Tempo: {$jatuhTempo->format('d M Y')}</span>";
                                }),
                        ]),

                        TextColumn::make('sales.nama_sales')
                            ->prefix('Sales: ')
                            ->icon('heroicon-m-user')
                            ->color('gray')
                            ->searchable()
                            ->sortable(),
                    ]),

                    Split::make([
                        TextColumn::make('total_penjualan')
                            ->money('IDR')
                            ->weight('bold')
                            ->size('lg')
                            ->sortable(),

                        TextColumn::make('status_bayar')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'lunas' => 'success',
                                'sebagian' => 'warning',
                                'belum_dibayar' => 'danger',
                            })
                            ->alignEnd(),
                    ])->extraAttributes(['class' => 'mt-2']),

                    TextColumn::make('sudah_dibayar')
                        ->html()
                        ->formatStateUsing(function ($record) {
                            $terbayar = 'Rp ' . number_format($record->sudah_dibayar ?? 0, 0, ',', '.');
                            $sisa = 'Rp ' . number_format($record->sisa_pembayaran ?? 0, 0, ',', '.');
                            $isLunas = $record->status_bayar === 'lunas';
                            
                            $bgColor = $isLunas ? 'bg-success-50 dark:bg-success-900/30' : 'bg-warning-50 dark:bg-warning-900/30';
                            $textColorTerbayar = 'text-success-600 dark:text-success-400';
                            $textColorSisa = 'text-danger-600 dark:text-danger-400';
                            
                            return "
                                <div class='flex justify-between items-center p-3 rounded-lg border border-gray-100 dark:border-gray-800 {$bgColor} mt-1 w-full'>
                                    <div>
                                        <div class='text-xs text-gray-500'>Terbayar</div>
                                        <div class='font-bold {$textColorTerbayar}'>{$terbayar}</div>
                                    </div>
                                    <div>
                                        <div class='text-xs text-gray-500'>Sisa</div>
                                        <div class='font-bold {$textColorSisa}'>{$sisa}</div>
                                    </div>
                                </div>
                            ";
                        }),
                ])->space(3),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('kecamatan_id')
                    ->label('Kecamatan')
                    ->options(\App\Models\Kecamatan::pluck('nama_kecamatan', 'id'))
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            return $query->whereHas('buyer', function ($q) use ($data) {
                                $q->where('kecamatan_id', $data['value']);
                            });
                        }
                        return $query;
                    })
                    ->searchable(),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('danger')
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;'])
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
                    ->outlined()
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;'])
                    ->tooltip('Tolak Penjualan')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status_persetujuan === 'pending')
                    ->action(function ($record) {
                        $record->update(['status_persetujuan' => 'ditolak']);
                    }),
                Action::make('cicil')
                    ->label('Bayar Cicilan')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('danger')
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;'])
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
                    ->visible(fn ($record) => $record->metode === 'cicil' && $record->sisa_pembayaran > 0 && $record->status_persetujuan === 'disetujui'),

                Action::make('detail_barang_btn')
                    ->label('Detail Barang')
                    ->icon('heroicon-o-shopping-bag')
                    ->color('danger')
                    ->outlined()
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;'])
                    ->infolist([
                        \Filament\Infolists\Components\RepeatableEntry::make('details')
                            ->hiddenLabel()
                            ->contained(false)
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('barang.nama_barang')->label('Barang'),
                                \Filament\Infolists\Components\TextEntry::make('qty')->label('Qty'),
                                \Filament\Infolists\Components\TextEntry::make('harga_jual')->money('IDR')->label('Harga Satuan'),
                                \Filament\Infolists\Components\TextEntry::make('subtotal')->money('IDR')->label('Subtotal'),
                            ])
                            ->columns(4)
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn ($record) => $record->status_persetujuan !== 'pending' && !($record->metode === 'cicil' && $record->sisa_pembayaran > 0 && $record->status_persetujuan === 'disetujui')),

                Action::make('lihat_foto_btn')
                    ->label('Lihat Foto')
                    ->icon('heroicon-o-photo')
                    ->color('danger')
                    ->outlined()
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;'])
                    ->modalContent(fn ($record) => view('filament.components.foto-modal', ['foto' => $record->foto_nota]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn ($record) => $record->status_persetujuan !== 'pending' && $record->foto_nota),
                    
                ActionGroup::make([
                    Action::make('detail_barang_dropdown')
                        ->label('Detail Barang')
                        ->icon('heroicon-o-shopping-bag')
                        ->color('gray')
                        ->infolist([
                            \Filament\Infolists\Components\RepeatableEntry::make('details')
                                ->hiddenLabel()
                                ->contained(false)
                                ->schema([
                                    \Filament\Infolists\Components\TextEntry::make('barang.nama_barang')->label('Barang'),
                                    \Filament\Infolists\Components\TextEntry::make('qty')->label('Qty'),
                                    \Filament\Infolists\Components\TextEntry::make('harga_jual')->money('IDR')->label('Harga Satuan'),
                                    \Filament\Infolists\Components\TextEntry::make('subtotal')->money('IDR')->label('Subtotal'),
                                ])
                                ->columns(4)
                        ])
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Tutup')
                        ->visible(fn ($record) => $record->status_persetujuan === 'pending'),

                    Action::make('lihat_foto_dropdown')
                        ->label('Lihat Foto')
                        ->icon('heroicon-o-photo')
                        ->color('gray')
                        ->modalContent(fn ($record) => view('filament.components.foto-modal', ['foto' => $record->foto_nota]))
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Tutup')
                        ->visible(fn ($record) => $record->status_persetujuan === 'pending' && $record->foto_nota),

                    Action::make('riwayat_cicilan')
                        ->label('Riwayat Cicilan')
                        ->icon('heroicon-o-clock')
                        ->color('gray')
                        ->infolist([
                            \Filament\Infolists\Components\RepeatableEntry::make('cicilans')
                                ->hiddenLabel()
                                ->contained(false)
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
                    EditAction::make()->color('gray'),
                    \Filament\Actions\DeleteAction::make()->requiresConfirmation(),

                ])->icon('heroicon-m-ellipsis-vertical'),
            ]);
    }
}
