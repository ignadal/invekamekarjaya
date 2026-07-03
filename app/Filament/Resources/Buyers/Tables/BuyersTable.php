<?php

namespace App\Filament\Resources\Buyers\Tables;

use Carbon\Carbon;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use App\Filament\Resources\Buyers\BuyerResource;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;

class BuyersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(9)
            ->paginationPageOptions([9, 18, 27])

            ->columns([
                Stack::make([
                    ImageColumn::make('foto_toko')
                        ->disk('public')
                        ->defaultImageUrl(asset('images/default-toko.png'))
                        ->extraImgAttributes([
                            'class' => 'w-full rounded-xl object-cover',
                            'style' => 'height: 220px;',
                        ]),

                    Stack::make([
                        TextColumn::make('nama_toko')
                            ->weight('bold')
                            ->size('xl')
                            ->searchable(),

                        TextColumn::make('nama_owner')
                            ->icon('heroicon-m-user')
                            ->color('gray')
                            ->size('sm'),

                        TextColumn::make('kecamatan.nama_kecamatan')
                            ->icon('heroicon-m-map-pin')
                            ->color('gray')
                            ->size('sm'),

                        TextColumn::make('no_hp')
                            ->icon('heroicon-m-phone')
                            ->color('gray')
                            ->size('sm')
                            ->copyable(),
                    ])->space(2)->extraAttributes(['class' => 'mt-2']),

                    Stack::make([
                        Split::make([
                            TextColumn::make('hari')
                                ->state(fn ($record) => $record->hari_bukaakhir
                                    ? "{$record->hari_buka} - {$record->hari_bukaakhir}"
                                    : $record->hari_buka)
                                ->icon('heroicon-m-calendar-days')
                                ->badge()
                                ->color('success'),

                            TextColumn::make('jam_operasional')
                                ->state(fn ($record) => Carbon::parse($record->jam_buka)->format('H:i') . ' - ' . Carbon::parse($record->jam_tutup)->format('H:i'))
                                ->icon('heroicon-m-clock')
                                ->badge()
                                ->color('warning')
                                ->alignEnd(),
                        ]),
                    ])->extraAttributes(['class' => 'mt-4 pt-4 border-t border-gray-200 dark:border-white/10']),
                ])
                ->space(3)
                ->extraAttributes([
                    'class' => 'p-2',
                ])
                ->grow(),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])

            ->filters([
                TrashedFilter::make(),
            ])

            ->recordActions([
                ViewAction::make()
                    ->label('Detail')
                    ->icon('heroicon-m-eye')
                    ->color('danger')
                    ->button(),

                Action::make('whatsapp')
                    ->label('WA')
                    ->icon('heroicon-m-chat-bubble-oval-left-ellipsis')
                    ->color('success')
                    ->button()
                    ->url(function ($record) {
                        if (blank($record->no_hp)) {
                            return '#';
                        }

                        $phone = preg_replace('/\D/', '', $record->no_hp);

                        if (str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                        } elseif (! str_starts_with($phone, '62')) {
                            $phone = '62' . $phone;
                        }

                        return "https://wa.me/{$phone}";
                    }, true),

                ActionGroup::make([
                    EditAction::make()->color('warning'),
                    DeleteAction::make()->requiresConfirmation(),
                ]),
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