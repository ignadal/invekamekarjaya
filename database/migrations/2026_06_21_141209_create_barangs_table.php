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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_barang_id')
                ->constrained('kategori_barangs');

            $table->string('nama_barang');

            $table->decimal('harga_jual', 15, 2)->default(0);

            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(0);

            $table->string('foto')->nullable();

            $table->text('deskripsi')->nullable();

            $table->enum('ukuran', [
                'kecil',
                'sedang',
                'besar',
            ])->nullable();

            $table->enum('berat', [
                'ringan',
                'sedang',
                'berat',
            ])->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
