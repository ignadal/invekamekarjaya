<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sales;
use App\Models\Buyer;
use App\Models\Penjualan;
use App\Models\CicilanBuyer;
use App\Models\KunjunganSales;
use App\Models\Kecamatan;
use Carbon\Carbon;

class DummySales1Seeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'userapp@gmail.com')->orWhere('name', 'Sales 1')->first();
        if (!$user) {
            echo "User sales1 tidak ditemukan.\n";
            return;
        }

        $sales = Sales::where('user_id', $user->id)->first();
        if (!$sales) {
            echo "Data Sales untuk sales1 tidak ditemukan di tabel sales.\n";
            return;
        }

        $salesId = $sales->id;
        
        $kecamatan = Kecamatan::first();
        $kecamatanId = $kecamatan ? $kecamatan->id : null;

        // Buat atau ambil beberapa buyer
        $buyers = [];
        for ($i = 1; $i <= 5; $i++) {
            $buyers[] = Buyer::firstOrCreate(
                ['nama_toko' => "Toko Dummy $i"],
                [
                    'kecamatan_id' => $kecamatanId,
                    'nama_owner' => "Owner $i",
                    'no_hp' => '0812' . rand(10000000, 99999999),
                    'alamat' => "Jl. Dummy No $i",
                    'catatan' => 'dummy buyer'
                ]
            );
        }

        // Generate Kunjungan (Bulan ini & Bulan lalu)
        foreach ([Carbon::now(), Carbon::now()->subMonth()] as $date) {
            for ($i = 0; $i < 10; $i++) {
                KunjunganSales::create([
                    'sales_id' => $salesId,
                    'buyer_id' => $buyers[array_rand($buyers)]->id,
                    'tanggal_kunjungan' => $date->copy()->startOfMonth()->addDays(rand(0, 25)),
                    'hasil_kunjungan' => 'Order',
                    'catatan' => 'Kunjungan dummy'
                ]);
            }
        }

        // Generate Penjualan (Bulan ini)
        $totalsThisMonth = [25000000, 20000000, 30000000, 10000000];
        
        foreach ($totalsThisMonth as $index => $total) {
            $buyer = $buyers[$index];
            $tglBeli = Carbon::now()->startOfMonth()->addDays(rand(1, 25));
            
            $penjualan = Penjualan::create([
                'sales_id' => $salesId,
                'buyer_id' => $buyer->id,
                'tanggal_beli' => $tglBeli,
                'total_penjualan' => $total,
                'sisa_pembayaran' => $total,
                'sudah_dibayar' => 0,
                'status_bayar' => 'belum_dibayar',
                'status_persetujuan' => 'disetujui',
                'metode_pembayaran' => 'transfer'
            ]);

            // Cicilan 1 (semua bayar cicilan)
            $nominalCicilan1 = $total * 0.5; // 50% dibayar
            CicilanBuyer::create([
                'penjualan_id' => $penjualan->id,
                'nominal' => $nominalCicilan1,
                'tanggal_bayar' => $tglBeli->copy()->addDays(2),
                'catatan' => 'DP'
            ]);

            // Cicilan 2 (Untuk sebagian transaksi)
            if ($index % 2 == 0) {
                $nominalCicilan2 = $total * 0.4; // 40% lagi dibayar
                CicilanBuyer::create([
                    'penjualan_id' => $penjualan->id,
                    'nominal' => $nominalCicilan2,
                    'tanggal_bayar' => $tglBeli->copy()->addDays(7),
                    'catatan' => 'Cicilan kedua'
                ]);
                $penjualan->update([
                    'sudah_dibayar' => $nominalCicilan1 + $nominalCicilan2,
                    'sisa_pembayaran' => $total - ($nominalCicilan1 + $nominalCicilan2)
                ]);
            } else {
                $penjualan->update([
                    'sudah_dibayar' => $nominalCicilan1,
                    'sisa_pembayaran' => $total - $nominalCicilan1
                ]);
            }
        }

        // Penjualan bulan lalu (untuk hitung tren)
        $totalsLastMonth = [15000000, 20000000, 10000000];
        foreach ($totalsLastMonth as $index => $total) {
            $buyer = $buyers[$index];
            $tglBeli = Carbon::now()->subMonth()->startOfMonth()->addDays(rand(1, 25));
            
            $penjualan = Penjualan::create([
                'sales_id' => $salesId,
                'buyer_id' => $buyer->id,
                'tanggal_beli' => $tglBeli,
                'total_penjualan' => $total,
                'sisa_pembayaran' => $total,
                'sudah_dibayar' => 0,
                'status_bayar' => 'belum_dibayar',
                'status_persetujuan' => 'disetujui',
                'metode_pembayaran' => 'transfer'
            ]);

            // Cicilan 1
            $nominalCicilan1 = $total * 0.6; 
            CicilanBuyer::create([
                'penjualan_id' => $penjualan->id,
                'nominal' => $nominalCicilan1,
                'tanggal_bayar' => $tglBeli->copy()->addDays(5),
                'catatan' => 'DP Lama'
            ]);
            $penjualan->update([
                'sudah_dibayar' => $nominalCicilan1,
                'sisa_pembayaran' => $total - $nominalCicilan1
            ]);
        }

        echo "Berhasil membuat dummy data (Penjualan, Kunjungan, Pembayaran) untuk Sales 1!\n";
    }
}
