<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('penjualans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sales_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('buyer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('tanggal_beli');

            $table->string('foto_nota')->nullable();

            $table->enum('metode', [
                'lunas',
                'cicil',
            ]);

            $table->enum('metode_pembayaran', [
                'cash',
                'transfer',
            ]);

            $table->date('jatuh_tempo')->nullable();

            $table->decimal('sudah_dibayar', 15, 2)->default(0);

            $table->decimal('sisa_pembayaran', 15, 2)->default(0);

            $table->decimal('total_penjualan', 15, 2)->default(0);

            $table->enum('status_bayar', [
                'lunas',
                'sebagian',
                'belum_dibayar',
            ])->default('belum_dibayar');

            $table->enum('status_persetujuan', [
                'pending',
                'disetujui',
                'ditolak',
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
