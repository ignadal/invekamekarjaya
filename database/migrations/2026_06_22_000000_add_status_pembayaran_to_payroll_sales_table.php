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
            $table->enum('status_pembayaran', ['belum', 'sudah_digaji'])->default('belum')->after('total_gaji');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payroll_sales', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
        });
    }
};
