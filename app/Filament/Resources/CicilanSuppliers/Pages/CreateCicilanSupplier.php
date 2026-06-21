<?php

namespace App\Filament\Resources\CicilanSuppliers\Pages;

use App\Filament\Resources\CicilanSuppliers\CicilanSupplierResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCicilanSupplier extends CreateRecord
{
    protected static string $resource = CicilanSupplierResource::class;

    protected function afterCreate(): void
    {
        $cicilan = $this->record;

        $pembelian = $cicilan->pembelianSupplier;

        $totalDibayar = $pembelian->cicilans()->sum('nominal');

        $sisaPembayaran = $pembelian->total_pembelian - $totalDibayar;

        $status = match (true) {
            $totalDibayar <= 0 => 'belum_dibayar',
            $totalDibayar < $pembelian->total_pembelian => 'sebagian',
            default => 'lunas',
        };

        $pembelian->update([
            'sudah_dibayar' => $totalDibayar,
            'sisa_pembayaran' => max(0, $sisaPembayaran),
            'status' => $status,
        ]);
    }
}