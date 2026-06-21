<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    use SoftDeletes;

    protected $table = 'sales';

    protected $fillable = [
        'user_id',
        'nama_sales',
        'no_hp',
        'alamat',
        'gaji_pokok',
        'tanggal_bergabung',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class);
    }

    public function kunjunganSales(): HasMany
    {
        return $this->hasMany(KunjunganSales::class);
    }

    public function payrollSales(): HasMany
    {
        return $this->hasMany(PayrollSales::class);
    }
}