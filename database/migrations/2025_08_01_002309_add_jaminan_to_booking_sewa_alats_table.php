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
            // Cek dan hapus kolom jam_mulai dan jam_selesai jika ada
            if (Schema::hasColumn('booking_sewa_alats', 'jam_mulai')) {
                $table->dropColumn('jam_mulai');
            }
            if (Schema::hasColumn('booking_sewa_alats', 'jam_selesai')) {
                $table->dropColumn('jam_selesai');
            }
            
            // Tambah kolom jaminan
            $table->enum('jenis_jaminan', ['ktp', 'sim'])->nullable()->after('nomor_telepon');
            $table->string('foto_jaminan')->nullable()->after('jenis_jaminan');
            
            // Tambah kolom untuk status pengembalian alat
            $table->boolean('alat_dikembalikan')->default(false)->after('status_pembayaran');
            $table->timestamp('tanggal_pengembalian')->nullable()->after('alat_dikembalikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_sewa_alats', function (Blueprint $table) {
            // Kembalikan kolom jam jika tidak ada
            if (!Schema::hasColumn('booking_sewa_alats', 'jam_mulai')) {
                $table->time('jam_mulai')->after('tanggal_sewa');
            }
            if (!Schema::hasColumn('booking_sewa_alats', 'jam_selesai')) {
                $table->time('jam_selesai')->after('jam_mulai');
            }
            
            // Hapus kolom jaminan
            $table->dropColumn(['jenis_jaminan', 'foto_jaminan', 'alat_dikembalikan', 'tanggal_pengembalian']);
        });
    }
};
