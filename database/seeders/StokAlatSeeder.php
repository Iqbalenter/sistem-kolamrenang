<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StokAlat;
use App\Models\JenisAlat;

class StokAlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisAlats = JenisAlat::all();
        
        foreach ($jenisAlats as $jenisAlat) {
            StokAlat::create([
                'jenis_alat_id' => $jenisAlat->id,
                'nama_alat' => $jenisAlat->nama,
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'harga_sewa' => $this->getDefaultHarga($jenisAlat->kode),
                'deskripsi' => $jenisAlat->deskripsi,
                'is_active' => true
            ]);
        }
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
