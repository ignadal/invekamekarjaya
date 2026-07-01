<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    protected $fillable = [
        'sales_id',
        'buyer_id',
        'tanggal_beli',
        'foto_nota',
        'metode',
        'metode_pembayaran',
        'jatuh_tempo',
        'sudah_dibayar',
        'sisa_pembayaran',
        'total_penjualan',
        'status_bayar',
        'status_persetujuan',
    ];

    protected $casts = [
        'tanggal_beli' => 'date',
        'jatuh_tempo' => 'date',
    ];

    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function cicilans(): HasMany
    {
        return $this->hasMany(CicilanBuyer::class);
    }


}