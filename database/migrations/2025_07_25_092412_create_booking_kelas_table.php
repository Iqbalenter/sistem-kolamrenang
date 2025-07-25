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
        Schema::create('booking_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_pemesan');
            $table->string('nomor_telepon');
            $table->date('tanggal_kelas');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('jenis_kelas', ['pemula', 'menengah', 'lanjutan', 'private'])->default('pemula');
            $table->string('instruktur');
            $table->integer('jumlah_peserta')->default(1);
            $table->decimal('harga_per_orang', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->enum('status_pembayaran', ['belum_bayar', 'menunggu_konfirmasi', 'lunas', 'ditolak'])->default('belum_bayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('metode_pembayaran', ['transfer_bank', 'e_wallet'])->nullable();
            $table->string('provider_pembayaran')->nullable();
            $table->string('nomor_tujuan')->nullable();
            $table->text('catatan')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_kelas');
    }
};
