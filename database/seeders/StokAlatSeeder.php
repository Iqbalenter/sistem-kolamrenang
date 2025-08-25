<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StokAlat;

class StokAlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stokAlats = [
            [
                'jenis_alat_id' => 1, // ban_renang
                'nama_alat' => 'Ban Renang Anak',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'harga_sewa' => 15000,
                'deskripsi' => 'Ban renang khusus untuk anak-anak usia 3-12 tahun',
                'is_active' => true
            ],
            [
                'jenis_alat_id' => 2, // kacamata_renang
                'nama_alat' => 'Kacamata Renang Anti Fog',
                'stok_total' => 15,
                'stok_tersedia' => 15,
                'harga_sewa' => 10000,
                'deskripsi' => 'Kacamata renang dengan teknologi anti fog untuk kemudahan berenang',
                'is_active' => true
            ],
            [
                'jenis_alat_id' => 3, // papan_renang
                'nama_alat' => 'Papan Renang Kickboard',
                'stok_total' => 25,
                'stok_tersedia' => 25,
                'harga_sewa' => 20000,
                'deskripsi' => 'Papan renang untuk latihan kicking dan teknik renang',
                'is_active' => true
            ],
            [
                'jenis_alat_id' => 4, // pelampung
                'nama_alat' => 'Pelampung Dewasa',
                'stok_total' => 30,
                'stok_tersedia' => 30,
                'harga_sewa' => 15000,
                'deskripsi' => 'Pelampung keselamatan untuk dewasa, dapat menahan hingga 90kg',
                'is_active' => true
            ],
            [
                'jenis_alat_id' => 5, // fins
                'nama_alat' => 'Fins Kaki Katak',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'harga_sewa' => 25000,
                'deskripsi' => 'Fins untuk meningkatkan kecepatan dan efisiensi berenang',
                'is_active' => true
            ],
            [
                'jenis_alat_id' => 6, // snorkel
                'nama_alat' => 'Snorkel Set',
                'stok_total' => 12,
                'stok_tersedia' => 12,
                'harga_sewa' => 20000,
                'deskripsi' => 'Set snorkel lengkap dengan masker untuk snorkeling',
                'is_active' => true
            ]
        ];

        foreach ($stokAlats as $stok) {
            StokAlat::create($stok);
        }
    }
}
