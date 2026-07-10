<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sales;
use App\Models\Buyer;
use App\Models\Barang;
use App\Models\PembelianSupplier;
use App\Models\Supplier;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;
use Carbon\Carbon;

class SeedFixLabaRequest extends Seeder
{
    public function run()
    {
        $salesList = Sales::all();
        $buyers = Buyer::all();
        $barangs = Barang::all();
        
        if ($salesList->isEmpty() || $buyers->isEmpty() || $barangs->isEmpty()) {
            echo "Data tidak mencukupi!\n";
            return;
        }

        for ($month = 1; $month <= 7; $month++) {
            $year = 2026;
            
            // Pengeluaran
            $pengeluaranPembelian = PembelianSupplier::whereYear('tanggal_pembelian', $year)
                ->whereMonth('tanggal_pembelian', $month)
                ->sum('total_pembelian');
                
            $totalGajiPokok = $salesList->sum('gaji_pokok');
            $estimasiUangMakan = $salesList->count() * (25 * 50000); 
            $pengeluaranGaji = $totalGajiPokok + $estimasiUangMakan;
            
            $totalPengeluaran = $pengeluaranPembelian + $pengeluaranGaji;
            
            // Current Penjualan
            $currentPenjualan = Penjualan::whereYear('tanggal_beli', $year)
                ->whereMonth('tanggal_beli', $month)
                ->sum('total_penjualan');
                
            $targetPenjualan = $totalPengeluaran * 1.3;
            
            if ($currentPenjualan < $targetPenjualan) {
                $kekurangan = $targetPenjualan - $currentPenjualan;
                echo "Bulan $month kurang $kekurangan. Menambahkan Penjualan...\n";
                
                $added = 0;
                while ($added < $kekurangan) {
                    $sales = $salesList->random();
                    $buyer = $buyers->random();
                    
                    $maxDays = Carbon::create($year, $month, 1)->daysInMonth;
                    if ($month == 7) {
                        $maxDays = min($maxDays, Carbon::now()->day);
                    }
                    $tanggalBeli = Carbon::create($year, $month, rand(1, $maxDays));
                    
                    // Pick 2-5 items
                    $selectedBarangs = Barang::inRandomOrder()->take(rand(2, 5))->get();
                    
                    $totalBelanja = 0;
                    $details = [];
                    
                    foreach ($selectedBarangs as $barang) {
                        $qty = rand(5, 15);
                        
                        // ONLY sell if stock > qty to prevent going negative!
                        if ($barang->stok > $qty) {
                            $subtotal = $qty * $barang->harga_jual;
                            $totalBelanja += $subtotal;
                            
                            $details[] = [
                                'barang_id' => $barang->id,
                                'qty' => $qty,
                                'harga_jual' => $barang->harga_jual,
                                'subtotal' => $subtotal,
                            ];
                        }
                    }
                    
                    if ($totalBelanja > 0) {
                        $penjualan = Penjualan::create([
                            'sales_id' => $sales->id,
                            'buyer_id' => $buyer->id,
                            'tanggal_beli' => $tanggalBeli,
                            'metode' => 'lunas',
                            'metode_pembayaran' => 'transfer',
                            'jatuh_tempo' => null,
                            'sudah_dibayar' => $totalBelanja,
                            'sisa_pembayaran' => 0,
                            'total_penjualan' => $totalBelanja,
                            'status_bayar' => 'lunas',
                            'status_persetujuan' => 'pending',
                            'created_at' => $tanggalBeli,
                            'updated_at' => $tanggalBeli,
                        ]);
                        
                        foreach ($details as $det) {
                            $penjualan->details()->create(array_merge($det, [
                                'created_at' => $tanggalBeli,
                                'updated_at' => $tanggalBeli,
                            ]));
                        }
                        
                        $penjualan->status_persetujuan = 'disetujui';
                        $penjualan->save(); // decrements stock properly!
                        
                        $penjualan->cicilans()->create([
                            'tanggal_bayar' => $tanggalBeli,
                            'nominal' => $totalBelanja,
                            'catatan' => 'Pembayaran lunas tambahan',
                            'created_at' => $tanggalBeli,
                            'updated_at' => $tanggalBeli,
                        ]);
                        
                        $added += $totalBelanja;
                    }
                }
                echo "Selesai bulan $month. Ditambah: $added\n";
            } else {
                echo "Bulan $month sudah surplus.\n";
            }
        }
    }
}
