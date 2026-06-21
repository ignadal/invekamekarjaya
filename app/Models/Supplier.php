<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama_supplier',
        'nama_agent',
        'jabatan_agent',
        'no_hp_supplier',
        'no_hp_agent',
        'alamat',
        'catatan',
    ];

    public function pembelianSuppliers(): HasMany
    {
        return $this->hasMany(PembelianSupplier::class);
    }
}