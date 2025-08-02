<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisAlat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationship dengan StokAlat
    public function stokAlats(): HasMany
    {
        return $this->hasMany(StokAlat::class);
    }

    // Relationship dengan BookingSewaAlat
    public function bookingSewaAlats(): HasMany
    {
        return $this->hasMany(BookingSewaAlat::class, 'jenis_alat', 'kode');
    }

    // Method untuk mendapatkan jenis alat yang aktif
    public static function getActiveJenisAlat()
    {
        return self::where('is_active', true)->orderBy('nama')->get();
    }

    // Method untuk mendapatkan jenis alat berdasarkan kode
    public static function getByKode($kode)
    {
        return self::where('kode', $kode)->where('is_active', true)->first();
    }

    // Accessor untuk label status
    public function getStatusLabelAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Nonaktif';
    }

    // Accessor untuk warna status
    public function getStatusColorAttribute()
    {
        return $this->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    }
}
