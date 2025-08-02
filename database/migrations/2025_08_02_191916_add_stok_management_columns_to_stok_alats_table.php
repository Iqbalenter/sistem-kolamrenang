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
            // Tambah kolom untuk manajemen stok
            $table->integer('stok_minimum')->default(0)->after('stok_tersedia'); // Stok minimum untuk alert
            $table->integer('stok_maksimum')->nullable()->after('stok_minimum'); // Stok maksimum yang diizinkan
            $table->string('satuan')->default('pcs')->after('stok_maksimum'); // Satuan stok (pcs, set, dll)
            
            // Tambah kolom untuk tracking maintenance
            $table->date('tanggal_maintenance_terakhir')->nullable()->after('harga_beli');
            $table->date('tanggal_maintenance_selanjutnya')->nullable()->after('tanggal_maintenance_terakhir');
            $table->text('catatan_maintenance')->nullable()->after('tanggal_maintenance_selanjutnya');
            
            // Tambah kolom untuk supplier
            $table->string('supplier')->nullable()->after('catatan_maintenance');
            $table->string('nomor_kontak_supplier')->nullable()->after('supplier');
            
            // Tambah kolom untuk status
            $table->enum('status_stok', ['tersedia', 'habis', 'maintenance', 'rusak'])->default('tersedia')->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_alats', function (Blueprint $table) {
            $table->dropColumn([
                'stok_minimum',
                'stok_maksimum', 
                'satuan',
                'tanggal_maintenance_terakhir',
                'tanggal_maintenance_selanjutnya',
                'catatan_maintenance',
                'supplier',
                'nomor_kontak_supplier',
                'status_stok'
            ]);
        });
    }
};
