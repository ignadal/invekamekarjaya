<?php

namespace App\Filament\Resources\PembelianSuppliers\Tables;

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

class PembelianSuppliersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(fn ($query) => $query->orderByRaw("
                CASE 
                    WHEN status = 'sebagian' THEN 1
                    WHEN status = 'belum_dibayar' THEN 2
                    ELSE 3
                END ASC
            ")->orderBy('created_at', 'desc'))
            ->columns([
                Stack::make([
                    Split::make([
                        TextColumn::make('supplier.nama_supplier')
                            ->weight('bold')
                            ->size('lg')
                            ->icon('heroicon-m-building-storefront')
                            ->iconColor('danger')
                            ->description(function ($record) {
                                $method = $record->metode ?? 'tunai';
                                $colorClass = match (strtolower($method)) {
                                    'lunas', 'tunai' => 'bg-success-50 text-success-700 ring-success-600/10 dark:bg-success-900/30 dark:text-success-400',
                                    'transfer' => 'bg-info-50 text-info-700 ring-info-600/10 dark:bg-info-900/30 dark:text-info-400',
                                    default => 'bg-danger-50 text-danger-700 ring-danger-600/10 dark:bg-danger-900/30 dark:text-danger-400',
                                };
                                return new HtmlString("<span class='inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {$colorClass} mt-1'>" . ucwords($method) . "</span>");
                            })
                            ->searchable(),

                        Stack::make([
                            TextColumn::make('tanggal_pembelian')
                                ->date('d M Y')
                                ->color('gray')
                                ->size('sm')
                                ->alignEnd(),
                            TextColumn::make('jatuh_tempo')
                                ->html()
                                ->size('xs')
                                ->alignEnd()
                                ->formatStateUsing(function ($state, $record) {
                                    if ($record->metode !== 'nyicil' || !$state || $record->status === 'lunas') return '';
                                    
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
                        ])->alignment('end'),
                    ]),
                    Stack::make([
                        TextColumn::make('dummy_total')
                            ->default('Total Pembelian')
                            ->size('sm')
                            ->color('gray'),

                        Split::make([
                            TextColumn::make('total_pembelian')
                                ->money('IDR')
                                ->weight('bold')
                                ->size('xl')
                                ->sortable(),

                            TextColumn::make('status')
                                ->badge()
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
                                })
                                ->formatStateUsing(function (string $state, $record) {
                                    if ($record->metode === 'lunas') return 'Lunas';
                                    if ($state !== 'lunas' && $record->jatuh_tempo && \Carbon\Carbon::parse($record->jatuh_tempo)->startOfDay()->isBefore(now()->startOfDay())) {
                                        return 'Telat Bayar';
                                    }
                                    return ucwords(str_replace('_', ' ', $state));
                                })
                                ->alignEnd(),
                        ])->extraAttributes(['class' => '-mt-2']),
                    ])->space(1)->extraAttributes(['class' => 'mt-4']),

                    TextColumn::make('sudah_dibayar')
                        ->html()
                        ->formatStateUsing(function ($record) {
                            $terbayar = 'Rp ' . number_format($record->sudah_dibayar ?? 0, 0, ',', '.');
                            $sisa = 'Rp ' . number_format($record->sisa_pembayaran ?? 0, 0, ',', '.');
                            $total = $record->total_pembelian > 0 ? $record->total_pembelian : 1;
                            $percent = round((($record->sudah_dibayar ?? 0) / $total) * 100);
                            $percent = min(100, max(0, $percent));
                            
                            $barColor = $percent >= 100 ? 'bg-success-500' : 'bg-success-500'; // Make it green like mockup
                            
                            return "
                            <div class='mt-2 w-full'>
                                <div class='flex justify-between text-sm mb-1'>
                                    <div>
                                        <div class='text-gray-500 text-xs'>Terbayar</div>
                                        <div class='text-success-600 font-bold'>{$terbayar}</div>
                                    </div>
                                    <div>
                                        <div class='text-gray-500 text-xs'>Sisa</div>
                                        <div class='text-danger-600 font-bold'>{$sisa}</div>
                                    </div>
                                </div>
                                <div class='flex items-center gap-2 mt-2'>
                                    <div class='w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700'>
                                        <div class='{$barColor} h-2 rounded-full transition-all duration-500' style='width: {$percent}%'></div>
                                    </div>
                                    <span class='text-xs font-medium text-gray-500 min-w-[2rem] text-right'>{$percent}%</span>
                                </div>
                            </div>
                            ";
                        }),
                ])->space(3),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('bayar_cicilan_btn')
                    ->label('Bayar')
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

                Action::make('riwayat_cicilan_btn')
                    ->label('Riwayat')
                    ->icon('heroicon-o-clock')
                    ->color('danger')
                    ->outlined()
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;'])
                    ->tooltip('Riwayat Cicilan')
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
                    ->visible(fn ($record) => $record->metode === 'nyicil' && $record->sisa_pembayaran <= 0 && $record->cicilans()->exists()),
                    
                Action::make('detail_barang')
                    ->label('Barang')
                    ->icon('heroicon-o-shopping-bag')
                    ->color('danger')
                    ->outlined()
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;'])
                    ->tooltip('Detail Barang')
                    ->infolist([
                        \Filament\Infolists\Components\RepeatableEntry::make('details')
                            ->hiddenLabel()
                            ->contained(false)
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
                    
                ActionGroup::make([
                    Action::make('riwayat_cicilan_menu')
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
                        ->visible(fn ($record) => $record->metode === 'nyicil' && $record->sisa_pembayaran > 0 && $record->cicilans()->exists()),

                    EditAction::make()->color('gray'),
                    \Filament\Actions\DeleteAction::make()->requiresConfirmation(),
                ])->icon('heroicon-m-ellipsis-vertical'),
            ]);
    }
}
