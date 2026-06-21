<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CicilanSupplier extends Model
{
    protected $fillable = [
        'pembelian_supplier_id',
        'tanggal_bayar',
        'nominal',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function pembelianSupplier(): BelongsTo
    {
        return $this->belongsTo(PembelianSupplier::class);
    }
}