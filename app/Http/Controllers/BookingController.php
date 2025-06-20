<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    // Menampilkan form booking untuk user
    public function create()
    {
        return view('booking.create');
    }

    // Menyimpan booking baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_booking' => 'required|date|after:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'jumlah_orang' => 'required|integer|min:1|max:50',
            'jenis_kolam' => 'required|in:kolam_anak,kolam_utama',
            'catatan' => 'nullable|string'
        ]);

        // Hitung total harga berdasarkan jenis kolam
        $jamMulai = \Carbon\Carbon::parse($request->jam_mulai);
        $jamSelesai = \Carbon\Carbon::parse($request->jam_selesai);
        $durasi = $jamSelesai->diffInHours($jamMulai);
        $tarifPerJam = Booking::getTarifByJenisKolam($request->jenis_kolam);
        $totalHarga = $durasi * $tarifPerJam;

        Booking::create([
            'user_id' => Auth::id(),
            'nama_pemesan' => $request->nama_pemesan,
            'nomor_telepon' => $request->nomor_telepon,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'jumlah_orang' => $request->jumlah_orang,
            'jenis_kolam' => $request->jenis_kolam,
            'tarif_per_jam' => $tarifPerJam,
            'total_harga' => $totalHarga,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'status_pembayaran' => 'belum_bayar'
        ]);

        return redirect()->route('user.booking.history')->with('success', 'Booking berhasil dibuat! Menunggu persetujuan admin.');
    }

    // Menampilkan history booking user
    public function history()
    {
        $bookings = Auth::user()->bookings()->latest()->get();
        return view('booking.history', compact('bookings'));
    }

    // Menampilkan detail booking
    public function show(Booking $booking)
    {
        $user = Auth::user();
        
        // Pastikan user hanya bisa melihat booking miliknya sendiri (kecuali admin)
        if ($user->role === 'user' && $booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Tentukan view berdasarkan role
        if ($user->role === 'admin') {
            return view('admin.bookings.show', compact('booking'));
        } else {
            return view('booking.show', compact('booking'));
        }
    }

    // Upload bukti pembayaran
    public function uploadPayment(Request $request, Booking $booking)
    {
        // Pastikan user hanya bisa upload untuk booking miliknya
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan booking sudah disetujui
        if ($booking->status !== 'approved') {
            return redirect()->route('user.booking.show', $booking)->with('error', 'Booking belum disetujui!');
        }

        // Reset status pembayaran jika ditolak
        if ($booking->status_pembayaran === 'ditolak') {
            $booking->update(['status_pembayaran' => 'belum_bayar']);
        }

        // Pastikan metode pembayaran sudah dipilih
        if (!$booking->metode_pembayaran || !$booking->provider_pembayaran || !$booking->nomor_tujuan) {
            return redirect()->route('user.booking.payment', $booking)->with('error', 'Silakan pilih metode pembayaran terlebih dahulu!');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Hapus file lama jika ada
        if ($booking->bukti_pembayaran) {
            Storage::delete('public/' . $booking->bukti_pembayaran);
        }

        // Upload file baru
        $fileName = time() . '_' . $request->file('bukti_pembayaran')->getClientOriginalName();
        $filePath = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran', $fileName, 'public');

        $booking->update([
            'bukti_pembayaran' => $filePath,
            'status_pembayaran' => 'menunggu_konfirmasi'
        ]);

        return redirect()->route('user.booking.show', $booking)->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }

    // Menampilkan halaman pilihan metode pembayaran
    public function showPayment(Booking $booking)
    {
        // Pastikan user hanya bisa mengakses booking miliknya
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan booking sudah disetujui
        if ($booking->status !== 'approved') {
            return redirect()->route('user.booking.show', $booking)->with('error', 'Booking belum disetujui!');
        }

        // Reset status pembayaran jika ditolak
        if ($booking->status_pembayaran === 'ditolak') {
            $booking->update([
                'status_pembayaran' => 'belum_bayar',
                'metode_pembayaran' => null,
                'provider_pembayaran' => null,
                'nomor_tujuan' => null,
                'catatan_admin' => null
            ]);
        }

        // Data metode pembayaran yang tersedia
        $paymentMethods = [
            'transfer_bank' => [
                'name' => 'Transfer Bank',
                'icon' => '🏦',
                'providers' => [
                    'BCA' => '1234567890',
                    'BRI' => '0987654321',
                    'BNI' => '1122334455',
                    'Mandiri' => '5566778899',
                    'BTN' => '9988776655'
                ]
            ],
            'e_wallet' => [
                'name' => 'E-Wallet',
                'icon' => '📱',
                'providers' => [
                    'OVO' => '081234567890',
                    'DANA' => '081234567891',
                    'GoPay' => '081234567892',
                    'ShopeePay' => '081234567893',
                    'LinkAja' => '081234567894'
                ]
            ]
        ];

        return view('booking.payment', compact('booking', 'paymentMethods'));
    }

    // Memilih metode pembayaran
    public function selectPaymentMethod(Request $request, Booking $booking)
    {
        // Pastikan user hanya bisa update booking miliknya
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan booking sudah disetujui
        if ($booking->status !== 'approved') {
            return redirect()->route('user.booking.show', $booking)->with('error', 'Booking belum disetujui!');
        }

        // Reset status pembayaran jika ditolak
        if ($booking->status_pembayaran === 'ditolak') {
            $booking->update(['status_pembayaran' => 'belum_bayar']);
        }

        // Jika ingin reset metode pembayaran (kosongkan semua field)
        if (!$request->metode_pembayaran) {
            $booking->update([
                'metode_pembayaran' => null,
                'provider_pembayaran' => null,
                'nomor_tujuan' => null
            ]);
            
            return redirect()->route('user.booking.payment', $booking)->with('success', 'Metode pembayaran berhasil direset. Silakan pilih metode baru.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet',
            'provider_pembayaran' => 'required|string',
            'nomor_tujuan' => 'required|string'
        ]);

        $booking->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'provider_pembayaran' => $request->provider_pembayaran,
            'nomor_tujuan' => $request->nomor_tujuan
        ]);

        return redirect()->route('user.booking.payment', $booking)->with('success', 'Metode pembayaran berhasil dipilih! Silakan upload bukti pembayaran.');
    }

    // === ADMIN METHODS ===

    // Menampilkan semua booking untuk admin
    public function adminIndex(Request $request)
    {
        $query = Booking::with('user');
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan payment status
        if ($request->has('payment') && $request->payment) {
            $query->where('status_pembayaran', $request->payment);
        }
        
        $bookings = $query->latest()->get();
        
        // Statistics untuk dashboard admin
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $rejectedBookings = Booking::where('status', 'rejected')->count();
        
        $paymentPendingCount = Booking::where('status_pembayaran', 'belum_bayar')->count();
        $paymentWaitingCount = Booking::where('status_pembayaran', 'menunggu_konfirmasi')->count();
        $paymentCompletedCount = Booking::where('status_pembayaran', 'lunas')->count();
        
        $totalRevenue = Booking::where('status_pembayaran', 'lunas')->sum('total_harga');
        
        return view('admin.bookings.index', compact(
            'bookings', 
            'totalBookings', 
            'pendingBookings', 
            'approvedBookings',
            'completedBookings',
            'rejectedBookings',
            'paymentPendingCount',
            'paymentWaitingCount', 
            'paymentCompletedCount',
            'totalRevenue'
        ));
    }

    // Approve booking
    public function approve(Booking $booking)
    {
        $booking->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Booking berhasil disetujui!']);
        }

        return redirect()->back()->with('success', 'Booking berhasil disetujui!');
    }

    // Reject booking
    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'catatan_admin' => 'required|string'
        ]);

        $booking->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'catatan_admin' => $request->catatan_admin
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Booking berhasil ditolak!']);
        }

        return redirect()->back()->with('success', 'Booking berhasil ditolak!');
    }

    // Konfirmasi pembayaran
    public function confirmPayment(Booking $booking)
    {
        $booking->update([
            'status_pembayaran' => 'lunas'
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dikonfirmasi!']);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // Reject pembayaran
    public function rejectPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'catatan_admin' => 'required|string'
        ]);

        // Hapus file bukti pembayaran yang ditolak
        if ($booking->bukti_pembayaran) {
            Storage::delete('public/' . $booking->bukti_pembayaran);
        }

        $booking->update([
            'status_pembayaran' => 'ditolak',
            'bukti_pembayaran' => null, // Hapus bukti pembayaran yang ditolak
            'catatan_admin' => $request->catatan_admin
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil ditolak!']);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil ditolak!');
    }

    // Complete booking
    public function complete(Booking $booking)
    {
        $booking->update([
            'status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Booking berhasil diselesaikan!');
    }

    // Delete booking
    public function deleteBooking(Booking $booking)
    {
        // Hapus file bukti pembayaran jika ada
        if ($booking->bukti_pembayaran) {
            Storage::delete('public/' . $booking->bukti_pembayaran);
        }

        // Hapus booking
        $booking->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Booking berhasil dihapus!']);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus!');
    }
}
