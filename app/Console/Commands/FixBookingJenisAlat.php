<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingSewaAlat;
use App\Models\JenisAlat;
use App\Models\StokAlat;

class FixBookingJenisAlat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:fix-jenis-alat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbaiki data jenis alat yang bermasalah pada booking sewa alat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perbaikan data jenis alat pada booking sewa alat...');

        // Pastikan data jenis alat tersedia
        if (JenisAlat::count() === 0) {
            $this->error('Tidak ada data jenis alat! Jalankan seeder terlebih dahulu.');
            return 1;
        }

        $bookings = BookingSewaAlat::all();
        $jenisAlats = JenisAlat::all();
        $fixedCount = 0;
        $errorCount = 0;

        $this->info("Total booking yang akan diperiksa: {$bookings->count()}");
        $this->info("Total jenis alat yang tersedia: {$jenisAlats->count()}");

        // Mapping untuk jenis alat yang umum
        $jenisAlatMapping = [
            'ban_renang' => '001',
            'kacamata_renang' => '002',
            'papan_renang' => '003',
            'pelampung' => '004',
            'fins' => '005',
            'snorkel' => '006'
        ];

        foreach ($bookings as $booking) {
            $jenisAlat = JenisAlat::getByKode($booking->jenis_alat);
            
            if (!$jenisAlat) {
                $this->warn("Booking ID {$booking->id}: Jenis alat '{$booking->jenis_alat}' tidak ditemukan");
                
                // Coba mapping dulu
                if (isset($jenisAlatMapping[$booking->jenis_alat])) {
                    $mappedKode = $jenisAlatMapping[$booking->jenis_alat];
                    $jenisAlat = JenisAlat::where('kode', $mappedKode)->first();
                    if ($jenisAlat) {
                        $booking->update(['jenis_alat' => $mappedKode]);
                        $this->info("  ✓ Diperbaiki menggunakan mapping: {$booking->jenis_alat} → {$mappedKode}");
                        $fixedCount++;
                        continue;
                    }
                }
                
                // Jika mapping gagal, gunakan jenis alat pertama
                $firstJenisAlat = $jenisAlats->first();
                if ($firstJenisAlat) {
                    $booking->update(['jenis_alat' => $firstJenisAlat->kode]);
                    $this->info("  ✓ Diperbaiki menggunakan jenis alat pertama: {$booking->jenis_alat} → {$firstJenisAlat->kode}");
                    $fixedCount++;
                } else {
                    $this->error("  ✗ Tidak dapat memperbaiki booking ID {$booking->id}");
                    $errorCount++;
                }
            } else {
                $this->line("Booking ID {$booking->id}: Jenis alat '{$booking->jenis_alat}' sudah benar");
            }
        }

        // Pastikan setiap jenis alat memiliki stok alat
        $this->info("\nMemeriksa stok alat...");
        foreach ($jenisAlats as $jenisAlat) {
            $stokAlat = StokAlat::where('jenis_alat_id', $jenisAlat->id)->first();
            if (!$stokAlat) {
                $stokAlat = StokAlat::create([
                    'jenis_alat_id' => $jenisAlat->id,
                    'nama_alat' => $jenisAlat->nama,
                    'stok_total' => 10,
                    'stok_tersedia' => 10,
                    'harga_sewa' => $this->getDefaultHarga($jenisAlat->kode),
                    'deskripsi' => $jenisAlat->deskripsi,
                    'is_active' => true
                ]);
                $this->info("  ✓ Dibuat stok alat untuk jenis alat: {$jenisAlat->nama}");
            }
        }

        $this->info("\nPerbaikan selesai!");
        $this->info("Total booking yang diperbaiki: {$fixedCount}");
        if ($errorCount > 0) {
            $this->error("Total booking yang gagal diperbaiki: {$errorCount}");
        }

        return 0;
    }

    private function getDefaultHarga($kode)
    {
        return match($kode) {
            '001', 'ban_renang' => 15000,
            '002', 'kacamata_renang' => 10000,
            '003', 'papan_renang' => 20000,
            '004', 'pelampung' => 15000,
            '005', 'fins' => 25000,
            '006', 'snorkel' => 20000,
            default => 15000
        };
    }
} 