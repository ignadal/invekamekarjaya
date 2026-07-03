<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropColumn('hari_operasional');
            $table->string('hari_buka')->nullable()->after('jam_tutup');
            $table->string('hari_bukaakhir')->nullable()->after('hari_buka');
        });
    }

    public function down(): void
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->string('hari_operasional')->nullable();
            $table->dropColumn(['hari_buka', 'hari_bukaakhir']);
        });
    }
};
