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
        Schema::table('payroll_sales', function (Blueprint $table) {
            $table->integer('hari_kerja')->default(0)->after('gaji_pokok');
            $table->decimal('uang_makan_harian', 15, 2)->default(0)->after('hari_kerja');
            $table->decimal('uang_bensin_harian', 15, 2)->default(0)->after('uang_makan_harian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payroll_sales', function (Blueprint $table) {
            $table->dropColumn(['hari_kerja', 'uang_makan_harian', 'uang_bensin_harian']);
        });
    }
};
