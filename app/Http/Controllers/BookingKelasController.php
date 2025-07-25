<?php

namespace App\Http\Controllers;

use App\Models\BookingKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingKelasController extends Controller
{
    // Menampilkan form booking kelas untuk user
    public function create()
    {
        return view('booking.kelas.create');
    }

    // Menyimpan booking kelas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_kelas' => 'required|date|after:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'jenis_kelas' => 'required|in:pemula,menengah,lanjutan,private',
            'instruktur' => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer|min:1|max:10',
            'catatan' => 'nullable|string'
        ]);

        // Hitung total harga berdasarkan jenis kelas dan jumlah peserta
        $hargaPerOrang = BookingKelas::getHargaByJenisKelas($request->jenis_kelas);
        $totalHarga = $hargaPerOrang * $request->jumlah_peserta;

        BookingKelas::create([
            'user_id' => Auth::id(),
            'nama_pemesan' => $request->nama_pemesan,
            'nomor_telepon' => $request->nomor_telepon,
            'tanggal_kelas' => $request->tanggal_kelas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'jenis_kelas' => $request->jenis_kelas,
            'instruktur' => $request->instruktur,
            'jumlah_peserta' => $request->jumlah_peserta,
            'harga_per_orang' => $hargaPerOrang,
            'total_harga' => $totalHarga,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'status_pembayaran' => 'belum_bayar'
        ]);

        return redirect()->route('user.booking.kelas.history')->with('success', 'Booking kelas berhasil dibuat! Menunggu persetujuan admin.');
    }

    // Menampilkan history booking kelas user
    public function history()
    {
        $bookings = Auth::user()->bookingKelas()->latest()->get();
        return view('booking.kelas.history', compact('bookings'));
    }

    // Menampilkan detail booking kelas
    public function show(BookingKelas $bookingKelas)
    {
        $user = Auth::user();
        
        // Pastikan user hanya bisa melihat booking miliknya sendiri (kecuali admin)
        if ($user->role === 'user' && $bookingKelas->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Tentukan view berdasarkan role
        if ($user->role === 'admin') {
            return view('admin.booking.kelas.show', compact('bookingKelas'));
        } else {
            return view('booking.kelas.show', compact('bookingKelas'));
        }
    }

    // Menampilkan halaman pilihan metode pembayaran
    public function showPayment(BookingKelas $bookingKelas)
    {
        // Pastikan user hanya bisa mengakses booking miliknya
        if ($bookingKelas->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan booking bisa melakukan pembayaran
        if (!$bookingKelas->canMakePayment()) {
            return redirect()->route('user.booking.kelas.show', $bookingKelas)
                ->with('error', 'Pembayaran tidak dapat dilakukan untuk booking ini!');
        }

        // Reset pembayaran jika ditolak
        $bookingKelas->resetRejectedPayment();

        return view('booking.kelas.payment', compact('bookingKelas'));
    }

    // Menyimpan pilihan metode pembayaran
    public function selectPaymentMethod(Request $request, BookingKelas $bookingKelas)
    {
        // Pastikan user hanya bisa mengakses booking miliknya
        if ($bookingKelas->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet',
            'provider_pembayaran' => 'required|string',
            'nomor_tujuan' => 'required|string'
        ]);

        $bookingKelas->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'provider_pembayaran' => $request->provider_pembayaran,
            'nomor_tujuan' => $request->nomor_tujuan
        ]);

        return redirect()->route('user.booking.kelas.payment', $bookingKelas)->with('success', 'Metode pembayaran berhasil dipilih!');
    }

    // Upload bukti pembayaran
    public function uploadPayment(Request $request, BookingKelas $bookingKelas)
    {
        // Pastikan user hanya bisa upload untuk booking miliknya
        if ($bookingKelas->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan booking sudah disetujui
        if ($bookingKelas->status !== 'approved') {
            return redirect()->route('user.booking.kelas.show', $bookingKelas)->with('error', 'Booking belum disetujui!');
        }

        // Pastikan status pembayaran memungkinkan untuk upload
        if (!in_array($bookingKelas->status_pembayaran, ['belum_bayar', 'ditolak'])) {
            return redirect()->route('user.booking.kelas.show', $bookingKelas)->with('error', 'Upload pembayaran tidak dapat dilakukan untuk status ini!');
        }

        // Pastikan metode pembayaran sudah dipilih
        if (!$bookingKelas->metode_pembayaran || !$bookingKelas->provider_pembayaran || !$bookingKelas->nomor_tujuan) {
            return redirect()->route('user.booking.kelas.payment', $bookingKelas)->with('error', 'Silakan pilih metode pembayaran terlebih dahulu!');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Hapus file lama jika ada
        if ($bookingKelas->bukti_pembayaran) {
            Storage::delete('public/' . $bookingKelas->bukti_pembayaran);
        }

        // Upload file baru
        $fileName = time() . '_' . $request->file('bukti_pembayaran')->getClientOriginalName();
        $filePath = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran_kelas', $fileName, 'public');

        $bookingKelas->update([
            'bukti_pembayaran' => $filePath,
            'status_pembayaran' => 'menunggu_konfirmasi'
        ]);

        return redirect()->route('user.booking.kelas.show', $bookingKelas)->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }

    // === ADMIN METHODS ===

    // Menampilkan semua booking kelas untuk admin
    public function adminIndex()
    {
        $bookings = BookingKelas::with('user')->latest()->get();
        return view('admin.booking-kelas.index', compact('bookings'));
    }

    // Menyetujui booking kelas
    public function approve(BookingKelas $bookingKelas)
    {
        $bookingKelas->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        return redirect()->route('admin.booking-kelas.index')->with('success', 'Booking kelas berhasil disetujui!');
    }

    // Menolak booking kelas
    public function reject(Request $request, BookingKelas $bookingKelas)
    {
        $request->validate([
            'catatan_admin' => 'required|string'
        ]);

        $bookingKelas->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'rejected_at' => now()
        ]);

        return redirect()->route('admin.booking-kelas.index')->with('success', 'Booking kelas berhasil ditolak!');
    }

    // Konfirmasi pembayaran
    public function confirmPayment(BookingKelas $bookingKelas)
    {
        $bookingKelas->update([
            'status_pembayaran' => 'lunas'
        ]);

        return redirect()->route('admin.booking-kelas.show', $bookingKelas)->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // Approve pembayaran (alias untuk confirmPayment)
    public function approvePayment(Request $request, BookingKelas $bookingKelas)
    {
        $bookingKelas->update([
            'status_pembayaran' => 'lunas',
            'catatan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.booking-kelas.show', $bookingKelas)->with('success', 'Pembayaran berhasil disetujui!');
    }

    // Tolak pembayaran
    public function rejectPayment(Request $request, BookingKelas $bookingKelas)
    {
        $request->validate([
            'catatan_admin' => 'required|string'
        ]);

        $bookingKelas->update([
            'status_pembayaran' => 'ditolak',
            'catatan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.booking-kelas.show', $bookingKelas)->with('success', 'Pembayaran berhasil ditolak!');
    }

    // Menyelesaikan booking kelas
    public function complete(BookingKelas $bookingKelas)
    {
        $bookingKelas->update([
            'status' => 'completed'
        ]);

        return redirect()->route('admin.booking-kelas.show', $bookingKelas)->with('success', 'Booking kelas berhasil diselesaikan!');
    }

    // Konfirmasi booking setelah pembayaran lunas
    public function confirm(Request $request, BookingKelas $bookingKelas)
    {
        $bookingKelas->update([
            'status' => 'dikonfirmasi',
            'instruktur' => $request->instruktur,
            'catatan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.booking-kelas.show', $bookingKelas)->with('success', 'Booking berhasil dikonfirmasi!');
    }

    // Hapus booking kelas
    public function deleteBooking(BookingKelas $bookingKelas)
    {
        // Hapus file bukti pembayaran jika ada
        if ($bookingKelas->bukti_pembayaran) {
            Storage::delete('public/' . $bookingKelas->bukti_pembayaran);
        }

        $bookingKelas->delete();

        return redirect()->route('admin.booking-kelas.index')->with('success', 'Booking kelas berhasil dihapus!');
    }

    // Method untuk user membatalkan booking
    public function cancel(BookingKelas $bookingKelas)
    {
        // Pastikan user hanya bisa membatalkan booking miliknya sendiri
        if ($bookingKelas->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa dibatalkan jika masih menunggu konfirmasi atau belum bayar
        if (!in_array($bookingKelas->status, ['menunggu_konfirmasi']) || 
            !in_array($bookingKelas->status_pembayaran, ['belum_bayar', 'menunggu_konfirmasi'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan!');
        }

        $bookingKelas->update([
            'status' => 'dibatalkan',
            'catatan_admin' => 'Dibatalkan oleh user'
        ]);

        return redirect()->route('user.booking.kelas.history')->with('success', 'Booking berhasil dibatalkan!');
    }
}
