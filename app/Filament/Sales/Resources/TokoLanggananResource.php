<?php

namespace App\Filament\Sales\Resources;

use App\Filament\Sales\Resources\TokoLanggananResource\Pages;
use App\Models\Buyer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;

use Filament\Schemas\Components\Section as SchemaSection;
use Filament\Schemas\Components\Grid as SchemaGrid;

class TokoLanggananResource extends Resource
{
    protected static ?string $model = Buyer::class;
    protected static ?string $pluralModelLabel = 'Toko Langganan';
    protected static ?string $modelLabel = 'Toko Langganan';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;
    protected static ?string $navigationLabel = 'Kunjungan';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Toko')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(1)
                            ->schema([
                                \Filament\Schemas\Components\View::make('filament.sales.components.foto-toko-slider')
                                    ->columnSpanFull(),
                                Select::make('kecamatan_id')
                                    ->relationship('kecamatan', 'nama_kecamatan')
                                    ->label('Kecamatan')
                                    ->disabled(),
                                TextInput::make('nama_toko')
                                    ->label('Nama Toko')
                                    ->disabled(),
                                TextInput::make('nama_owner')
                                    ->label('Nama Owner')
                                    ->disabled(),
                                TextInput::make('no_hp')
                                    ->label('No. Handphone')
                                    ->disabled(),
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        TextInput::make('jam_buka')
                                            ->label('Jam Buka')
                                            ->disabled()
                                            ->prefixIcon('heroicon-o-clock'),
                                        TextInput::make('jam_tutup')
                                            ->label('Jam Tutup')
                                            ->disabled()
                                            ->prefixIcon('heroicon-o-clock'),
                                    ]),
                            ]),
                    ]),
                \Filament\Schemas\Components\Section::make('Detail Lokasi & Catatan')
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull()
                            ->disabled(),
                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->columnSpanFull()
                            ->disabled(),
                    ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaSection::make('Informasi Utama')
                    ->description('Detail informasi tentang toko pelanggan.')
                    ->schema([
                        ViewEntry::make('foto_toko')
                            ->view('filament.sales.components.foto-toko-slider')
                            ->columnSpanFull()
                            ->label(''),
                        SchemaGrid::make(1)->schema([
                            TextEntry::make('nama_toko')
                                ->label('Nama Toko')
                                ->weight('bold')
                                ->size('lg')
                                ->color('primary'),
                            TextEntry::make('nama_owner')
                                ->label('Nama Pemilik (Owner)'),
                            TextEntry::make('no_hp')
                                ->label('No. Handphone')
                                ->copyable()
                                ->copyMessage('Nomor handphone disalin!'),
                            TextEntry::make('kecamatan.nama_kecamatan')
                                ->label('Kecamatan'),
                        ]),
                    ])->collapsible(),

                SchemaSection::make('Waktu Operasional')
                    ->schema([
                        SchemaGrid::make(1)->schema([
                            TextEntry::make('jam_buka')
                                ->label('Jam Buka')
                                ->color('success'),
                            TextEntry::make('jam_tutup')
                                ->label('Jam Tutup')
                                ->color('danger'),
                        ])
                    ])->collapsible(),

                SchemaSection::make('Lokasi & Catatan Tambahan')
                    ->schema([
                        TextEntry::make('alamat')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull(),
                        TextEntry::make('catatan')
                            ->label('Catatan Khusus')
                            ->columnSpanFull()
                            ->default('-'),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('foto_toko')
                    ->label('Foto')
                    ->disk('public')
                    ->height(70)
                    ->width(90)
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->defaultImageUrl(asset('images/default-toko.png'))
                    ->extraImgAttributes([
                        'style' => 'object-fit: cover; border-radius: 0.5rem;',
                    ]),
                TextColumn::make('nama_toko')
                    ->label('Nama Toko')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('nama_owner')
                    ->label('Nama Owner')
                    ->searchable(),
                TextColumn::make('kecamatan.nama_kecamatan')
                    ->label('Kecamatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_hp')
                    ->label('No. Handphone')
                    ->searchable(),
                TextColumn::make('jam_buka')
                    ->label('Jam Operasional')
                    ->formatStateUsing(function ($record) {
                        $buka = $record->jam_buka ? \Carbon\Carbon::parse($record->jam_buka)->format('H:i') : '-';
                        $tutup = $record->jam_tutup ? \Carbon\Carbon::parse($record->jam_tutup)->format('H:i') : '-';
                        return $buka . ' – ' . $tutup;
                    })
                    ->icon('heroicon-o-clock')
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                SelectFilter::make('kecamatan_id')
                    ->relationship('kecamatan', 'nama_kecamatan')
                    ->label('Filter Kecamatan')
                    ->searchable()
                    ->preload(),
            ])
            ->actionsColumnLabel('Aksi')
            ->recordActions([
                \Filament\Actions\ViewAction::make()->label('Detail')->button()->outlined()->color('danger'),
            ])
            ->toolbarActions([
                // 
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTokoLangganan::route('/'),
        ];
    }
}
