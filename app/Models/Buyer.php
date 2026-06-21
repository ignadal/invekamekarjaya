<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kecamatan_id',
        'nama_toko',
        'nama_owner',
        'no_hp',
        'alamat',
        'catatan',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class);
    }

    public function kunjunganSales(): HasMany
    {
        return $this->hasMany(KunjunganSales::class);
    }
}