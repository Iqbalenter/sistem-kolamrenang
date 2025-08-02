<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisAlat;

class JenisAlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($jenisAlats as $jenisAlat) {
            JenisAlat::create($jenisAlat);
        }
    }
}
