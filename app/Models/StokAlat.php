<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokAlat extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_alat',
        'nama_alat',
        'stok_total',
        'stok_tersedia',
        'harga_sewa',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'harga_sewa' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Method untuk mengurangi stok
    public function kurangiStok($jumlah)
    {
        if ($this->stok_tersedia >= $jumlah) {
            $this->stok_tersedia -= $jumlah;
            $this->save();
            return true;
        }
        return false;
    }

    // Method untuk menambah stok (pengembalian)
    public function tambahStok($jumlah)
    {
        $this->stok_tersedia += $jumlah;
        // Pastikan stok tersedia tidak melebihi stok total
        if ($this->stok_tersedia > $this->stok_total) {
            $this->stok_tersedia = $this->stok_total;
        }
        $this->save();
    }

    // Method untuk mendapatkan label jenis alat
    public function getJenisAlatLabelAttribute()
    {
        return match($this->jenis_alat) {
            'ban_renang' => 'Ban Renang',
            'kacamata_renang' => 'Kacamata Renang',
            'papan_renang' => 'Papan Renang',
            'pelampung' => 'Pelampung',
            'fins' => 'Fins (Kaki Katak)',
            'snorkel' => 'Snorkel',
            default => 'Unknown'
        };
    }

    // Method untuk cek apakah stok tersedia
    public function isStokTersedia($jumlah = 1)
    {
        return $this->is_active && $this->stok_tersedia >= $jumlah;
    }

    // Relationship dengan booking
    public function bookings()
    {
        return $this->hasMany(BookingSewaAlat::class, 'jenis_alat', 'jenis_alat');
    }

    // Static method untuk mendapatkan stok berdasarkan jenis alat
    public static function getStokByJenis($jenisAlat)
    {
        return self::where('jenis_alat', $jenisAlat)->where('is_active', true)->first();
    }

    // Static method untuk mendapatkan harga berdasarkan jenis alat
    public static function getHargaByJenis($jenisAlat)
    {
        $stok = self::getStokByJenis($jenisAlat);
        return $stok ? $stok->harga_sewa : 0;
    }
}
