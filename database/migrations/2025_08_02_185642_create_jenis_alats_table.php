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
        Schema::create('jenis_alats', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // kode unik untuk jenis alat
            $table->string('nama'); // nama jenis alat
            $table->text('deskripsi')->nullable(); // deskripsi jenis alat
            $table->boolean('is_active')->default(true); // status aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_alats');
    }
};
