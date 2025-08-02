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
            // Tambah kolom yang belum ada terlebih dahulu
            if (!Schema::hasColumn('booking_sewa_alats', 'foto_identitas')) {
                $table->string('foto_identitas')->nullable()->after('foto_jaminan');
            }
            if (!Schema::hasColumn('booking_sewa_alats', 'jenis_identitas')) {
                $table->string('jenis_identitas')->nullable()->after('foto_identitas');
            }
            if (!Schema::hasColumn('booking_sewa_alats', 'nilai_jaminan')) {
                $table->decimal('nilai_jaminan', 10, 2)->nullable()->after('jenis_identitas');
            }
            if (!Schema::hasColumn('booking_sewa_alats', 'status_pengembalian')) {
                $table->string('status_pengembalian')->nullable()->after('alat_dikembalikan');
            }
            if (!Schema::hasColumn('booking_sewa_alats', 'dikembalikan_at')) {
                $table->timestamp('dikembalikan_at')->nullable()->after('tanggal_pengembalian');
            }
            if (!Schema::hasColumn('booking_sewa_alats', 'stock_alat_id')) {
                $table->unsignedBigInteger('stock_alat_id')->nullable()->after('jenis_alat');
            }
            
            // Ubah kolom yang sudah ada menjadi nullable jika belum
            if (Schema::hasColumn('booking_sewa_alats', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable()->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'provider_pembayaran')) {
                $table->string('provider_pembayaran')->nullable()->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'nomor_tujuan')) {
                $table->string('nomor_tujuan')->nullable()->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'catatan')) {
                $table->text('catatan')->nullable()->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'catatan_admin')) {
                $table->text('catatan_admin')->nullable()->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_sewa_alats', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            if (Schema::hasColumn('booking_sewa_alats', 'foto_identitas')) {
                $table->dropColumn('foto_identitas');
            }
            if (Schema::hasColumn('booking_sewa_alats', 'jenis_identitas')) {
                $table->dropColumn('jenis_identitas');
            }
            if (Schema::hasColumn('booking_sewa_alats', 'nilai_jaminan')) {
                $table->dropColumn('nilai_jaminan');
            }
            if (Schema::hasColumn('booking_sewa_alats', 'status_pengembalian')) {
                $table->dropColumn('status_pengembalian');
            }
            if (Schema::hasColumn('booking_sewa_alats', 'dikembalikan_at')) {
                $table->dropColumn('dikembalikan_at');
            }
            if (Schema::hasColumn('booking_sewa_alats', 'stock_alat_id')) {
                $table->dropColumn('stock_alat_id');
            }
            
            // Kembalikan kolom ke kondisi semula jika diperlukan
            if (Schema::hasColumn('booking_sewa_alats', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'provider_pembayaran')) {
                $table->string('provider_pembayaran')->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'nomor_tujuan')) {
                $table->string('nomor_tujuan')->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'catatan')) {
                $table->text('catatan')->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'catatan_admin')) {
                $table->text('catatan_admin')->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'approved_at')) {
                $table->timestamp('approved_at')->change();
            }
            if (Schema::hasColumn('booking_sewa_alats', 'rejected_at')) {
                $table->timestamp('rejected_at')->change();
            }
        });
    }
};
