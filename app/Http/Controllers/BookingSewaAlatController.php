<?php

namespace App\Http\Controllers;

use App\Models\BookingSewaAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingSewaAlatController extends Controller
{
    // Method untuk memastikan data jenis alat dan stok alat tersedia
    private function ensureDataAvailable()
    {
        // Cek dan jalankan seeder jenis alat jika tidak ada data
        if (\App\Models\JenisAlat::count() === 0) {
            \Artisan::call('db:seed', ['--class' => 'JenisAlatSeeder']);
            \Log::info('JenisAlatSeeder executed');
        }
        
        // Cek dan jalankan seeder stok alat jika tidak ada data
        if (\App\Models\StokAlat::count() === 0) {
            \Artisan::call('db:seed', ['--class' => 'StokAlatSeeder']);
            \Log::info('StokAlatSeeder executed');
        }
        
        // Pastikan setiap jenis alat memiliki stok alat
        $jenisAlats = \App\Models\JenisAlat::all();
        foreach ($jenisAlats as $jenisAlat) {
            $stokAlat = \App\Models\StokAlat::where('jenis_alat_id', $jenisAlat->id)->first();
            if (!$stokAlat) {
                // Buat stok alat untuk jenis alat ini
                \App\Models\StokAlat::create([
                    'jenis_alat_id' => $jenisAlat->id,
                    'nama_alat' => $jenisAlat->nama,
                    'stok_total' => 10,
                    'stok_tersedia' => 10,
                    'harga_sewa' => $this->getDefaultHarga($jenisAlat->kode),
                    'deskripsi' => $jenisAlat->deskripsi,
                    'is_active' => true
                ]);
                \Log::info('Created stok alat for jenis alat:', [
                    'jenis_alat_id' => $jenisAlat->id,
                    'jenis_alat_kode' => $jenisAlat->kode,
                    'jenis_alat_nama' => $jenisAlat->nama
                ]);
            }
        }
    }
    
    // Method untuk mendapatkan harga default berdasarkan kode
    private function getDefaultHarga($kode)
    {
        return match($kode) {
            '001', 'ban_renang' => 15000,
            '002', 'kacamata_renang' => 10000,
            '003', 'papan_renang' => 20000,
            '004', 'pelampung' => 15000,
            '005', 'fins' => 25000,
            '006', 'snorkel' => 20000,
            default => 15000
        };
    }

    // Menampilkan form booking sewa alat untuk user
    public function create()
    {
        // Pastikan data jenis alat dan stok alat tersedia
        $this->ensureDataAvailable();
        
        // Ambil jenis alat yang aktif dari database
        $jenisAlats = \App\Models\JenisAlat::getActiveJenisAlat();
        
        // Ambil stok alat yang tersedia
        $stokAlats = \App\Models\StokAlat::with('jenisAlat')
            ->where('is_active', true)
            ->where('stok_tersedia', '>', 0)
            ->get();
        
        return view('booking.sewa-alat.create', compact('jenisAlats', 'stokAlats'));
    }

    // Menyimpan booking sewa alat baru
    public function store(Request $request)
    {
        // Debug: Log request data
        \Log::info('Booking sewa alat request:', $request->all());
        \Log::info('Files:', $request->allFiles());
        
        try {
            $request->validate([
                'nama_penyewa' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:15',
                'tanggal_sewa' => 'required|date|after:today',
                'jenis_jaminan' => 'required|in:ktp,sim',
                'foto_jaminan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'jenis_alat' => 'required|exists:jenis_alats,kode',
                'jumlah_alat' => 'required|integer|min:1|max:20',
                'catatan' => 'nullable|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            throw $e;
        }

        // Cek stok alat
        $stokAlat = \App\Models\StokAlat::getStokByJenis($request->jenis_alat);
        if (!$stokAlat || !$stokAlat->isStokTersedia($request->jumlah_alat)) {
            return back()->with('error', 'Stok alat tidak mencukupi! Stok tersedia: ' . ($stokAlat ? $stokAlat->stok_tersedia : 0));
        }

        // Upload foto jaminan
        $fileName = time() . '_' . $request->file('foto_jaminan')->getClientOriginalName();
        $filePath = $request->file('foto_jaminan')->storeAs('foto_jaminan', $fileName, 'public');

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
        $bookings = Auth::user()->bookingSewaAlat()->latest()->get();
        return view('booking.sewa-alat.history', compact('bookings'));
    }

    // Menampilkan detail booking sewa alat
    public function show(BookingSewaAlat $bookingSewaAlat)
    {
        $user = Auth::user();
        
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
        // Perbaiki jenis alat pada semua booking
        $this->fixBookingJenisAlat();
        
        $bookings = BookingSewaAlat::with('user')->latest()->get();
        return view('admin.booking-sewa-alat.index', compact('bookings'));
    }

    // Menyetujui booking sewa alat
    public function approve(BookingSewaAlat $bookingSewaAlat)
    {
        // Debug: Log informasi booking
        \Log::info('Approving booking sewa alat:', [
            'booking_id' => $bookingSewaAlat->id,
            'jenis_alat' => $bookingSewaAlat->jenis_alat,
            'jumlah_alat' => $bookingSewaAlat->jumlah_alat,
            'status' => $bookingSewaAlat->status
        ]);

        // Pastikan data jenis alat dan stok alat tersedia
        $this->ensureDataAvailable();

        // Perbaiki semua booking yang bermasalah
        $this->fixBookingJenisAlat();

        // Refresh booking data setelah fix
        $bookingSewaAlat->refresh();

        // Debug: Log semua jenis alat yang tersedia
        $allJenisAlat = \App\Models\JenisAlat::all();
        \Log::info('Available jenis alat:', [
            'count' => $allJenisAlat->count(),
            'codes' => $allJenisAlat->pluck('kode')->toArray(),
            'booking_jenis_alat' => $bookingSewaAlat->jenis_alat
        ]);

        // Test: Cek apakah jenis alat ada
        $jenisAlat = \App\Models\JenisAlat::getByKode($bookingSewaAlat->jenis_alat);
        if (!$jenisAlat) {
            // Coba perbaiki jenis alat yang tidak sesuai
            $availableJenisAlat = \App\Models\JenisAlat::pluck('kode')->toArray();
            $firstJenisAlat = \App\Models\JenisAlat::first();
            
            if ($firstJenisAlat) {
                // Update booking dengan jenis alat yang tersedia
                $bookingSewaAlat->update(['jenis_alat' => $firstJenisAlat->kode]);
                $jenisAlat = $firstJenisAlat;
                
                \Log::info('Fixed booking jenis alat:', [
                    'booking_id' => $bookingSewaAlat->id,
                    'old_jenis_alat' => $bookingSewaAlat->jenis_alat,
                    'new_jenis_alat' => $firstJenisAlat->kode
                ]);
            } else {
                \Log::error('Jenis alat not found for booking:', [
                    'booking_id' => $bookingSewaAlat->id,
                    'jenis_alat' => $bookingSewaAlat->jenis_alat,
                    'available_jenis_alat' => $availableJenisAlat
                ]);
                return redirect()->route('admin.booking-sewa-alat.index')
                    ->with('error', 'Jenis alat tidak ditemukan! Kode: ' . $bookingSewaAlat->jenis_alat . '. Silakan tambahkan jenis alat terlebih dahulu.');
            }
        }

        // Debug: Log jenis alat yang ditemukan
        \Log::info('Found jenis alat:', [
            'jenis_alat_id' => $jenisAlat->id,
            'jenis_alat_kode' => $jenisAlat->kode,
            'jenis_alat_nama' => $jenisAlat->nama
        ]);

        // Test: Cek stok alat
        $stokAlat = \App\Models\StokAlat::where('jenis_alat_id', $jenisAlat->id)
            ->where('is_active', true)
            ->first();
        
        if (!$stokAlat) {
            // Coba buat stok alat jika tidak ada
            \Log::info('Stok alat not found, creating new stok alat for jenis alat:', [
                'jenis_alat_id' => $jenisAlat->id,
                'jenis_alat_kode' => $jenisAlat->kode,
                'jenis_alat_nama' => $jenisAlat->nama
            ]);
            
            // Jalankan seeder stok alat
            \Artisan::call('db:seed', ['--class' => 'StokAlatSeeder']);
            \Log::info('StokAlatSeeder executed');
            
            // Coba ambil stok alat lagi
            $stokAlat = \App\Models\StokAlat::where('jenis_alat_id', $jenisAlat->id)
                ->where('is_active', true)
                ->first();
                
            if (!$stokAlat) {
                \Log::error('Stok alat still not found after seeder:', [
                    'booking_id' => $bookingSewaAlat->id,
                    'jenis_alat_id' => $jenisAlat->id,
                    'jenis_alat_kode' => $jenisAlat->kode
                ]);
                return redirect()->route('admin.booking-sewa-alat.index')
                    ->with('error', 'Stok alat tidak ditemukan untuk jenis alat: ' . $jenisAlat->nama . '! Silakan tambahkan stok alat terlebih dahulu.');
            }
        }

        if ($stokAlat->stok_tersedia < $bookingSewaAlat->jumlah_alat) {
            \Log::error('Insufficient stock for booking:', [
                'booking_id' => $bookingSewaAlat->id,
                'stok_tersedia' => $stokAlat->stok_tersedia,
                'jumlah_dibutuhkan' => $bookingSewaAlat->jumlah_alat
            ]);
            return redirect()->route('admin.booking-sewa-alat.index')
                ->with('error', 'Stok alat tidak mencukupi! Stok tersedia: ' . $stokAlat->stok_tersedia);
        }

        // Update status booking (tanpa mengurangi stok)
        $bookingSewaAlat->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        \Log::info('Booking approved successfully:', [
            'booking_id' => $bookingSewaAlat->id,
            'new_status' => 'approved',
            'stok_checked' => $bookingSewaAlat->jumlah_alat
        ]);

        return redirect()->route('admin.booking-sewa-alat.index')->with('success', 'Booking sewa alat berhasil disetujui! Stok akan dikurangi setelah pembayaran disetujui.');
    }

    // Method untuk memperbaiki jenis alat pada semua booking
    private function fixBookingJenisAlat()
    {
        $bookings = \App\Models\BookingSewaAlat::all();
        $jenisAlats = \App\Models\JenisAlat::all();
        
        if ($jenisAlats->isEmpty()) {
            return;
        }
        
        // Mapping untuk jenis alat yang umum
        $jenisAlatMapping = [
            'ban_renang' => '001',
            'kacamata_renang' => '002',
            'papan_renang' => '003',
            'pelampung' => '004',
            'fins' => '005',
            'snorkel' => '006'
        ];
        
        foreach ($bookings as $booking) {
            $jenisAlat = \App\Models\JenisAlat::getByKode($booking->jenis_alat);
            if (!$jenisAlat) {
                // Coba mapping dulu
                if (isset($jenisAlatMapping[$booking->jenis_alat])) {
                    $mappedKode = $jenisAlatMapping[$booking->jenis_alat];
                    $jenisAlat = \App\Models\JenisAlat::where('kode', $mappedKode)->first();
                    if ($jenisAlat) {
                        $booking->update(['jenis_alat' => $mappedKode]);
                        \Log::info('Fixed booking jenis alat using mapping:', [
                            'booking_id' => $booking->id,
                            'old_jenis_alat' => $booking->jenis_alat,
                            'new_jenis_alat' => $mappedKode
                        ]);
                        continue;
                    }
                }
                
                // Jika mapping gagal, gunakan jenis alat pertama
                $firstJenisAlat = $jenisAlats->first();
                $booking->update(['jenis_alat' => $firstJenisAlat->kode]);
                \Log::info('Fixed booking jenis alat using first available:', [
                    'booking_id' => $booking->id,
                    'old_jenis_alat' => $booking->jenis_alat,
                    'new_jenis_alat' => $firstJenisAlat->kode
                ]);
            }
        }
    }

    // Menolak booking sewa alat
    public function reject(Request $request, BookingSewaAlat $bookingSewaAlat)
    {
        $request->validate([
            'catatan_admin' => 'required|string'
        ]);

        // Jika booking sudah disetujui sebelumnya, kembalikan stok
        if ($bookingSewaAlat->status === 'approved') {
            $bookingSewaAlat->kembalikanStokTanpaStatus();
        }

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
        // Debug: Log informasi booking
        \Log::info('Confirming payment for booking:', [
            'booking_id' => $bookingSewaAlat->id,
            'jenis_alat' => $bookingSewaAlat->jenis_alat,
            'jumlah_alat' => $bookingSewaAlat->jumlah_alat,
            'status' => $bookingSewaAlat->status,
            'status_pembayaran' => $bookingSewaAlat->status_pembayaran
        ]);

        // Pastikan data jenis alat dan stok alat tersedia
        $this->ensureDataAvailable();

        // Cek apakah booking sudah approved
        if ($bookingSewaAlat->status !== 'approved') {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Booking harus disetujui terlebih dahulu sebelum pembayaran dapat dikonfirmasi!');
        }

        // Cek dan perbaiki jenis alat jika diperlukan
        $jenisAlat = \App\Models\JenisAlat::getByKode($bookingSewaAlat->jenis_alat);
        if (!$jenisAlat) {
            // Coba perbaiki data jenis alat
            $this->fixBookingJenisAlat();
            
            // Coba lagi setelah perbaikan
            $jenisAlat = \App\Models\JenisAlat::getByKode($bookingSewaAlat->jenis_alat);
            if (!$jenisAlat) {
                // Jika masih tidak ditemukan, gunakan jenis alat pertama yang tersedia
                $firstJenisAlat = \App\Models\JenisAlat::where('is_active', true)->first();
                if ($firstJenisAlat) {
                    $bookingSewaAlat->update(['jenis_alat' => $firstJenisAlat->kode]);
                    $jenisAlat = $firstJenisAlat;
                    \Log::info('Fixed booking jenis alat to first available:', [
                        'booking_id' => $bookingSewaAlat->id,
                        'new_jenis_alat' => $firstJenisAlat->kode
                    ]);
                } else {
                    return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                        ->with('error', 'Tidak ada jenis alat yang tersedia dalam sistem!');
                }
            }
        }

        $stokAlat = \App\Models\StokAlat::where('jenis_alat_id', $jenisAlat->id)
            ->where('is_active', true)
            ->first();

        if (!$stokAlat) {
            // Coba buat stok alat untuk jenis alat ini
            $stokAlat = \App\Models\StokAlat::create([
                'jenis_alat_id' => $jenisAlat->id,
                'nama_alat' => $jenisAlat->nama,
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'harga_sewa' => $this->getDefaultHarga($jenisAlat->kode),
                'deskripsi' => $jenisAlat->deskripsi,
                'is_active' => true
            ]);
            \Log::info('Created stok alat for jenis alat:', [
                'jenis_alat_id' => $jenisAlat->id,
                'jenis_alat_kode' => $jenisAlat->kode,
                'jenis_alat_nama' => $jenisAlat->nama
            ]);
        }

        if ($stokAlat->stok_tersedia < $bookingSewaAlat->jumlah_alat) {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Stok alat tidak mencukupi! Stok tersedia: ' . $stokAlat->stok_tersedia);
        }

        // Kurangi stok saat pembayaran dikonfirmasi
        if ($stokAlat->kurangiStok($bookingSewaAlat->jumlah_alat)) {
            // Update status pembayaran
            $bookingSewaAlat->update([
                'status_pembayaran' => 'lunas'
            ]);

            \Log::info('Payment confirmed and stock reduced successfully:', [
                'booking_id' => $bookingSewaAlat->id,
                'stok_reduced' => $bookingSewaAlat->jumlah_alat,
                'new_stok_tersedia' => $stokAlat->stok_tersedia
            ]);

            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('success', 'Pembayaran berhasil dikonfirmasi dan stok alat telah dikurangi!');
        } else {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Gagal mengurangi stok alat!');
        }
    }

    // Approve pembayaran (alias untuk confirmPayment)
    public function approvePayment(Request $request, BookingSewaAlat $bookingSewaAlat)
    {
        // Debug: Log informasi booking
        \Log::info('Approving payment for booking:', [
            'booking_id' => $bookingSewaAlat->id,
            'jenis_alat' => $bookingSewaAlat->jenis_alat,
            'jumlah_alat' => $bookingSewaAlat->jumlah_alat,
            'status' => $bookingSewaAlat->status,
            'status_pembayaran' => $bookingSewaAlat->status_pembayaran
        ]);

        // Pastikan data jenis alat dan stok alat tersedia
        $this->ensureDataAvailable();

        // Cek apakah booking sudah approved
        if ($bookingSewaAlat->status !== 'approved') {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Booking harus disetujui terlebih dahulu sebelum pembayaran dapat disetujui!');
        }

        // Cek dan perbaiki jenis alat jika diperlukan
        $jenisAlat = \App\Models\JenisAlat::getByKode($bookingSewaAlat->jenis_alat);
        if (!$jenisAlat) {
            // Coba perbaiki data jenis alat
            $this->fixBookingJenisAlat();
            
            // Coba lagi setelah perbaikan
            $jenisAlat = \App\Models\JenisAlat::getByKode($bookingSewaAlat->jenis_alat);
            if (!$jenisAlat) {
                // Jika masih tidak ditemukan, gunakan jenis alat pertama yang tersedia
                $firstJenisAlat = \App\Models\JenisAlat::where('is_active', true)->first();
                if ($firstJenisAlat) {
                    $bookingSewaAlat->update(['jenis_alat' => $firstJenisAlat->kode]);
                    $jenisAlat = $firstJenisAlat;
                    \Log::info('Fixed booking jenis alat to first available:', [
                        'booking_id' => $bookingSewaAlat->id,
                        'new_jenis_alat' => $firstJenisAlat->kode
                    ]);
                } else {
                    return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                        ->with('error', 'Tidak ada jenis alat yang tersedia dalam sistem!');
                }
            }
        }

        $stokAlat = \App\Models\StokAlat::where('jenis_alat_id', $jenisAlat->id)
            ->where('is_active', true)
            ->first();

        if (!$stokAlat) {
            // Coba buat stok alat untuk jenis alat ini
            $stokAlat = \App\Models\StokAlat::create([
                'jenis_alat_id' => $jenisAlat->id,
                'nama_alat' => $jenisAlat->nama,
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'harga_sewa' => $this->getDefaultHarga($jenisAlat->kode),
                'deskripsi' => $jenisAlat->deskripsi,
                'is_active' => true
            ]);
            \Log::info('Created stok alat for jenis alat:', [
                'jenis_alat_id' => $jenisAlat->id,
                'jenis_alat_kode' => $jenisAlat->kode,
                'jenis_alat_nama' => $jenisAlat->nama
            ]);
        }

        if ($stokAlat->stok_tersedia < $bookingSewaAlat->jumlah_alat) {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Stok alat tidak mencukupi! Stok tersedia: ' . $stokAlat->stok_tersedia);
        }

        // Kurangi stok saat pembayaran disetujui
        if ($stokAlat->kurangiStok($bookingSewaAlat->jumlah_alat)) {
            // Update status pembayaran
            $bookingSewaAlat->update([
                'status_pembayaran' => 'lunas',
                'catatan_admin' => $request->catatan_admin
            ]);

            \Log::info('Payment approved and stock reduced successfully:', [
                'booking_id' => $bookingSewaAlat->id,
                'stok_reduced' => $bookingSewaAlat->jumlah_alat,
                'new_stok_tersedia' => $stokAlat->stok_tersedia
            ]);

            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('success', 'Pembayaran berhasil disetujui dan stok alat telah dikurangi!');
        } else {
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('error', 'Gagal mengurangi stok alat!');
        }
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

        // Hanya bisa dibatalkan jika masih pending atau belum bayar
        if (!in_array($bookingSewaAlat->status, ['pending']) || 
            !in_array($bookingSewaAlat->status_pembayaran, ['belum_bayar', 'menunggu_konfirmasi'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan!');
        }

        // Jika booking sudah disetujui dan pembayaran lunas, kembalikan stok
        if ($bookingSewaAlat->status === 'approved' && $bookingSewaAlat->status_pembayaran === 'lunas') {
            $bookingSewaAlat->kembalikanStokTanpaStatus();
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
        // Debug: Log informasi booking
        \Log::info('Attempting to return alat:', [
            'booking_id' => $bookingSewaAlat->id,
            'status' => $bookingSewaAlat->status,
            'status_pembayaran' => $bookingSewaAlat->status_pembayaran,
            'alat_dikembalikan' => $bookingSewaAlat->alat_dikembalikan,
            'bisa_dikembalikan' => $bookingSewaAlat->bisaDikembalikan()
        ]);

        // Debug: Cek data jenis alat yang ada
        $jenisAlats = \App\Models\JenisAlat::all();
        \Log::info('Available jenis alat:', [
            'jenis_alat_count' => $jenisAlats->count(),
            'jenis_alat_codes' => $jenisAlats->pluck('kode')->toArray(),
            'booking_jenis_alat' => $bookingSewaAlat->jenis_alat
        ]);

        if (!$bookingSewaAlat->bisaDikembalikan()) {
            \Log::error('Alat tidak dapat dikembalikan:', [
                'booking_id' => $bookingSewaAlat->id,
                'status' => $bookingSewaAlat->status,
                'status_pembayaran' => $bookingSewaAlat->status_pembayaran,
                'alat_dikembalikan' => $bookingSewaAlat->alat_dikembalikan
            ]);
            return back()->with('error', 'Alat tidak dapat dikembalikan! Status: ' . $bookingSewaAlat->status . ', Pembayaran: ' . $bookingSewaAlat->status_pembayaran);
        }

        if ($bookingSewaAlat->kembalikanStok()) {
            \Log::info('Alat berhasil dikembalikan:', [
                'booking_id' => $bookingSewaAlat->id
            ]);
            return redirect()->route('admin.booking-sewa-alat.show', $bookingSewaAlat)
                ->with('success', 'Alat berhasil dikembalikan dan stok telah ditambah!');
        } else {
            \Log::error('Gagal mengembalikan alat:', [
                'booking_id' => $bookingSewaAlat->id
            ]);
            return back()->with('error', 'Gagal mengembalikan alat!');
        }
    }

    // Method untuk admin membatalkan booking yang sudah disetujui
    public function cancelApproved(BookingSewaAlat $bookingSewaAlat)
    {
        // Hanya bisa dibatalkan jika sudah disetujui
        if ($bookingSewaAlat->status !== 'approved') {
            return back()->with('error', 'Booking tidak dapat dibatalkan!');
        }

        // Kembalikan stok hanya jika pembayaran sudah lunas (stok sudah dikurangi)
        if ($bookingSewaAlat->status_pembayaran === 'lunas') {
            $bookingSewaAlat->kembalikanStokTanpaStatus();
            $message = 'Booking berhasil dibatalkan dan stok telah dikembalikan!';
        } else {
            $message = 'Booking berhasil dibatalkan!';
        }

        $bookingSewaAlat->update([
            'status' => 'dibatalkan',
            'catatan_admin' => 'Dibatalkan oleh admin'
        ]);

        return redirect()->route('admin.booking-sewa-alat.index')->with('success', $message);
    }
}
