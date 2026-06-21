<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $fillable = [
        'nama_kecamatan',
    ];

    public function buyers(): HasMany
    {
        return $this->hasMany(Buyer::class);
    }
}