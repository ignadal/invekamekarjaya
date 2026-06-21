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
       Schema::create('payroll_sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sales_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('bulan');

            $table->integer('tahun');

            $table->decimal('total_penjualan', 15, 2)->default(0);

            $table->decimal('bonus_persen', 5, 2)->default(0);

            $table->decimal('bonus_nominal', 15, 2)->default(0);

            $table->decimal('gaji_pokok', 15, 2)->default(0);

            $table->decimal('uang_makan', 15, 2)->default(0);

            $table->decimal('uang_bensin', 15, 2)->default(0);

            $table->decimal('total_gaji', 15, 2)->default(0);

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_sales');
    }
};
