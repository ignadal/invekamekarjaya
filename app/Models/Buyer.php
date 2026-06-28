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
        'foto_toko',
        'jam_buka',
        'jam_tutup',
        'hari_operasional',
        'nama_owner',
        'no_hp',
        'alamat',
        'catatan',
    ];

    protected $casts = [
        'foto_toko' => 'array',
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