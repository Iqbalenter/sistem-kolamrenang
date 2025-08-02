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
        Schema::create('stok_alats', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_alat', ['ban_renang', 'kacamata_renang', 'papan_renang', 'pelampung', 'fins', 'snorkel']);
            $table->string('nama_alat');
            $table->integer('stok_total')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->decimal('harga_sewa', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_alats');
    }
};
