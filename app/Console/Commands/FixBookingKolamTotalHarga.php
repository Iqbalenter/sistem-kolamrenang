<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class FixBookingKolamTotalHarga extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:fix-kolam-total-harga';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbaiki total harga pada booking kolam renang (sistem harian)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perbaikan total harga pada booking kolam renang...');

        // Ambil semua booking yang total harganya 0, null, tidak valid, atau negatif
        $bookings = Booking::where(function($query) {
            $query->where('total_harga', 0)
                  ->orWhere('total_harga', null)
                  ->orWhere('total_harga', '')
                  ->orWhere('total_harga', '<', 0)
                  ->orWhere('tarif_harian', 0)
                  ->orWhere('tarif_harian', null);
        })->get();

        $this->info("Total booking yang perlu diperbaiki: {$bookings->count()}");

        if ($bookings->count() === 0) {
            $this->info('Tidak ada booking yang perlu diperbaiki!');
            return 0;
        }

        $fixedCount = 0;
        $errorCount = 0;

        foreach ($bookings as $booking) {
            $this->info("Memperbaiki booking ID: {$booking->id}");
            $this->info("  - Tanggal: {$booking->tanggal_booking->format('d/m/Y')}");
            $this->info("  - Jumlah Orang: {$booking->jumlah_orang}");
            
            // Dapatkan tarif harian berdasarkan jenis kolam
            $tarifHarian = Booking::getTarifHarianByJenisKolam($booking->jenis_kolam);
            
            // Hitung total harga sistem harian: tarif_harian × jumlah_orang
            $totalHarga = $tarifHarian * $booking->jumlah_orang;

            // Update booking dengan sistem harian
            $booking->update([
                'tarif_harian' => $tarifHarian,
                'total_harga' => $totalHarga
            ]);

            $this->info("  ✓ Total harga diperbaiki: Rp " . number_format($totalHarga, 0, ',', '.'));
            $this->info("    - Sistem: Harian (06:00-18:00)");
            $this->info("    - Tarif harian: Rp " . number_format($tarifHarian, 0, ',', '.'));
            $this->info("    - Jumlah orang: {$booking->jumlah_orang}");
            $fixedCount++;
        }

        $this->info("\nPerbaikan selesai!");
        $this->info("Total booking yang diperbaiki: {$fixedCount}");
        if ($errorCount > 0) {
            $this->error("Total booking yang gagal diperbaiki: {$errorCount}");
        }

        return 0;
    }
} 