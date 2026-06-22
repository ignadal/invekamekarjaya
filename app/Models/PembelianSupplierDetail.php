<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembelianSupplierDetail extends Model
{
    protected $fillable = [
        'pembelian_supplier_id',
        'barang_id',
        'qty',
        'harga_beli',
        'subtotal',
    ];

    public function pembelianSupplier(): BelongsTo
    {
        return $this->belongsTo(PembelianSupplier::class);
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    protected static function booted()
    {
        static::saved(function ($detail) {
            if ($detail->barang_id && $detail->harga_beli) {
                // Update harga_beli_terakhir directly without triggering model events that might do other things unnecessary here
                \App\Models\Barang::where('id', $detail->barang_id)->update([
                    'harga_beli_terakhir' => $detail->harga_beli
                ]);
            }
        });
    }
}