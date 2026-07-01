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
        'hari_kerja',
        'tanggal_kehadiran',
        'uang_makan_harian',
        'uang_bensin_harian',
        'total_gaji',
        'status_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kehadiran' => 'array',
    ];

    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }

    public static function updatePayroll($salesId, $bulan, $tahun)
    {
        $totalPenjualan = \App\Models\CicilanBuyer::whereHas('penjualan', function ($query) use ($salesId) {
                $query->where('sales_id', $salesId);
            })
            ->whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->sum('nominal');
            
        $bonusPersen = 0;
        if ($totalPenjualan >= 100000000) {
            $bonusPersen = 1;
        } elseif ($totalPenjualan >= 75000000) {
            $bonusPersen = 0.5;
        }
        
        $bonusNominal = ($totalPenjualan * $bonusPersen) / 100;
        
        $payroll = self::where('sales_id', $salesId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();
            
        if ($payroll) {
            $totalMakan = $payroll->hari_kerja * $payroll->uang_makan_harian;
            $totalBensin = $payroll->hari_kerja * $payroll->uang_bensin_harian;
            
            $payroll->update([
                'total_penjualan' => $totalPenjualan,
                'bonus_persen' => $bonusPersen,
                'bonus_nominal' => $bonusNominal,
                'uang_makan' => $totalMakan,
                'uang_bensin' => $totalBensin,
                'total_gaji' => $payroll->gaji_pokok + $bonusNominal + $totalMakan + $totalBensin,
            ]);
        }
    }
}