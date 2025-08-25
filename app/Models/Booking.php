<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pemesan',
        'nomor_telepon',
        'tanggal_booking',
        'jumlah_orang',
        'jenis_kolam',
        'tarif_harian',
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
        'tanggal_booking' => 'date',
        'tarif_harian' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    // Relationship dengan User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk mendapatkan informasi hari booking
    public function getHariBookingAttribute()
    {
        return $this->tanggal_booking->format('l, d F Y');
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

    // Method untuk format metode pembayaran
    public function getMetodePembayaranLabelAttribute()
    {
        return match($this->metode_pembayaran) {
            'transfer_bank' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            default => 'Belum dipilih'
        };
    }

    // Method untuk format jenis kolam
    public function getJenisKolamLabelAttribute()
    {
        return match($this->jenis_kolam) {
            'kolam_utama' => 'Ticket Utama',
            default => 'Ticket Utama'
        };
    }

    // Method untuk mendapatkan tarif harian berdasarkan jenis kolam
    public static function getTarifHarianByJenisKolam($jenisKolam)
    {
        return match($jenisKolam) {
            'kolam_utama' => 50000, // Tarif harian untuk kolam utama
            default => 50000 // default ke kolam utama
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
}
