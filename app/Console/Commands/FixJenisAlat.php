<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JenisAlat;
use App\Models\StokAlat;

class FixJenisAlat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:jenis-alat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbaiki data jenis alat yang bermasalah';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perbaikan data jenis alat...');

        // Data jenis alat yang seharusnya ada
        $jenisAlats = [
            [
                'kode' => 'ban_renang',
                'nama' => 'Ban Renang',
                'deskripsi' => 'Ban renang untuk membantu berenang dan mengapung',
                'is_active' => true
            ],
            [
                'kode' => 'kacamata_renang',
                'nama' => 'Kacamata Renang',
                'deskripsi' => 'Kacamata renang untuk melindungi mata dari air',
                'is_active' => true
            ],
            [
                'kode' => 'papan_renang',
                'nama' => 'Papan Renang',
                'deskripsi' => 'Papan renang untuk latihan teknik renang',
                'is_active' => true
            ],
            [
                'kode' => 'pelampung',
                'nama' => 'Pelampung',
                'deskripsi' => 'Pelampung untuk keselamatan saat berenang',
                'is_active' => true
            ],
            [
                'kode' => 'fins',
                'nama' => 'Fins (Kaki Katak)',
                'deskripsi' => 'Fins untuk latihan teknik kaki dalam berenang',
                'is_active' => true
            ],
            [
                'kode' => 'snorkel',
                'nama' => 'Snorkel',
                'deskripsi' => 'Snorkel untuk berenang sambil melihat bawah air',
                'is_active' => true
            ]
        ];

        $this->info('Menghapus data jenis alat yang ada...');
        // Hapus data satu per satu untuk menghindari foreign key constraint
        StokAlat::query()->delete();
        JenisAlat::query()->delete();

        $this->info('Membuat data jenis alat baru...');
        foreach ($jenisAlats as $jenisAlat) {
            $newJenisAlat = JenisAlat::create($jenisAlat);
            $this->info("  ✓ {$newJenisAlat->nama} ({$newJenisAlat->kode})");

            // Buat stok alat untuk jenis alat ini
            $harga = $this->getDefaultHarga($jenisAlat['kode']);
            StokAlat::create([
                'jenis_alat_id' => $newJenisAlat->id,
                'nama_alat' => $newJenisAlat->nama,
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'harga_sewa' => $harga,
                'deskripsi' => $newJenisAlat->deskripsi,
                'is_active' => true
            ]);
            $this->info("    - Stok alat dibuat dengan harga Rp " . number_format($harga, 0, ',', '.'));
        }

        $this->info("\nPerbaikan selesai!");
        $this->info("Total jenis alat: " . JenisAlat::count());
        $this->info("Total stok alat: " . StokAlat::count());

        return 0;
    }

    private function getDefaultHarga($kode)
    {
        return match($kode) {
            'ban_renang' => 15000,
            'kacamata_renang' => 10000,
            'papan_renang' => 20000,
            'pelampung' => 15000,
            'fins' => 25000,
            'snorkel' => 20000,
            default => 15000
        };
    }
} 