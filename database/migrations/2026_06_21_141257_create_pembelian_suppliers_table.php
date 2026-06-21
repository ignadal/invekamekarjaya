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
       Schema::create('pembelian_suppliers', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_pembelian');

            $table->foreignId('supplier_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('metode', [
                'lunas',
                'nyicil',
            ]);

            $table->date('jatuh_tempo')->nullable();

            $table->decimal('sudah_dibayar', 15, 2)->default(0);
            $table->decimal('sisa_pembayaran', 15, 2)->default(0);

            $table->decimal('total_pembelian', 15, 2)->default(0);

            $table->enum('status', [
                'lunas',
                'sebagian',
                'belum_dibayar',
            ])->default('belum_dibayar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_suppliers');
    }
};
