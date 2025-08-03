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
        'jam_mulai',
        'jam_selesai',
        'jumlah_orang',
        'jenis_kolam',
        'tarif_per_jam',
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
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'tarif_per_jam' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    // Relationship dengan User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk menghitung durasi booking
    public function getDurasiAttribute()
    {
        $start = \Carbon\Carbon::parse($this->jam_mulai);
        $end = \Carbon\Carbon::parse($this->jam_selesai);
        
        // Hitung durasi dengan cara yang lebih akurat
        $durasi = $end->diffInHours($start);
        
        // Jika durasi negatif, gunakan perhitungan manual
        if ($durasi < 0) {
            $startTime = strtotime($start->format('H:i:s'));
            $endTime = strtotime($end->format('H:i:s'));
            $durasi = ($endTime - $startTime) / 3600; // Konversi ke jam
        }
        
        return $durasi;
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

    // Method untuk mendapatkan tarif berdasarkan jenis kolam
    public static function getTarifByJenisKolam($jenisKolam)
    {
        return match($jenisKolam) {
            'kolam_utama' => 25000,
            default => 25000 // default ke kolam utama
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
