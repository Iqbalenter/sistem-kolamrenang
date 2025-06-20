<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter the ENUM to include 'ditolak'
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status_pembayaran ENUM('belum_bayar', 'menunggu_konfirmasi', 'lunas', 'ditolak') DEFAULT 'belum_bayar'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status_pembayaran ENUM('belum_bayar', 'menunggu_konfirmasi', 'lunas') DEFAULT 'belum_bayar'");
    }
};
