<?php

namespace App\Filament\Resources\Barangs\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembelianDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'pembelianDetails';
    protected static ?string $title = 'Pembelian Detail';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pembelian_supplier_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Riwayat Pembelian')
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('pembelianSupplier.tanggal_pembelian')
                    ->label('Tanggal Beli')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('pembelianSupplier.supplier.nama_supplier')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('qty')
                    ->label('Qty')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
