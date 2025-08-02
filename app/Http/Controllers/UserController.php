<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingKelas;
use App\Models\BookingSewaAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Dashboard User
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Check dan update status membership
        $user->checkAndUpdateMembershipStatus();
        
        // Hitung total booking dari semua jenis booking
        $totalBookingKolam = Booking::where('user_id', $user->id)->count();
        $totalBookingKelas = BookingKelas::where('user_id', $user->id)->count();
        $totalBookingSewaAlat = BookingSewaAlat::where('user_id', $user->id)->count();
        $totalBookings = $totalBookingKolam + $totalBookingKelas + $totalBookingSewaAlat;
        
        // Hitung booking berdasarkan status
        $pendingBookings = Booking::where('user_id', $user->id)->where('status', 'pending')->count() +
                          BookingKelas::where('user_id', $user->id)->where('status', 'pending')->count() +
                          BookingSewaAlat::where('user_id', $user->id)->where('status', 'pending')->count();
                          
        $approvedBookings = Booking::where('user_id', $user->id)->where('status', 'approved')->count() +
                           BookingKelas::where('user_id', $user->id)->where('status', 'approved')->count() +
                           BookingSewaAlat::where('user_id', $user->id)->where('status', 'approved')->count();
        
        // Ambil booking terbaru dari semua jenis
        $recentBookings = collect();
        
        // Booking kolam terbaru
        $recentBookingKolam = Booking::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function($booking) {
                $booking->booking_type = 'kolam';
                return $booking;
            });
            
        // Booking kelas terbaru
        $recentBookingKelas = BookingKelas::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function($booking) {
                $booking->booking_type = 'kelas';
                return $booking;
            });
            
        // Booking sewa alat terbaru
        $recentBookingSewaAlat = BookingSewaAlat::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function($booking) {
                $booking->booking_type = 'sewa_alat';
                return $booking;
            });
        
        // Gabungkan dan urutkan berdasarkan created_at
        $recentBookings = $recentBookingKolam
            ->concat($recentBookingKelas)
            ->concat($recentBookingSewaAlat)
            ->sortByDesc('created_at')
            ->take(5);
        
        // Ambil booking dengan pembayaran ditolak untuk notifikasi
        $rejectedPaymentKelas = BookingKelas::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('status_pembayaran', 'ditolak')
            ->get();
            
        $rejectedPaymentSewaAlat = BookingSewaAlat::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('status_pembayaran', 'ditolak')
            ->get();
        
        return view('user.dashboard', compact(
            'user', 
            'totalBookings',
            'totalBookingKolam',
            'totalBookingKelas', 
            'totalBookingSewaAlat',
            'pendingBookings',
            'approvedBookings',
            'recentBookings',
            'rejectedPaymentKelas', 
            'rejectedPaymentSewaAlat'
        ));
    }

    /**
     * Profile User
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Halaman Home User
     */
    public function home()
    {
        $user = Auth::user();
        return view('user.home', compact('user'));
    }

    /**
     * Halaman Fasilitas
     */
    public function fasilitas()
    {
        $user = Auth::user();
        return view('user.fasilitas', compact('user'));
    }

    /**
     * Halaman Informasi & Aturan
     */
    public function informasi()
    {
        $user = Auth::user();
        return view('user.informasi', compact('user'));
    }

    /**
     * Booking Kolam (contoh untuk sistem kolam renang)
     */
    public function booking()
    {
        // Redirect ke halaman history booking
        return redirect()->route('user.booking.history');
    }
} 