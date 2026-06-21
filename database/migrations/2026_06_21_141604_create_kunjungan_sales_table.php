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
       Schema::create('kunjungan_sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sales_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('buyer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('tanggal_kunjungan');

            $table->text('hasil_kunjungan')->nullable();

            $table->text('catatan')->nullable();

            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan_sales');
    }
};
