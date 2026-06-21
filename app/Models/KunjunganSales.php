<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KunjunganSales extends Model
{
    protected $fillable = [
        'sales_id',
        'buyer_id',
        'tanggal_kunjungan',
        'hasil_kunjungan',
        'catatan',
        'foto',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }
}