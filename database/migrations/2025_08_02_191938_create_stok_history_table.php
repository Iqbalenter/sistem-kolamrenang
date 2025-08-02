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
        Schema::create('stok_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_alat_id')->constrained('stok_alats')->onDelete('cascade');
            $table->enum('tipe_perubahan', ['masuk', 'keluar', 'rusak', 'maintenance', 'penyesuaian']);
            $table->integer('jumlah_sebelum');
            $table->integer('jumlah_sesudah');
            $table->integer('jumlah_perubahan');
            $table->text('keterangan')->nullable();
            $table->string('dilakukan_oleh')->nullable(); // ID user yang melakukan perubahan
            $table->string('referensi')->nullable(); // Referensi dokumen (invoice, booking, dll)
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['stok_alat_id', 'created_at']);
            $table->index('tipe_perubahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_history');
    }
};
