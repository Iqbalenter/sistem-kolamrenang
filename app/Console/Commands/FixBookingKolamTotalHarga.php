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
    protected $description = 'Memperbaiki total harga yang bermasalah pada booking kolam renang';

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
                  ->orWhere('tarif_per_jam', 0)
                  ->orWhere('tarif_per_jam', null);
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
            $this->info("  - Jam Mulai: {$booking->jam_mulai}");
            $this->info("  - Jam Selesai: {$booking->jam_selesai}");
            
            // Hitung ulang durasi
            $jamMulai = \Carbon\Carbon::parse($booking->jam_mulai);
            $jamSelesai = \Carbon\Carbon::parse($booking->jam_selesai);
            
            $this->info("  - Jam Mulai (parsed): {$jamMulai->format('H:i:s')}");
            $this->info("  - Jam Selesai (parsed): {$jamSelesai->format('H:i:s')}");
            
            // Jika jam_selesai lebih awal dari jam_mulai, tukar posisinya
            if ($jamSelesai->lt($jamMulai)) {
                $this->info("  ⚠️  Jam selesai lebih awal dari jam mulai, menukar posisi...");
                $tempJam = $jamMulai;
                $jamMulai = $jamSelesai;
                $jamSelesai = $tempJam;
                
                // Update jam_mulai dan jam_selesai di database
                $booking->update([
                    'jam_mulai' => $jamMulai->format('H:i:s'),
                    'jam_selesai' => $jamSelesai->format('H:i:s')
                ]);
                
                $this->info("  - Jam Mulai (setelah tukar): {$jamMulai->format('H:i:s')}");
                $this->info("  - Jam Selesai (setelah tukar): {$jamSelesai->format('H:i:s')}");
            }
            
            // Hitung durasi dengan cara yang lebih akurat
            $durasi = $jamSelesai->diffInHours($jamMulai);
            
            // Jika durasi masih negatif, gunakan cara alternatif
            if ($durasi < 0) {
                $this->info("  ⚠️  Durasi masih negatif, menggunakan perhitungan manual...");
                $startTime = strtotime($jamMulai->format('H:i:s'));
                $endTime = strtotime($jamSelesai->format('H:i:s'));
                $durasi = ($endTime - $startTime) / 3600; // Konversi ke jam
            }
            
            $this->info("  - Durasi: {$durasi} jam");
            
            // Dapatkan tarif per jam
            $tarifPerJam = Booking::getTarifByJenisKolam($booking->jenis_kolam);
            
            // Hitung ulang total harga dengan memperhitungkan jumlah orang
            $totalHarga = $durasi * $tarifPerJam * $booking->jumlah_orang;

            // Update booking
            $booking->update([
                'tarif_per_jam' => $tarifPerJam,
                'total_harga' => $totalHarga
            ]);

            $this->info("  ✓ Total harga diperbaiki: Rp " . number_format($totalHarga, 0, ',', '.'));
            $this->info("    - Durasi: {$durasi} jam");
            $this->info("    - Tarif per jam: Rp " . number_format($tarifPerJam, 0, ',', '.'));
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