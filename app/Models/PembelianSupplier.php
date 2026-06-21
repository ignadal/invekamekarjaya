<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembelianSupplier extends Model
{
    protected $fillable = [
        'tanggal_pembelian',
        'supplier_id',
        'metode',
        'jatuh_tempo',
        'sudah_dibayar',
        'sisa_pembayaran',
        'total_pembelian',
        'status',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'jatuh_tempo' => 'date',
        'total_pembelian' => 'decimal:2',
        'sudah_dibayar' => 'decimal:2',
        'sisa_pembayaran' => 'decimal:2',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(PembelianSupplierDetail::class);
    }

    public function cicilans(): HasMany
    {
        return $this->hasMany(CicilanSupplier::class);
    }

    
}