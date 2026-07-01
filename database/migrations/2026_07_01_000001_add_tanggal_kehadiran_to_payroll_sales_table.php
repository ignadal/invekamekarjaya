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
            $table->json('tanggal_kehadiran')->nullable()->after('hari_kerja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payroll_sales', function (Blueprint $table) {
            $table->dropColumn('tanggal_kehadiran');
        });
    }
};
