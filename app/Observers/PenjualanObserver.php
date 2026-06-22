<?php

namespace App\Observers;

use App\Models\Penjualan;

class PenjualanObserver
{
    /**
     * Handle the Penjualan "created" event.
     */
    public function created(Penjualan $penjualan): void
    {
        //
    }

    /**
     * Handle the Penjualan "updated" event.
     */
    public function updated(Penjualan $penjualan): void
    {
        if ($penjualan->wasChanged('status_persetujuan') && $penjualan->status_persetujuan === 'disetujui') {
            foreach ($penjualan->details as $detail) {
                $barang = $detail->barang;
                if ($barang) {
                    $barang->decrement('stok', $detail->qty);
                }
            }
        }
    }

    /**
     * Handle the Penjualan "deleted" event.
     */
    public function deleted(Penjualan $penjualan): void
    {
        //
    }

    /**
     * Handle the Penjualan "restored" event.
     */
    public function restored(Penjualan $penjualan): void
    {
        //
    }

    /**
     * Handle the Penjualan "force deleted" event.
     */
    public function forceDeleted(Penjualan $penjualan): void
    {
        //
    }
}
