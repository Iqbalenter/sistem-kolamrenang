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
            // Cek apakah kolom jenis_alat ada sebelum dihapus
            if (Schema::hasColumn('stok_alats', 'jenis_alat')) {
                $table->dropColumn('jenis_alat');
            }
            
            // Tambah kolom jenis_alat_id sebagai foreign key
            if (!Schema::hasColumn('stok_alats', 'jenis_alat_id')) {
                $table->foreignId('jenis_alat_id')->constrained('jenis_alats')->onDelete('cascade');
            }
            
            // Tambah kolom kode_alat untuk identifikasi unik alat (tanpa unique constraint dulu)
            if (!Schema::hasColumn('stok_alats', 'kode_alat')) {
                $table->string('kode_alat')->nullable()->after('jenis_alat_id');
            }
            
            // Tambah kolom kondisi alat
            if (!Schema::hasColumn('stok_alats', 'kondisi')) {
                $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik')->after('stok_tersedia');
            }
            
            // Tambah kolom untuk tracking
            if (!Schema::hasColumn('stok_alats', 'lokasi_penyimpanan')) {
                $table->string('lokasi_penyimpanan')->nullable()->after('kondisi');
            }
            
            if (!Schema::hasColumn('stok_alats', 'tanggal_pembelian')) {
                $table->date('tanggal_pembelian')->nullable()->after('lokasi_penyimpanan');
            }
            
            if (!Schema::hasColumn('stok_alats', 'harga_beli')) {
                $table->decimal('harga_beli', 10, 2)->nullable()->after('tanggal_pembelian');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_alats', function (Blueprint $table) {
            // Hapus foreign key
            if (Schema::hasColumn('stok_alats', 'jenis_alat_id')) {
                $table->dropForeign(['jenis_alat_id']);
                $table->dropColumn('jenis_alat_id');
            }
            
            // Hapus kolom yang ditambahkan
            if (Schema::hasColumn('stok_alats', 'kode_alat')) {
                $table->dropColumn('kode_alat');
            }
            if (Schema::hasColumn('stok_alats', 'kondisi')) {
                $table->dropColumn('kondisi');
            }
            if (Schema::hasColumn('stok_alats', 'lokasi_penyimpanan')) {
                $table->dropColumn('lokasi_penyimpanan');
            }
            if (Schema::hasColumn('stok_alats', 'tanggal_pembelian')) {
                $table->dropColumn('tanggal_pembelian');
            }
            if (Schema::hasColumn('stok_alats', 'harga_beli')) {
                $table->dropColumn('harga_beli');
            }
            
            // Kembalikan kolom jenis_alat yang lama jika belum ada
            if (!Schema::hasColumn('stok_alats', 'jenis_alat')) {
                $table->enum('jenis_alat', ['ban_renang', 'kacamata_renang', 'papan_renang', 'pelampung', 'fins', 'snorkel'])->after('id');
            }
        });
    }
};
