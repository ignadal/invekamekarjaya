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
            ->recordClasses(['buyers-card'])
            ->columns([
                Stack::make([
                    TextColumn::make('nama_toko')
                        ->weight('bold')
                        ->size('xl')
                        ->searchable()
                        ->extraAttributes(['class' => 'mb-2']),

                    ImageColumn::make('foto_toko')
                        ->disk('public')
                        ->defaultImageUrl(asset('images/default-toko.png'))
                        ->extraImgAttributes([
                            'class' => 'w-full rounded-xl object-cover',
                            'style' => 'height: 160px;',
                        ]),

                    Stack::make([
                        TextColumn::make('kecamatan.nama_kecamatan')
                            ->icon('heroicon-m-map-pin')
                            ->color('gray')
                            ->size('sm'),

                        Split::make([
                            TextColumn::make('nama_owner')
                                ->icon('heroicon-m-user')
                                ->color('gray')
                                ->size('sm'),

                            TextColumn::make('no_hp')
                                ->icon('heroicon-m-phone')
                                ->color('gray')
                                ->size('sm')
                                ->copyable()
                                ->alignEnd(),
                        ]),

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
                    ])->space(2)->extraAttributes(['class' => 'mt-3']),

                    TextColumn::make('css_hack')
                        ->state(fn() => '')
                        ->extraAttributes(['class' => 'hidden'])
                        ->description(fn() => new \Illuminate\Support\HtmlString('
                            <style>
                                .buyers-card .fi-ta-actions { gap: 0 !important; width: 100% !important; margin-top: 1rem !important; }
                                .buyers-card .fi-ta-actions > * { flex: 1 1 0% !important; }
                                .buyers-card .fi-ta-actions button, .buyers-card .fi-ta-actions a { border-radius: 0 !important; width: 100% !important; justify-content: center !important; }
                            </style>
                        ')),
                ])
                ->space(1)
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
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;']),

                Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->outlined()
                    ->icon('bi-whatsapp')
                    ->color('success')
                    ->button()
                    ->extraAttributes(['style' => 'flex: 1 1 40%; justify-content: center;'])
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
                ])
                // ->button()
                ->color('primary')
                ->label('')
                ->icon('heroicon-m-ellipsis-vertical')
                ->extraAttributes(['class' => 'flex-1']),
            ]);

    }
}