<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokAlat extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_alat_id',
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

    // Relationship dengan JenisAlat
    public function jenisAlat(): BelongsTo
    {
        return $this->belongsTo(JenisAlat::class);
    }

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
        return true;
    }

    // Method untuk mendapatkan label jenis alat
    public function getJenisAlatLabelAttribute()
    {
        return $this->jenisAlat ? $this->jenisAlat->nama : 'Unknown';
    }

    // Method untuk cek apakah stok tersedia
    public function isStokTersedia($jumlah = 1)
    {
        return $this->is_active && $this->stok_tersedia >= $jumlah;
    }

    // Relationship dengan booking
    public function bookings()
    {
        // Relasi melalui jenis alat
        return $this->hasMany(BookingSewaAlat::class, 'jenis_alat', 'kode');
    }

    // Static method untuk mendapatkan stok berdasarkan jenis alat
    public static function getStokByJenis($jenisAlatKode)
    {
        $jenisAlat = JenisAlat::getByKode($jenisAlatKode);
        if (!$jenisAlat) {
            return null;
        }
        return self::where('jenis_alat_id', $jenisAlat->id)
            ->where('is_active', true)
            ->where('stok_tersedia', '>', 0)
            ->first();
    }

    // Static method untuk mendapatkan harga berdasarkan jenis alat
    public static function getHargaByJenis($jenisAlatKode)
    {
        $stok = self::getStokByJenis($jenisAlatKode);
        return $stok ? $stok->harga_sewa : 0;
    }
}
