<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Barang;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Forms\Components\Placeholder::make('info_acc')
                    ->hiddenLabel()
                    ->content(new \Illuminate\Support\HtmlString('
                        <div style="border: 1px solid #fca5a5; background-color: #fef2f2; border-radius: 0.5rem; padding: 1rem; display: flex; gap: 1rem; align-items: flex-start;">
                            <svg style="width: 1.5rem; height: 1.5rem; color: #dc2626; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <h4 style="color: #dc2626; font-weight: 700; margin-bottom: 0.25rem;">Pemberitahuan</h4>
                                <p style="color: #4b5563; font-size: 0.875rem;">Pastikan orderan baru yang Anda buat akan masuk dengan status <strong>Pending</strong>.<br>Orderan ini harus mendapatkan ACC (Persetujuan) dari Admin sebelum diproses lebih lanjut.</p>
                            </div>
                        </div>
                    '))
                    ->visible(fn () => filament()->getCurrentPanel()?->getId() === 'sales'),
                
                \Filament\Schemas\Components\Section::make('Informasi Umum')
                    ->heading(new \Illuminate\Support\HtmlString('
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="background-color: #fef2f2; padding: 0.5rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 1.5rem; height: 1.5rem; color: #E30613;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span style="font-weight: 700; color: #111827; font-size: 1.125rem;">Informasi Umum</span>
                        </div>
                    '))
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                Select::make('sales_id')
                                    ->relationship('sales', 'nama_sales')
                                    ->required(fn () => filament()->getCurrentPanel()?->getId() !== 'sales')
                                    ->hidden(fn () => filament()->getCurrentPanel()?->getId() === 'sales')
                                    ->searchable()
                                    ->preload(),
                                
                                Select::make('buyer_id')
                                    ->label('Buyer')
                                    ->relationship('buyer', 'nama_toko')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nama_toko} - " . ($record->kecamatan->nama_kecamatan ?? ''))
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                DatePicker::make('tanggal_beli')
                                    ->label('Tanggal beli')
                                    ->required()
                                    ->minDate(today())
                                    ->default(today()),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Daftar Barang')
                    ->heading(new \Illuminate\Support\HtmlString('
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="background-color: #fef2f2; padding: 0.5rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 1.5rem; height: 1.5rem; color: #E30613;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span style="font-weight: 700; color: #111827; font-size: 1.125rem;">Daftar Barang</span>
                        </div>
                    '))
                    ->schema([
                        Repeater::make('details')
                            ->label('Detail Barang')
                            ->addActionLabel('Tambah Barang')
                            ->relationship()
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        Select::make('barang_id')
                                            ->label('Barang')
                                            ->options(function () {
                                                return Barang::where('stok', '>', 0)
                                                    ->get()
                                                    ->pluck('nama_barang', 'id')
                                                    ->map(function ($nama, $id) {
                                                        $barang = Barang::find($id);
                                                        return $nama . ' - Stok ' . $barang->stok;
                                                    });
                                            })
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->required()
                                            ->searchable()
                                            ->live()
                                            ->afterStateUpdated(function (Set $set, Get $get, $state, ?string $statePath) {
                                                $barang = Barang::find($state);
                                                if ($barang) {
                                                    $set('harga_jual', $barang->harga_jual);
                                                    $set('qty', 1);
                                                    $set('subtotal', $barang->harga_jual);
                                                    
                                                    $details = $get('../../details') ?? [];
                                                    $segments = explode('.', $statePath);
                                                    $key = $segments[count($segments) - 2] ?? null;
                                                    
                                                    $total = 0;
                                                    foreach ($details as $k => $item) {
                                                        if ($k === $key) {
                                                            $total += $barang->harga_jual * 1;
                                                        } else {
                                                            $q = isset($item['qty']) ? (int)$item['qty'] : 0;
                                                            $h = isset($item['harga_jual']) ? (int)$item['harga_jual'] : 0;
                                                            $total += ($q * $h);
                                                        }
                                                    }
                                                    $set('../../total_penjualan', $total);
                                                    
                                                    if ($get('../../metode') === 'lunas') {
                                                        $set('../../sudah_dibayar', $total);
                                                        $set('../../sisa_pembayaran', 0);
                                                        $set('../../status_bayar', 'lunas');
                                                    } else {
                                                        $sudah = (int)$get('../../sudah_dibayar');
                                                        $set('../../sisa_pembayaran', $total - $sudah);
                                                        $set('../../status_bayar', $sudah >= $total && $total > 0 ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                                    }
                                                }
                                            }),
                                        
                                        TextInput::make('qty')
                                            ->label('Qty')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->maxValue(function (Get $get) {
                                                $barang = Barang::find($get('barang_id'));
                                                return $barang ? $barang->stok : 1;
                                            })
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                                $barang = Barang::find($get('barang_id'));
                                                if ($barang && $state > $barang->stok) {
                                                    $state = $barang->stok;
                                                    $set('qty', $state);
                                                }
                                                $set('subtotal', $state * (int)$get('harga_jual'));
                                                
                                                $details = $get('../../details');
                                                $total = 0;
                                                if (is_array($details)) {
                                                    foreach ($details as $item) {
                                                        $q = isset($item['qty']) ? (int)$item['qty'] : 0;
                                                        $h = isset($item['harga_jual']) ? (int)$item['harga_jual'] : 0;
                                                        $total += ($q * $h);
                                                    }
                                                }
                                                $set('../../total_penjualan', $total);
                                                
                                                if ($get('../../metode') === 'lunas') {
                                                    $set('../../sudah_dibayar', $total);
                                                    $set('../../sisa_pembayaran', 0);
                                                    $set('../../status_bayar', 'lunas');
                                                } else {
                                                    $sudah = (int)$get('../../sudah_dibayar');
                                                    $set('../../sisa_pembayaran', $total - $sudah);
                                                    $set('../../status_bayar', $sudah >= $total && $total > 0 ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                                }
                                            }),
                                    ]),

                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        TextInput::make('harga_jual')
                                            ->label('Harga jual')
                                            ->prefix('Rp')
                                            ->numeric()
                                            ->required()
                                            ->readOnly(fn () => filament()->getCurrentPanel()?->getId() === 'sales')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                                $set('subtotal', $state * (int)$get('qty'));
                                                
                                                $details = $get('../../details');
                                                $total = 0;
                                                if (is_array($details)) {
                                                    foreach ($details as $item) {
                                                        $q = isset($item['qty']) ? (int)$item['qty'] : 0;
                                                        $h = isset($item['harga_jual']) ? (int)$item['harga_jual'] : 0;
                                                        $total += ($q * $h);
                                                    }
                                                }
                                                $set('../../total_penjualan', $total);
                                                
                                                if ($get('../../metode') === 'lunas') {
                                                    $set('../../sudah_dibayar', $total);
                                                    $set('../../sisa_pembayaran', 0);
                                                    $set('../../status_bayar', 'lunas');
                                                } else {
                                                    $sudah = (int)$get('../../sudah_dibayar');
                                                    $set('../../sisa_pembayaran', $total - $sudah);
                                                    $set('../../status_bayar', $sudah >= $total && $total > 0 ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                                }
                                            }),
                                            
                                        TextInput::make('subtotal')
                                            ->label('Subtotal')
                                            ->prefix('Rp')
                                            ->numeric()
                                            ->required()
                                            ->readOnly()
                                            ->default(0),
                                    ]),
                            ])
                            ->columns(1)
                            ->columnSpanFull(),

                        TextInput::make('total_penjualan')
                            ->label('Total penjualan')
                            ->prefix('Rp')
                            ->numeric()
                            ->required()
                            ->readOnly()
                            ->default(0),
                    ]),

                \Filament\Schemas\Components\Section::make('Pembayaran')
                    ->heading(new \Illuminate\Support\HtmlString('
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="background-color: #fef2f2; padding: 0.5rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 1.5rem; height: 1.5rem; color: #E30613;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <span style="font-weight: 700; color: #111827; font-size: 1.125rem;">Pembayaran</span>
                        </div>
                    '))
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                Select::make('metode')
                                    ->label('Metode')
                                    ->options([
                                        'lunas' => 'Lunas',
                                        'cicil' => 'Cicil',
                                    ])
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        if ($state === 'lunas') {
                                            $set('status_bayar', 'lunas');
                                            $set('sudah_dibayar', $get('total_penjualan'));
                                            $set('sisa_pembayaran', 0);
                                        } else {
                                            $sudah = (int) $get('sudah_dibayar');
                                            $total = (int) $get('total_penjualan');
                                            $set('sisa_pembayaran', $total - $sudah);
                                            $set('status_bayar', $sudah >= $total ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                        }
                                    }),

                                Select::make('metode_pembayaran')
                                    ->label('Metode pembayaran')
                                    ->options([
                                        'cash' => 'Cash',
                                        'transfer' => 'Transfer',
                                    ])
                                    ->required(),

                                DatePicker::make('jatuh_tempo')
                                    ->label('Jatuh tempo')
                                    ->visible(fn (Get $get) => $get('metode') === 'cicil')
                                    ->required(fn (Get $get) => $get('metode') === 'cicil')
                                    ->minDate(today()),
                                
                                TextInput::make('sudah_dibayar')
                                    ->label('Sudah dibayar')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->live(onBlur: true)
                                    ->visible(fn (Get $get) => $get('metode') === 'cicil')
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $sudah = (int) $state;
                                        $total = (int) $get('total_penjualan');
                                        $set('sisa_pembayaran', $total - $sudah);
                                        $set('status_bayar', $sudah >= $total ? 'lunas' : ($sudah > 0 ? 'sebagian' : 'belum_dibayar'));
                                    }),

                                TextInput::make('sisa_pembayaran')
                                    ->label('Sisa pembayaran')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->required()
                                    ->readOnly()
                                    ->visible(fn (Get $get) => $get('metode') === 'cicil')
                                    ->default(0),

                                \Filament\Forms\Components\Hidden::make('status_bayar')
                                    ->default('belum_dibayar'),

                                \Filament\Forms\Components\Hidden::make('status_persetujuan')
                                    ->default('pending'),
                            ]),

                        FileUpload::make('foto_nota')
                            ->label('Foto nota')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('nota_penjualan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
