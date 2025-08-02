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
        Schema::table('stok_alats', function (Blueprint $table) {
            // Tambah unique constraint pada kode_alat
            $table->unique('kode_alat', 'stok_alats_kode_alat_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_alats', function (Blueprint $table) {
            // Hapus unique constraint
            $table->dropUnique('stok_alats_kode_alat_unique');
        });
    }
};
