<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatHargaJual extends Model
{
    protected $fillable = [
        'barang_id',
        'harga_lama',
        'harga_baru',
        'tanggal_berubah',
    ];

    protected $casts = [
        'tanggal_berubah' => 'date',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
