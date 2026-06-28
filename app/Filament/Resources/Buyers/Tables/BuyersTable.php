<?php

namespace App\Filament\Resources\Buyers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BuyersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->stackedOnMobile()
            ->columns([
                ImageColumn::make('foto_toko')
                    ->label('Foto Toko')
                    ->disk('public')
                    ->height(80)
                    ->width(100)
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->defaultImageUrl(asset('images/default-toko.png'))
                    ->extraImgAttributes([
                        'style' => 'object-fit: cover; border-radius: 0.5rem; border: 2px solid #fecaca;',
                    ]),
                TextColumn::make('kecamatan.nama_kecamatan')
                    ->label('Kecamatan')
                    ->searchable(),
                TextColumn::make('nama_toko')
                    ->label('Nama Toko')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('nama_owner')
                    ->label('Nama Owner')
                    ->searchable(),
                TextColumn::make('no_hp')
                    ->label('No HP')
                    ->searchable(),
                TextColumn::make('jam_buka')
                    ->label('Jam Operasional')
                    ->formatStateUsing(function ($record) {
                        $buka = $record->jam_buka ? \Carbon\Carbon::parse($record->jam_buka)->format('H:i') : '-';
                        $tutup = $record->jam_tutup ? \Carbon\Carbon::parse($record->jam_tutup)->format('H:i') : '-';
                        return $buka . ' – ' . $tutup;
                    })
                    ->icon('heroicon-o-clock')
                    ->iconColor('danger'),
                TextColumn::make('hari_operasional')
                    ->label('Hari Buka')
                    ->searchable()
                    ->icon('heroicon-o-calendar-days')
                    ->iconColor('danger'),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actionsColumnLabel('Aksi')
            ->recordActions([
                \Filament\Actions\ViewAction::make()->label('View')->button()->outlined()->color('danger'),
                EditAction::make()->iconButton()->label(''),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
