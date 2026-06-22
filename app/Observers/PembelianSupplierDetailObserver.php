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
            if ($barang) {
                $barang->increment('stok', $diff);
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
