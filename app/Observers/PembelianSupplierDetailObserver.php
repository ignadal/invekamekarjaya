<?php

namespace App\Observers;

use App\Models\PembelianSupplierDetail;

class PembelianSupplierDetailObserver
{


    /**
     * Handle the PembelianSupplierDetail "created" event.
     */
    public function created(PembelianSupplierDetail $pembelianSupplierDetail): void
    {
        $barang = $pembelianSupplierDetail->barang;
        if ($barang) {
            $barang->increment('stok', $pembelianSupplierDetail->qty);
            $namaSupplier = $pembelianSupplierDetail->pembelianSupplier->supplier->nama_supplier ?? '-';
            $barang->riwayatStoks()->create([
                'tipe' => 'tambah',
                'jumlah' => $pembelianSupplierDetail->qty,
                'keterangan' => 'Dari pembelian supplier ' . $namaSupplier,
            ]);
        }
    }

    /**
     * Handle the PembelianSupplierDetail "updated" event.
     */
    public function updated(PembelianSupplierDetail $pembelianSupplierDetail): void
    {
        if ($pembelianSupplierDetail->wasChanged('qty')) {
            $diff = $pembelianSupplierDetail->qty - $pembelianSupplierDetail->getOriginal('qty');
            $barang = $pembelianSupplierDetail->barang;
            if ($barang && $diff != 0) {
                $barang->increment('stok', $diff);
                $namaSupplier = $pembelianSupplierDetail->pembelianSupplier->supplier->nama_supplier ?? '-';
                $barang->riwayatStoks()->create([
                    'tipe' => $diff > 0 ? 'tambah' : 'kurang',
                    'jumlah' => abs($diff),
                    'keterangan' => 'Perubahan qty pembelian supplier ' . $namaSupplier,
                ]);
            }
        }
    }

    /**
     * Handle the PembelianSupplierDetail "deleted" event.
     */
    public function deleted(PembelianSupplierDetail $pembelianSupplierDetail): void
    {
        $barang = $pembelianSupplierDetail->barang;
        if ($barang) {
            $barang->decrement('stok', $pembelianSupplierDetail->qty);
            $namaSupplier = $pembelianSupplierDetail->pembelianSupplier->supplier->nama_supplier ?? '-';
            $barang->riwayatStoks()->create([
                'tipe' => 'kurang',
                'jumlah' => $pembelianSupplierDetail->qty,
                'keterangan' => 'Penghapusan barang dari pembelian supplier ' . $namaSupplier,
            ]);
        }
    }

    /**
     * Handle the PembelianSupplierDetail "restored" event.
     */
    public function restored(PembelianSupplierDetail $pembelianSupplierDetail): void
    {
        //
    }

    /**
     * Handle the PembelianSupplierDetail "force deleted" event.
     */
    public function forceDeleted(PembelianSupplierDetail $pembelianSupplierDetail): void
    {
        //
    }
}
