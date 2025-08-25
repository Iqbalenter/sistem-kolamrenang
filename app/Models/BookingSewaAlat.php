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
    public static function getHargaByJenisAlat($jenisAlat)
    {
        $stokAlat = StokAlat::getStokByJenis($jenisAlat);
        if ($stokAlat) {
            return $stokAlat->harga_sewa;
        }
        
        // Fallback ke harga default jika tidak ada di stok
        return match($jenisAlat) {
            'ban_renang' => 15000,
            'kacamata_renang' => 10000,
            'papan_renang' => 20000,
            'pelampung' => 15000,
            'fins' => 25000,
            'snorkel' => 20000,
            default => 15000 // default ke ban renang
        };
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

    // Relationship dengan StokAlat
    public function stokAlat()
    {
        return $this->belongsTo(StokAlat::class, 'jenis_alat', 'jenis_alat');
    }

    // Method untuk kurangi stok saat booking dikonfirmasi
    public function kurangiStok()
    {
        $stokAlat = StokAlat::getStokByJenis($this->jenis_alat);
        if ($stokAlat && $stokAlat->kurangiStok($this->jumlah_alat)) {
            return true;
        }
        return false;
    }

    // Method untuk kembalikan stok saat alat dikembalikan
    public function kembalikanStok()
    {
        $stokAlat = StokAlat::getStokByJenis($this->jenis_alat);
        if ($stokAlat) {
            $stokAlat->tambahStok($this->jumlah_alat);
            $this->update([
                'alat_dikembalikan' => true,
                'tanggal_pengembalian' => now()
            ]);
            return true;
        }
        return false;
    }

    // Method untuk cek apakah alat bisa dikembalikan
    public function bisaDikembalikan()
    {
        return $this->status_pembayaran === 'lunas' && !$this->alat_dikembalikan;
    }
}
