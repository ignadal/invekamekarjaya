<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollSales extends Model
{
    protected $fillable = [
        'sales_id',
        'bulan',
        'tahun',
        'total_penjualan',
        'bonus_persen',
        'bonus_nominal',
        'gaji_pokok',
        'uang_makan',
        'uang_bensin',
        'total_gaji',
        'catatan',
    ];

    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }
}