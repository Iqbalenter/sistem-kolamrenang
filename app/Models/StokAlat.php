<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'kode_alat',
        'kondisi',
        'lokasi_penyimpanan',
        'tanggal_pembelian',
        'harga_beli',
        'is_active'
    ];

    protected $casts = [
        'harga_sewa' => 'decimal:2',
        'is_active' => 'boolean',
        'tanggal_pembelian' => 'date'
    ];

    // Relationship dengan JenisAlat
    public function jenisAlat()
    {
        return $this->belongsTo(JenisAlat::class, 'jenis_alat_id');
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
    }

    // Method untuk mendapatkan label jenis alat
    public function getJenisAlatLabelAttribute()
    {
        // Gunakan relationship dengan JenisAlat
        if ($this->jenisAlat) {
            return $this->jenisAlat->nama;
        }

        // Fallback untuk backward compatibility jika masih ada field jenis_alat
        if (isset($this->attributes['jenis_alat'])) {
            return match($this->attributes['jenis_alat']) {
                'ban_renang' => 'Ban Renang',
                'kacamata_renang' => 'Kacamata Renang',
                'papan_renang' => 'Papan Renang',
                'pelampung' => 'Pelampung',
                'fins' => 'Fins (Kaki Katak)',
                'snorkel' => 'Snorkel',
                default => 'Unknown'
            };
        }

        return 'Tidak Diketahui';
    }

    // Method untuk cek apakah stok tersedia
    public function isStokTersedia($jumlah = 1)
    {
        return $this->is_active && $this->stok_tersedia >= $jumlah;
    }

    // Relationship dengan booking (melalui jenis alat)
    public function bookings()
    {
        return $this->hasManyThrough(
            BookingSewaAlat::class,
            JenisAlat::class,
            'id', // foreign key di jenis_alats table
            'jenis_alat', // foreign key di booking_sewa_alats table  
            'jenis_alat_id', // local key di stok_alats table
            'kode' // local key di jenis_alats table
        );
    }

    // Static method untuk mendapatkan stok berdasarkan jenis alat
    public static function getStokByJenis($jenisAlat)
    {
        // Cari berdasarkan kode jenis alat di tabel jenis_alats dengan eager loading
        return self::with('jenisAlat')
            ->whereHas('jenisAlat', function($query) use ($jenisAlat) {
                $query->where('kode', $jenisAlat);
            })
            ->where('is_active', true)
            ->first();
    }

    // Static method untuk mendapatkan harga berdasarkan jenis alat
    public static function getHargaByJenis($jenisAlat)
    {
        $stok = self::getStokByJenis($jenisAlat);
        return $stok ? $stok->harga_sewa : 0;
    }
}
