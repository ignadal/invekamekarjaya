<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultPaginationPageOption(9)
            ->paginationPageOptions([9, 18, 27])
            ->recordClasses(['barangs-grid-card'])
            ->columns([
                Stack::make([
                    ImageColumn::make('foto')
                        ->alignment('center')
                        ->extraAttributes(['class' => 'custom-square-wrapper'])
                        ->extraImgAttributes(['class' => 'w-full object-cover rounded-t-xl aspect-square', 'style' => 'height: auto !important;']),

                    Stack::make([
                        TextColumn::make('nama_barang')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable()
                            ->sortable(),

                        TextColumn::make('kategori.nama_kategori')
                            ->label('Kategori')
                            ->icon('heroicon-m-tag')
                            ->color('gray')
                            ->searchable()
                            ->sortable(),

                        Split::make([
                            TextColumn::make('harga_jual')
                                ->money('IDR')
                                ->weight('bold')
                                ->color('danger')
                                ->sortable(),

                            TextColumn::make('stok')
                                ->badge()
                                ->color(fn ($record) =>
                                    $record->stok <= $record->stok_minimum
                                        ? 'danger'
                                        : 'success'
                                )
                                ->suffix(fn ($record) => ' / min ' . $record->stok_minimum),
                        ]),

                        Split::make([
                            TextColumn::make('ukuran')
                                ->badge()
                                ->color('info')
                                ->icon('heroicon-m-arrows-pointing-out')
                                ->placeholder('-'),

                            TextColumn::make('berat')
                                ->badge()
                                ->color('warning')
                                ->icon('heroicon-m-scale')
                                ->placeholder('-'),
                        ]),
                    ])->space(2),
                ]),
            ])
            ->filters([
                SelectFilter::make('status_stok')
                    ->label('Status Stok')
                    ->options([
                        'habis' => 'Stok Habis (0)',
                        'sedikit' => 'Stok Sedikit (≤ Min)',
                        'aman' => 'Stok Aman (> Min)',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'habis') {
                            return $query->where('stok', '<=', 0);
                        }
                        if ($data['value'] === 'sedikit') {
                            return $query->where('stok', '>', 0)->whereColumn('stok', '<=', 'stok_minimum');
                        }
                        if ($data['value'] === 'aman') {
                            return $query->whereColumn('stok', '>', 'stok_minimum');
                        }
                        return $query;
                    }),

                SelectFilter::make('kategori_barang_id')
                    ->relationship('kategori', 'nama_kategori'),

                TrashedFilter::make(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('Penyesuaian Stok')
                    ->label('Stok')
                    ->icon('heroicon-o-arrows-up-down')
                    ->button()
                    ->tooltip('Penyesuaian Stok (Manual)')
                    ->color('danger')
                    ->form([
                        \Filament\Forms\Components\Radio::make('tipe')
                            ->label('Tipe Penyesuaian')
                            ->options([
                                'tambah' => 'Tambah Stok',
                                'kurang' => 'Kurang Stok',
                            ])
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                        \Filament\Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan / Alasan')
                            ->placeholder('Contoh: Dipakai sendiri, barang rusak, dsb.')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        if ($data['tipe'] === 'tambah') {
                            $record->increment('stok', $data['jumlah']);
                            $record->riwayatStoks()->create([
                                'tipe' => 'tambah',
                                'jumlah' => $data['jumlah'],
                                'keterangan' => $data['keterangan'],
                            ]);
                        } else {
                            if ($record->stok < $data['jumlah']) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Gagal! Stok tidak mencukupi')
                                    ->body('Stok saat ini: ' . $record->stok . ', tidak bisa dikurangi ' . $data['jumlah'])
                                    ->danger()
                                    ->send();
                                return;
                            }
                            $record->decrement('stok', $data['jumlah']);
                            $record->riwayatStoks()->create([
                                'tipe' => 'kurang',
                                'jumlah' => $data['jumlah'],
                                'keterangan' => $data['keterangan'],
                            ]);
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Stok berhasil disesuaikan')
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\ViewAction::make()->color('danger')->iconButton()->tooltip('Detail Barang'),
                \Filament\Actions\EditAction::make()->color('danger')->iconButton()->tooltip('Edit'),
                \Filament\Actions\DeleteAction::make()->iconButton()->requiresConfirmation(),
                ]);
            // ->toolbarActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //         ForceDeleteBulkAction::make(),
            //         RestoreBulkAction::make(),
            //     ]),
            // ]);
    }
}
