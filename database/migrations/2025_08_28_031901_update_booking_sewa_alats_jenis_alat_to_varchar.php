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
        Schema::table('booking_sewa_alats', function (Blueprint $table) {
            // Ubah kolom jenis_alat dari enum ke varchar untuk mendukung jenis alat dinamis
            $table->string('jenis_alat', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_sewa_alats', function (Blueprint $table) {
            // Kembalikan ke enum dengan nilai yang lama
            $table->enum('jenis_alat', [
                'ban_renang', 
                'kacamata_renang', 
                'papan_renang', 
                'pelampung', 
                'fins', 
                'snorkel'
            ])->default('ban_renang')->change();
        });
    }
};
