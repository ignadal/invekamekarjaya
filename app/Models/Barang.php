<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_barang_id',
        'nama_barang',
        'harga_jual',
        'harga_beli_terakhir',
        'stok',
        'stok_minimum',
        'foto',
        'deskripsi',
        'ukuran',
        'berat',
    ];

    protected $casts = [
        'harga_jual' => 'decimal:2',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function pembelianDetails(): HasMany
    {
        return $this->hasMany(PembelianSupplierDetail::class);
    }

    public function penjualanDetails(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function riwayatStoks(): HasMany
    {
        return $this->hasMany(RiwayatStok::class);
    }

    public function riwayatHargaJuals(): HasMany
    {
        return $this->hasMany(RiwayatHargaJual::class);
    }

    protected static function booted()
    {
        static::updated(function ($barang) {
            if ($barang->isDirty('harga_jual')) {
                $hargaLama = $barang->getOriginal('harga_jual');
                $hargaBaru = $barang->harga_jual;
                
                // Avoid logging if the price didn't actually change
                if ($hargaLama != $hargaBaru) {
                    $barang->riwayatHargaJuals()->create([
                        'harga_lama' => $hargaLama ?? 0,
                        'harga_baru' => $hargaBaru,
                        'tanggal_berubah' => today(),
                    ]);
                }
            }
        });
    }
}