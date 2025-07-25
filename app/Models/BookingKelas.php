<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pemesan',
        'nomor_telepon',
        'tanggal_kelas',
        'jam_mulai',
        'jam_selesai',
        'jenis_kelas',
        'instruktur',
        'jumlah_peserta',
        'harga_per_orang',
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
        'tanggal_kelas' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'harga_per_orang' => 'decimal:2',
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

    public function getNamaPesertaAttribute()
    {
        return $this->nama_pemesan;
    }

    public function getUmurAttribute()
    {
        // Karena tidak ada field umur di database, kita return placeholder
        // Bisa ditambahkan field umur ke migration atau form jika diperlukan
        return 'Tidak tersedia';
    }

    // Method untuk menghitung durasi kelas
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

    // Method untuk format jenis kelas
    public function getJenisKelasLabelAttribute()
    {
        return match($this->jenis_kelas) {
            'pemula' => 'Kelas Pemula',
            'menengah' => 'Kelas Menengah',
            'lanjutan' => 'Kelas Lanjutan',
            'private' => 'Kelas Private',
            default => 'Unknown'
        };
    }

    // Method untuk mendapatkan harga berdasarkan jenis kelas
    public static function getHargaByJenisKelas($jenisKelas)
    {
        return match($jenisKelas) {
            'pemula' => 50000,
            'menengah' => 75000,
            'lanjutan' => 100000,
            'private' => 150000,
            default => 50000 // default ke pemula
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
