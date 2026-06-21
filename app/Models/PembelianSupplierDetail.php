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
}