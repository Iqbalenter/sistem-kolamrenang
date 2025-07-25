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
        'tanggal_sewa',
        'jam_mulai',
        'jam_selesai',
        'jenis_alat',
        'jumlah_alat',
        'harga_per_item',
        'total_harga',
        'status',
        'status_pembayaran',
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
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
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

    // Method untuk menghitung durasi sewa
    public function getDurasiAttribute()
    {
        $start = \Carbon\Carbon::parse($this->jam_mulai);
        $end = \Carbon\Carbon::parse($this->jam_selesai);
        return $end->diffInHours($start);
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

    // Method untuk mendapatkan harga berdasarkan jenis alat (per jam)
    public static function getHargaByJenisAlat($jenisAlat)
    {
        return match($jenisAlat) {
            'ban_renang' => 5000,
            'kacamata_renang' => 3000,
            'papan_renang' => 7000,
            'pelampung' => 5000,
            'fins' => 8000,
            'snorkel' => 6000,
            default => 5000 // default ke ban renang
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
}
