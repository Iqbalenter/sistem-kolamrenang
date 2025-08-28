<?php

namespace App\Http\Controllers;

use App\Models\BookingSewaAlat;
use App\Models\StokAlat;
use App\Models\JenisAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingSewaAlatController extends Controller
{
    // Menampilkan form booking sewa alat untuk user
    public function create()
    {
        // Ambil data alat yang tersedia (stok > 0 dan aktif)
        $alatTersedia = StokAlat::with('jenisAlat')
            ->where('is_active', true)
            ->where('stok_tersedia', '>', 0)
            ->get()
            ->groupBy('jenisAlat.kode')
            ->map(function ($items) {
                $firstItem = $items->first();
                return [
                    'kode' => $firstItem->jenisAlat->kode,
                    'nama' => $firstItem->jenisAlat->nama,
                    'harga' => $firstItem->harga_sewa,
                    'stok_total' => $items->sum('stok_tersedia')
                ];
            });

        return view('booking.sewa-alat.create', compact('alatTersedia'));
    }

    // Menyimpan booking sewa alat baru
    public function store(Request $request)
    {
        // Ambil kode jenis alat yang tersedia untuk validasi
        $jenisAlatTersedia = JenisAlat::where('is_active', true)->pluck('kode')->toArray();

        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_sewa' => 'required|date|after:today',
            'jenis_jaminan' => 'required|in:ktp,sim',
            'foto_jaminan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_alat' => 'required|in:' . implode(',', $jenisAlatTersedia),
            'jumlah_alat' => 'required|integer|min:1|max:20',
            'catatan' => 'nullable|string'
        ], [
            'foto_jaminan.required' => 'Foto jaminan harus diupload.',
            'foto_jaminan.image' => 'File yang diupload harus berupa gambar.',
            'foto_jaminan.mimes' => 'Format foto jaminan harus berupa JPEG, PNG, JPG, atau GIF.',
            'foto_jaminan.max' => 'Ukuran foto jaminan tidak boleh lebih dari 2MB.',
        ]);

        // Cek stok alat
        $stokAlat = \App\Models\StokAlat::getStokByJenis($request->jenis_alat);
        if (!$stokAlat || !$stokAlat->isStokTersedia($request->jumlah_alat)) {
            return back()->with('error', 'Stok alat tidak mencukupi! Stok tersedia: ' . ($stokAlat ? $stokAlat->stok_tersedia : 0));
        }

        // Upload foto jaminan
        if (!$request->hasFile('foto_jaminan')) {
            return back()->with('error', 'Foto jaminan tidak berhasil diupload. Silakan coba lagi.');
        }

        $file = $request->file('foto_jaminan');
        if (!$file->isValid()) {
            return back()->with('error', 'File foto jaminan tidak valid. Silakan pilih file yang benar.');
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('foto_jaminan', $fileName, 'public');

        // Hitung total harga berdasarkan jenis alat dan jumlah (per hari)
        $hargaPerItem = \App\Models\BookingSewaAlat::getHargaByJenisAlat($request->jenis_alat);
        $totalHarga = $hargaPerItem * $request->jumlah_alat;

        \App\Models\BookingSewaAlat::create([
            'user_id' => Auth::id(),
            'nama_penyewa' => $request->nama_penyewa,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_jaminan' => $request->jenis_jaminan,
            'foto_jaminan' => $filePath,
            'tanggal_sewa' => $request->tanggal_sewa,
            'jenis_alat' => $request->jenis_alat,
            'jumlah_alat' => $request->jumlah_alat,
            'harga_per_item' => $hargaPerItem,
            'total_harga' => $totalHarga,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'status_pembayaran' => 'belum_bayar'
        ]);

        return redirect()->route('user.booking.sewa-alat.history')->with('success', 'Booking sewa alat berhasil dibuat! Menunggu persetujuan admin.');
    }

    // Menampilkan history booking sewa alat user
    public function history()
    {
        $bookings = Auth::user()->bookingSewaAlat()->with('jenisAlat')->latest()->get();
        return view('booking.sewa-alat.history', compact('bookings'));
    }

    // Menampilkan detail booking sewa alat
    public function show(BookingSewaAlat $bookingSewaAlat)
    {
        $user = Auth::user();
        
        // Load relationship jenisAlat untuk menampilkan nama yang benar
        $bookingSewaAlat->load('jenisAlat');
        
        // Pastikan user hanya bisa melihat booking miliknya sendiri (kecuali admin)
        if ($user->role === 'user' && $bookingSewaAlat->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Tentukan view berdasarkan role
        if ($user->role === 'admin') {
            return view('admin.booking.sewa-alat.show', compact('bookingSewaAlat'));
        } else {
            return view('booking.sewa-alat.show', compact('bookingSewaAlat'));
        }
    }

    // Menampilkan halaman pilihan metode pembayaran
    public function showPayment(BookingSewaAlat $bookingSewaAlat)
    {
        // Pastikan user hanya bisa mengakses booking miliknya
        if ($bookingSewaAlat->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan booking bisa melakukan pembayaran
        if (!$bookingSewaAlat->canMakePayment()) {
            return redirect()->route('user.booking.sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Pembayaran tidak dapat dilakukan untuk booking ini!');
        }

        // Reset pembayaran jika ditolak
        $bookingSewaAlat->resetRejectedPayment();

        return view('booking.sewa-alat.payment', compact('bookingSewaAlat'));
    }

    // Menyimpan pilihan metode pembayaran
    public function selectPaymentMethod(Request $request, BookingSewaAlat $bookingSewaAlat)
    {
        // Pastikan user hanya bisa mengakses booking miliknya
        if ($bookingSewaAlat->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet',
            'provider_pembayaran' => 'required|string',
            'nomor_tujuan' => 'required|string'
        ]);

        $bookingSewaAlat->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'provider_pembayaran' => $request->provider_pembayaran,
            'nomor_tujuan' => $request->nomor_tujuan
        ]);

        return redirect()->route('user.booking.sewa-alat.payment', $bookingSewaAlat)->with('success', 'Metode pembayaran berhasil dipilih!');
    }

    // Upload bukti pembayaran
    public function uploadPayment(Request $request, BookingSewaAlat $bookingSewaAlat)
    {
        // Pastikan user hanya bisa upload untuk booking miliknya
        if ($bookingSewaAlat->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan booking sudah disetujui
        if ($bookingSewaAlat->status !== 'approved') {
            return redirect()->route('user.booking.sewa-alat.show', $bookingSewaAlat)->with('error', 'Booking belum disetujui!');
        }

        // Pastikan status pembayaran memungkinkan untuk upload
        if (!in_array($bookingSewaAlat->status_pembayaran, ['belum_bayar', 'ditolak'])) {
            return redirect()->route('user.booking.sewa-alat.show', $bookingSewaAlat)->with('error', 'Upload pembayaran tidak dapat dilakukan untuk status ini!');
        }

        // Pastikan metode pembayaran sudah dipilih
        if (!$bookingSewaAlat->metode_pembayaran || !$bookingSewaAlat->provider_pembayaran || !$bookingSewaAlat->nomor_tujuan) {
            return redirect()->route('user.booking.sewa-alat.payment', $bookingSewaAlat)->with('error', 'Silakan pilih metode pembayaran terlebih dahulu!');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Hapus file lama jika ada
        if ($bookingSewaAlat->bukti_pembayaran) {
            Storage::delete('public/' . $bookingSewaAlat->bukti_pembayaran);
        }

        // Upload file baru
        $fileName = time() . '_' . $request->file('bukti_pembayaran')->getClientOriginalName();
        $filePath = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran_sewa_alat', $fileName, 'public');

        $bookingSewaAlat->update([
            'bukti_pembayaran' => $filePath,
            'status_pembayaran' => 'menunggu_konfirmasi'
        ]);

        return redirect()->route('user.booking.sewa-alat.show', $bookingSewaAlat)->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }

    // === ADMIN METHODS ===

    // Menampilkan semua booking sewa alat untuk admin
    public function adminIndex()
    {
        $bookings = BookingSewaAlat::with(['user', 'jenisAlat'])->latest()->get();
        return view('admin.booking-sewa-alat.index', compact('bookings'));
    }

    // Menyetujui booking sewa alat
    public function approve(BookingSewaAlat $bookingSewaAlat)
    {
        $bookingSewaAlat->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        return redirect()->route('admin.booking-sewa-alat.index')->with('success', 'Booking sewa alat berhasil disetujui!');
    }

    // Menolak booking sewa alat
    public function reject(Request $request, BookingSewaAlat $bookingSewaAlat)
    {
        $request->validate([
            'catatan_admin' => 'required|string'
        ]);

        $bookingSewaAlat->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'rejected_at' => now()
        ]);

        return redirect()->route('admin.booking-sewa-alat.index')->with('success', 'Booking sewa alat berhasil ditolak!');
    }

    // Konfirmasi pembayaran
    public function confirmPayment(BookingSewaAlat $bookingSewaAlat)
    {
        // Kurangi stok alat saat pembayaran dikonfirmasi
        if (!$bookingSewaAlat->kurangiStok()) {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Stok alat tidak mencukupi!');
        }

        $bookingSewaAlat->update([
            'status_pembayaran' => 'lunas'
        ]);

        return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)->with('success', 'Pembayaran berhasil dikonfirmasi dan stok alat telah dikurangi!');
    }

    // Approve pembayaran (alias untuk confirmPayment)
    public function approvePayment(Request $request, BookingSewaAlat $bookingSewaAlat)
    {
        // Kurangi stok alat saat pembayaran disetujui
        if (!$bookingSewaAlat->kurangiStok()) {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Stok alat tidak mencukupi!');
        }

        $bookingSewaAlat->update([
            'status_pembayaran' => 'lunas',
            'catatan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)->with('success', 'Pembayaran berhasil disetujui dan stok alat telah dikurangi!');
    }

    // Tolak pembayaran
    public function rejectPayment(Request $request, BookingSewaAlat $bookingSewaAlat)
    {
        $request->validate([
            'catatan_admin' => 'required|string'
        ]);

        $bookingSewaAlat->update([
            'status_pembayaran' => 'ditolak',
            'catatan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)->with('success', 'Pembayaran berhasil ditolak!');
    }

    // Menyelesaikan booking sewa alat
    public function complete(BookingSewaAlat $bookingSewaAlat)
    {
        $bookingSewaAlat->update([
            'status' => 'completed'
        ]);

        return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)->with('success', 'Booking sewa alat berhasil diselesaikan!');
    }

    // Konfirmasi booking setelah pembayaran lunas
    public function confirm(Request $request, BookingSewaAlat $bookingSewaAlat)
    {
        $bookingSewaAlat->update([
            'status' => 'dikonfirmasi',
            'catatan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)->with('success', 'Booking berhasil dikonfirmasi!');
    }

    // Hapus booking sewa alat
    public function deleteBooking(BookingSewaAlat $bookingSewaAlat)
    {
        // Hapus file bukti pembayaran jika ada
        if ($bookingSewaAlat->bukti_pembayaran) {
            Storage::delete('public/' . $bookingSewaAlat->bukti_pembayaran);
        }

        $bookingSewaAlat->delete();

        return redirect()->route('admin.booking-sewa-alat.index')->with('success', 'Booking sewa alat berhasil dihapus!');
    }

    // Method untuk user membatalkan booking
    public function cancel(BookingSewaAlat $bookingSewaAlat)
    {
        // Pastikan user hanya bisa membatalkan booking miliknya sendiri
        if ($bookingSewaAlat->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa dibatalkan jika masih menunggu konfirmasi atau belum bayar
        if (!in_array($bookingSewaAlat->status, ['menunggu_konfirmasi']) || 
            !in_array($bookingSewaAlat->status_pembayaran, ['belum_bayar', 'menunggu_konfirmasi'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan!');
        }

        $bookingSewaAlat->update([
            'status' => 'dibatalkan',
            'catatan_admin' => 'Dibatalkan oleh user'
        ]);

        return redirect()->route('user.booking.sewa-alat.history')->with('success', 'Booking berhasil dibatalkan!');
    }

    // Method untuk admin mengembalikan alat (menambah stok kembali)
    public function kembalikanAlat(BookingSewaAlat $bookingSewaAlat)
    {
        if (!$bookingSewaAlat->bisaDikembalikan()) {
            return back()->with('error', 'Alat tidak dapat dikembalikan!');
        }

        if ($bookingSewaAlat->kembalikanStok()) {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('success', 'Alat berhasil dikembalikan dan stok telah ditambah!');
        } else {
            return back()->with('error', 'Gagal mengembalikan alat!');
        }
    }
}
