<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayrollSales;
use App\Models\Penjualan;
use App\Models\PembelianSupplier;
use App\Models\Sales;
use App\Models\Buyer;
use App\Models\Barang;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinalFixSeeder extends Seeder
{
    public function run()
    {
        // 1. Fix PayrollSales Tunjangan (Kurangi pengeluaran agar laba lebih mudah tercapai)
        $payrolls = PayrollSales::all();
        foreach($payrolls as $p) {
            $hariKerja = rand(15, 20); // Kurangi hari kerja
            $makan = 30000; // Kurangi allowance harian
            $bensin = 10000;
            
            $tanggalList = [];
            for($i=1; $i<=$hariKerja; $i++) {
                $t = Carbon::create($p->tahun, $p->bulan, $i)->toDateString();
                $tanggalList[] = [
                    'tanggal' => $t,
                    'uang_makan' => $makan,
                    'uang_bensin' => $bensin
                ];
            }
            
            $p->update([
                'hari_kerja' => $hariKerja,
                'uang_makan_harian' => $makan,
                'uang_bensin_harian' => $bensin,
                'uang_makan' => $hariKerja * $makan,
                'uang_bensin' => $hariKerja * $bensin,
                'tanggal_kehadiran' => $tanggalList,
                'total_gaji' => $p->gaji_pokok + ($hariKerja * $makan) + ($hariKerja * $bensin) + $p->bonus_nominal
            ]);
        }
        echo "Payroll fixed! Riwayat tunjangan ditambahkan & besaran tunjangan dikurangi.\n";

        // 2. Ensure Penjualan > Pengeluaran per month
        $salesList = Sales::all();
        $buyers = Buyer::all();
        $supplier = Supplier::first();
        
        for ($month = 1; $month <= 7; $month++) {
            $year = 2026;
            
            $pengeluaranPembelian = PembelianSupplier::whereYear('tanggal_pembelian', $year)
                ->whereMonth('tanggal_pembelian', $month)
                ->sum('total_pembelian');
                
            $pengeluaranGaji = PayrollSales::where('tahun', $year)
                ->where('bulan', $month)
                ->sum('total_gaji');
            
            $totalPengeluaran = $pengeluaranPembelian + $pengeluaranGaji;
            
            $currentPenjualan = Penjualan::whereYear('tanggal_beli', $year)
                ->whereMonth('tanggal_beli', $month)
                ->sum('total_penjualan');
                
            // Target margin 10 juta minimal 
            $targetPenjualan = max($totalPengeluaran * 1.3, $currentPenjualan + 10000000);
            
            if ($currentPenjualan < $targetPenjualan) {
                $kekurangan = $targetPenjualan - $currentPenjualan;
                echo "Bulan $month kurang $kekurangan. Menambahkan Penjualan...\n";
                
                // Jual partai besar untuk nutup target
                $barangs = Barang::inRandomOrder()->take(3)->get(); 
                
                $totalBelanja = 0;
                $details = [];
                $detailsPembelian = [];
                
                foreach ($barangs as $barang) {
                    // Cari berapa qty untuk nutup 1/3 dari kekurangan
                    $targetPerItem = $kekurangan / 3;
                    $qty = (int) ceil($targetPerItem / $barang->harga_jual);
                    if ($qty < 10) $qty = 50;
                    
                    $subtotal = $qty * $barang->harga_jual;
                    $totalBelanja += $subtotal;
                    
                    // Kita buat riwayat Pembelian dummy dengan harga_beli lebih murah (biar tidak rugi)
                    // Sehingga stok aman, laba bersih juga bertambah!
                    $hargaBeli = $barang->harga_jual * 0.7; // margin 30%
                    
                    $detailsPembelian[] = [
                        'barang_id' => $barang->id,
                        'qty' => $qty,
                        'harga_beli' => $hargaBeli,
                        'subtotal' => $qty * $hargaBeli,
                    ];
                    
                    $details[] = [
                        'barang_id' => $barang->id,
                        'qty' => $qty,
                        'harga_jual' => $barang->harga_jual,
                        'subtotal' => $subtotal,
                    ];
                }
                
                // Tambah stok dari supplier (Backdate ke awal bulan) agar tidak minus saat dijual
                $subtotalBeliTotal = array_sum(array_column($detailsPembelian, 'subtotal'));
                $pembelian = PembelianSupplier::create([
                    'supplier_id' => $supplier->id,
                    'tanggal_pembelian' => Carbon::create($year, $month, 1),
                    'metode' => 'lunas',
                    'sudah_dibayar' => $subtotalBeliTotal, 
                    'sisa_pembayaran' => 0,
                    'total_pembelian' => $subtotalBeliTotal,
                    'status' => 'lunas',
                    'created_at' => Carbon::create($year, $month, 1),
                    'updated_at' => Carbon::create($year, $month, 1),
                ]);
                foreach ($detailsPembelian as $dp) {
                    $pembelian->details()->create(array_merge($dp, [
                        'created_at' => Carbon::create($year, $month, 1),
                        'updated_at' => Carbon::create($year, $month, 1),
                    ]));
                }
                
                // Buat penjualan
                $penjualan = Penjualan::create([
                    'sales_id' => $salesList->random()->id,
                    'buyer_id' => $buyers->random()->id,
                    'tanggal_beli' => Carbon::create($year, $month, 15),
                    'metode' => 'lunas',
                    'metode_pembayaran' => 'transfer',
                    'jatuh_tempo' => null,
                    'sudah_dibayar' => $totalBelanja,
                    'sisa_pembayaran' => 0,
                    'total_penjualan' => $totalBelanja,
                    'status_bayar' => 'lunas',
                    'status_persetujuan' => 'pending',
                    'created_at' => Carbon::create($year, $month, 15),
                    'updated_at' => Carbon::create($year, $month, 15),
                ]);
                
                foreach ($details as $det) {
                    $penjualan->details()->create(array_merge($det, [
                        'created_at' => Carbon::create($year, $month, 15),
                        'updated_at' => Carbon::create($year, $month, 15),
                    ]));
                }
                
                $penjualan->status_persetujuan = 'disetujui';
                $penjualan->save(); // decrements stock properly!
                
                $penjualan->cicilans()->create([
                    'tanggal_bayar' => Carbon::create($year, $month, 15),
                    'nominal' => $totalBelanja,
                    'catatan' => 'Pembayaran lunas tambahan (Proyek Besar)',
                    'created_at' => Carbon::create($year, $month, 15),
                    'updated_at' => Carbon::create($year, $month, 15),
                ]);
                
                echo "Selesai bulan $month. Ditambah: $totalBelanja\n";
            } else {
                echo "Bulan $month sudah surplus.\n";
            }
        }
    }
}
