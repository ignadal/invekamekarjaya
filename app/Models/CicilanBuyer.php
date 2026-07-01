<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CicilanBuyer extends Model
{
    protected $fillable = [
        'penjualan_id',
        'tanggal_bayar',
        'nominal',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class);
    }

    protected static function booted()
    {
        $updatePayroll = function ($cicilan) {
            if ($cicilan->tanggal_bayar && $cicilan->penjualan) {
                $bulan = \Carbon\Carbon::parse($cicilan->tanggal_bayar)->month;
                $tahun = \Carbon\Carbon::parse($cicilan->tanggal_bayar)->year;
                \App\Models\PayrollSales::updatePayroll($cicilan->penjualan->sales_id, $bulan, $tahun);
            }
        };

        static::saved($updatePayroll);
        static::deleted($updatePayroll);
    }
}