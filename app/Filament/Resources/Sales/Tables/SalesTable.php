<?php

namespace App\Filament\Resources\Sales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->stackedOnMobile()
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('nama_sales')
                    ->searchable(),
                TextColumn::make('no_hp')
                    ->searchable(),
                TextColumn::make('gaji_pokok')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tanggal_bergabung')
                    ->date()
                    ->sortable(),
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
                \Filament\Actions\Action::make('performa')
                    ->label('Performa')
                    ->icon('heroicon-o-chart-bar')
                    ->color('danger')
                    ->button()
                    ->url(fn ($record) => \App\Filament\Resources\Sales\SalesResource::getUrl('performa', ['record' => $record])),
                \Filament\Actions\ViewAction::make()->label('View')->button()->outlined()->color('danger'),
                EditAction::make()->iconButton()->label(''),
                \Filament\Actions\DeleteAction::make()->iconButton()->requiresConfirmation(),
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
