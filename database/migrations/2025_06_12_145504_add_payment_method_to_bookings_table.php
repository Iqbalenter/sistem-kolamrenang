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
            $table->enum('metode_pembayaran', ['transfer_bank', 'e_wallet'])->nullable()->after('bukti_pembayaran');
            $table->string('provider_pembayaran')->nullable()->after('metode_pembayaran'); // BCA, BRI, OVO, DANA, dll
            $table->string('nomor_tujuan')->nullable()->after('provider_pembayaran'); // nomor rekening atau nomor ewallet
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'provider_pembayaran', 'nomor_tujuan']);
        });
    }
};
