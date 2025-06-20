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
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('jenis_kolam', ['kolam_anak', 'kolam_utama'])->default('kolam_utama')->after('jumlah_orang');
            $table->decimal('tarif_per_jam', 10, 2)->after('jenis_kolam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['jenis_kolam', 'tarif_per_jam']);
        });
    }
};
