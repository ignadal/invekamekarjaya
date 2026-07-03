<?php

namespace App\Filament\Resources\Buyers\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class BuyerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Foto Toko')
                    ->schema([
                        ImageEntry::make('foto_toko')
                            ->hiddenLabel()
                            ->disk('public')
                            ->extraImgAttributes([
                                'class' => 'rounded-xl',
                                'style' => 'width: 100%; height: 100%; object-fit: cover; border: 1px solid #fecaca;'
                            ])
                            ->defaultImageUrl(asset('images/default-toko.png')),
                    ]),
                
                Section::make('Informasi Toko')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('nama_toko')
                                    ->label('Nama Toko')
                                    ->size(\Filament\Support\Enums\TextSize::Large)
                                    ->weight('bold'),
                                
                                TextEntry::make('kecamatan.nama_kecamatan')
                                    ->label('Lokasi'),
                                    
                                TextEntry::make('nama_owner')
                                    ->label('Owner'),
                                    
                                TextEntry::make('no_hp')
                                    ->label('Nomor WhatsApp'),
                                
                                TextEntry::make('hari_buka')
                                    ->label('Jadwal Buka')
                                    ->getStateUsing(function ($record) {
                                        $hari = 'Tidak diset';
                                        if ($record->hari_buka && $record->hari_bukaakhir) {
                                            $hari = $record->hari_buka . ' - ' . $record->hari_bukaakhir;
                                        } elseif ($record->hari_buka) {
                                            $hari = $record->hari_buka;
                                        } elseif ($record->hari_bukaakhir) {
                                            $hari = 'Sampai ' . $record->hari_bukaakhir;
                                        }
                                        $buka = $record->jam_buka ? \Carbon\Carbon::parse($record->jam_buka)->format('H:i') : '-';
                                        $tutup = $record->jam_tutup ? \Carbon\Carbon::parse($record->jam_tutup)->format('H:i') : '-';
                                        return $hari . ' | ' . $buka . ' – ' . $tutup;
                                    }),
                                    
                                TextEntry::make('alamat')
                                    ->label('Alamat Lengkap'),
                            ]),
                    ]),
                    
                Section::make('Catatan Toko')
                    ->schema([
                        TextEntry::make('catatan')
                            ->hiddenLabel()
                            ->formatStateUsing(fn ($state) => $state ?: '-')
                    ])
            ]);
    }
}
