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
        'hari_buka',
        'hari_bukaakhir',
        'nama_owner',
        'no_hp',
        'alamat',
        'catatan',
    ];

    protected $casts = [
        // 'foto_toko' => 'array',
    ];

    protected function fotoToko(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value) {
                if (!$value) return null;
                $decoded = json_decode($value, true);
                if (is_array($decoded)) {
                    return count($decoded) > 0 ? array_values($decoded)[0] : null;
                }
                return $decoded;
            },
            set: function ($value) {
                if (!$value) return null;
                return json_encode(is_array($value) ? array_values($value) : [$value]);
            },
        );
    }

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