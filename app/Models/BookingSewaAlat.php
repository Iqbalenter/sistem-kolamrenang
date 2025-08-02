<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingSewaAlat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_penyewa',
        'nomor_telepon',
        'jenis_jaminan',
        'foto_jaminan',
        'tanggal_sewa',
        'jam_mulai',
        'jam_selesai',
        'jenis_alat',
        'jumlah_alat',
        'harga_per_item',
        'total_harga',
        'status',
        'status_pembayaran',
        'alat_dikembalikan',
        'tanggal_pengembalian',
        'bukti_pembayaran',
        'metode_pembayaran',
        'provider_pembayaran',
        'nomor_tujuan',
        'catatan',
        'catatan_admin',
        'approved_at',
        'rejected_at'
    ];

    protected $casts = [
        'tanggal_sewa' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'harga_per_item' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'alat_dikembalikan' => 'boolean',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'tanggal_pengembalian' => 'datetime'
    ];

    // Relationship dengan User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan JenisAlat
    public function jenisAlat(): BelongsTo
    {
        return $this->belongsTo(JenisAlat::class, 'jenis_alat', 'kode');
    }

    // Accessor untuk compatibility dengan view
    public function getTeleponAttribute()
    {
        return $this->nomor_telepon;
    }

    public function getEmailAttribute()
    {
        return $this->user ? $this->user->email : '-';
    }

    // Method untuk format status
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => 'Unknown'
        };
    }

    // Method untuk format status pembayaran
    public function getStatusPembayaranLabelAttribute()
    {
        return match($this->status_pembayaran) {
            'belum_bayar' => 'Belum Bayar',
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'lunas' => 'Lunas',
            'ditolak' => 'Ditolak',
            default => 'Unknown'
        };
    }

    // Method untuk format jenis alat
    public function getJenisAlatLabelAttribute()
    {
        // Coba relasi dulu
        if ($this->jenisAlat) {
            return $this->jenisAlat->nama;
        }
        
        // Jika relasi gagal, coba cari manual
        $jenisAlat = JenisAlat::getByKode($this->jenis_alat);
        if ($jenisAlat) {
            return $jenisAlat->nama;
        }
        
        // Jika masih tidak ditemukan, coba perbaiki data
        $firstJenisAlat = JenisAlat::first();
        if ($firstJenisAlat) {
            $this->update(['jenis_alat' => $firstJenisAlat->kode]);
            return $firstJenisAlat->nama;
        }
        
        return 'Unknown';
    }

    // Method untuk format jenis jaminan
    public function getJenisJaminanLabelAttribute()
    {
        return match($this->jenis_jaminan) {
            'ktp' => 'KTP',
            'sim' => 'SIM',
            default => 'Belum dipilih'
        };
    }

    // Method untuk mendapatkan harga berdasarkan jenis alat (per hari)
    public static function getHargaByJenisAlat($jenisAlatKode)
    {
        $jenisAlat = JenisAlat::getByKode($jenisAlatKode);
        if (!$jenisAlat) {
            return 0;
        }
        
        $stokAlat = StokAlat::where('jenis_alat_id', $jenisAlat->id)
            ->where('is_active', true)
            ->first();
            
        if ($stokAlat) {
            return $stokAlat->harga_sewa;
        }
        
        // Fallback ke harga default jika tidak ada di stok
        return 0;
    }

    // Method untuk mendapatkan informasi pembayaran lengkap
    public function getPaymentInfoAttribute()
    {
        if (!$this->metode_pembayaran) {
            return 'Metode pembayaran belum dipilih';
        }

        return $this->metode_pembayaran_label . ' - ' . $this->provider_pembayaran . ' (' . $this->nomor_tujuan . ')';
    }

    // Method untuk format metode pembayaran
    public function getMetodePembayaranLabelAttribute()
    {
        return match($this->metode_pembayaran) {
            'transfer_bank' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            default => 'Belum dipilih'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-800',
            'dikonfirmasi' => 'bg-green-100 text-green-800',
            'dibatalkan' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusPembayaranColorAttribute()
    {
        return match($this->status_pembayaran) {
            'belum_bayar' => 'bg-gray-100 text-gray-800',
            'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-800',
            'lunas' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Method untuk mengecek apakah bisa melakukan pembayaran
    public function canMakePayment()
    {
        return $this->status === 'approved' && 
               in_array($this->status_pembayaran, ['belum_bayar', 'ditolak']);
    }

    // Method untuk mengecek apakah pembayaran ditolak dan bisa diupload ulang
    public function canRetryPayment()
    {
        return $this->status === 'approved' && 
               $this->status_pembayaran === 'ditolak';
    }

    // Method untuk reset pembayaran ditolak
    public function resetRejectedPayment()
    {
        if ($this->status_pembayaran === 'ditolak') {
            $this->update([
                'status_pembayaran' => 'belum_bayar',
                'metode_pembayaran' => null,
                'provider_pembayaran' => null,
                'nomor_tujuan' => null,
                'bukti_pembayaran' => null,
                'catatan_admin' => null
            ]);
        }
    }

    // Method untuk mendapatkan stok alat
    public function getStokAlat()
    {
        // Relasi melalui jenis alat
        $jenisAlat = JenisAlat::getByKode($this->jenis_alat);
        if (!$jenisAlat) {
            return null;
        }
        return StokAlat::where('jenis_alat_id', $jenisAlat->id)->first();
    }

    // Method untuk kurangi stok saat booking dikonfirmasi
    public function kurangiStok()
    {
        // Debug: Log informasi
        \Log::info('Attempting to reduce stock:', [
            'booking_id' => $this->id,
            'jenis_alat' => $this->jenis_alat,
            'jumlah_alat' => $this->jumlah_alat
        ]);

        // Cari stok alat berdasarkan jenis alat
        $jenisAlat = JenisAlat::getByKode($this->jenis_alat);
        if (!$jenisAlat) {
            \Log::error('Jenis alat not found:', ['jenis_alat' => $this->jenis_alat]);
            return false;
        }
        
        \Log::info('Found jenis alat:', ['jenis_alat_id' => $jenisAlat->id]);
        
        $stokAlat = StokAlat::where('jenis_alat_id', $jenisAlat->id)
            ->where('is_active', true)
            ->where('stok_tersedia', '>=', $this->jumlah_alat)
            ->first();
            
        if (!$stokAlat) {
            \Log::error('Stok alat not found or insufficient:', [
                'jenis_alat_id' => $jenisAlat->id,
                'stok_tersedia_needed' => $this->jumlah_alat
            ]);
            return false;
        }
        
        \Log::info('Found stok alat:', [
            'stok_alat_id' => $stokAlat->id,
            'stok_tersedia' => $stokAlat->stok_tersedia,
            'jumlah_to_reduce' => $this->jumlah_alat
        ]);
            
        if ($stokAlat->kurangiStok($this->jumlah_alat)) {
            \Log::info('Stock reduced successfully');
            return true;
        }
        
        \Log::error('Failed to reduce stock');
        return false;
    }

    // Method untuk kembalikan stok saat alat dikembalikan
    public function kembalikanStok()
    {
        // Debug: Log informasi
        \Log::info('Attempting to return stock:', [
            'booking_id' => $this->id,
            'jenis_alat' => $this->jenis_alat,
            'jumlah_alat' => $this->jumlah_alat
        ]);

        // Cari stok alat berdasarkan jenis alat
        $jenisAlat = JenisAlat::getByKode($this->jenis_alat);
        if (!$jenisAlat) {
            \Log::error('Jenis alat not found for return:', ['jenis_alat' => $this->jenis_alat]);
            
            // Coba perbaiki jenis alat yang tidak sesuai
            $firstJenisAlat = JenisAlat::first();
            if ($firstJenisAlat) {
                $this->update(['jenis_alat' => $firstJenisAlat->kode]);
                $jenisAlat = $firstJenisAlat;
                \Log::info('Fixed jenis alat for return:', [
                    'booking_id' => $this->id,
                    'old_jenis_alat' => $this->jenis_alat,
                    'new_jenis_alat' => $firstJenisAlat->kode
                ]);
            } else {
                return false;
            }
        }
        
        \Log::info('Found jenis alat for return:', ['jenis_alat_id' => $jenisAlat->id]);
        
        $stokAlat = StokAlat::where('jenis_alat_id', $jenisAlat->id)
            ->where('is_active', true)
            ->first();
            
        if (!$stokAlat) {
            \Log::error('Stok alat not found for return:', [
                'jenis_alat_id' => $jenisAlat->id
            ]);
            return false;
        }
        
        \Log::info('Found stok alat for return:', [
            'stok_alat_id' => $stokAlat->id,
            'stok_tersedia' => $stokAlat->stok_tersedia,
            'jumlah_to_add' => $this->jumlah_alat
        ]);
            
        if ($stokAlat->tambahStok($this->jumlah_alat)) {
            $this->update([
                'alat_dikembalikan' => true,
                'tanggal_pengembalian' => now()
            ]);
            \Log::info('Stock returned successfully');
            return true;
        }
        
        \Log::error('Failed to return stock');
        return false;
    }

    // Method untuk kembalikan stok tanpa mengupdate status pengembalian (untuk reject)
    public function kembalikanStokTanpaStatus()
    {
        // Cari stok alat berdasarkan jenis alat
        $jenisAlat = JenisAlat::getByKode($this->jenis_alat);
        if (!$jenisAlat) {
            return false;
        }
        
        $stokAlat = StokAlat::where('jenis_alat_id', $jenisAlat->id)
            ->where('is_active', true)
            ->first();
            
        if ($stokAlat) {
            $stokAlat->tambahStok($this->jumlah_alat);
            return true;
        }
        return false;
    }

    // Method untuk cek apakah alat bisa dikembalikan
    public function bisaDikembalikan()
    {
        return $this->status === 'approved' && 
               $this->status_pembayaran === 'lunas' && 
               !$this->alat_dikembalikan;
    }

    // Accessor untuk durasi (sewa alat per hari)
    public function getDurasiAttribute()
    {
        return 1; // Sewa alat selalu 1 hari
    }

    // Accessor untuk harga per jam (alias untuk harga_per_item)
    public function getHargaPerJamAttribute()
    {
        return $this->harga_per_item;
    }
}
