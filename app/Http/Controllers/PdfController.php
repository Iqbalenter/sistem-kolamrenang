<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingKelas;
use App\Models\BookingSewaAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    /**
     * Export PDF untuk detail booking kolam
     */
    public function exportBookingKolamDetail(Booking $booking)
    {
        // Pastikan user hanya bisa export booking miliknya sendiri
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        $user = Auth::user();
        
        $pdf = Pdf::loadView('pdf.booking-kolam-detail', [
            'booking' => $booking,
            'user' => $user
        ]);
        
        return $pdf->download('detail-booking-kolam-' . $booking->id . '-' . $user->name . '.pdf');
    }

    /**
     * Export PDF untuk detail booking kelas
     */
    public function exportBookingKelasDetail(BookingKelas $bookingKelas)
    {
        // Pastikan user hanya bisa export booking miliknya sendiri
        if ($bookingKelas->user_id !== Auth::id()) {
            abort(403);
        }
        
        $user = Auth::user();
        
        $pdf = Pdf::loadView('pdf.booking-kelas-detail', [
            'bookingKelas' => $bookingKelas,
            'user' => $user
        ]);
        
        return $pdf->download('detail-booking-kelas-' . $bookingKelas->id . '-' . $user->name . '.pdf');
    }

    /**
     * Export PDF untuk detail booking sewa alat
     */
    public function exportBookingSewaAlatDetail(BookingSewaAlat $bookingSewaAlat)
    {
        // Pastikan user hanya bisa export booking miliknya sendiri
        if ($bookingSewaAlat->user_id !== Auth::id()) {
            abort(403);
        }
        
        $user = Auth::user();
        
        $pdf = Pdf::loadView('pdf.booking-sewa-alat-detail', [
            'bookingSewaAlat' => $bookingSewaAlat,
            'user' => $user
        ]);
        
        return $pdf->download('detail-booking-sewa-alat-' . $bookingSewaAlat->id . '-' . $user->name . '.pdf');
    }

    /**
     * Export PDF untuk riwayat booking kolam (semua)
     */
    public function exportBookingKolam()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->latest()->get();
        
        $pdf = Pdf::loadView('pdf.booking-kolam', [
            'bookings' => $bookings,
            'user' => $user
        ]);
        
        return $pdf->download('riwayat-booking-kolam-' . $user->name . '.pdf');
    }

    /**
     * Export PDF untuk riwayat booking kelas (semua)
     */
    public function exportBookingKelas()
    {
        $user = Auth::user();
        $bookings = BookingKelas::where('user_id', $user->id)->latest()->get();
        
        $pdf = Pdf::loadView('pdf.booking-kelas', [
            'bookings' => $bookings,
            'user' => $user
        ]);
        
        return $pdf->download('riwayat-booking-kelas-' . $user->name . '.pdf');
    }

    /**
     * Export PDF untuk riwayat booking sewa alat (semua)
     */
    public function exportBookingSewaAlat()
    {
        $user = Auth::user();
        $bookings = BookingSewaAlat::where('user_id', $user->id)->latest()->get();
        
        $pdf = Pdf::loadView('pdf.booking-sewa-alat', [
            'bookings' => $bookings,
            'user' => $user
        ]);
        
        return $pdf->download('riwayat-booking-sewa-alat-' . $user->name . '.pdf');
    }

    /**
     * Export PDF untuk semua jenis booking
     */
    public function exportAllBookings()
    {
        $user = Auth::user();
        
        $bookingsKolam = Booking::where('user_id', $user->id)->latest()->get();
        $bookingsKelas = BookingKelas::where('user_id', $user->id)->latest()->get();
        $bookingsSewaAlat = BookingSewaAlat::where('user_id', $user->id)->latest()->get();
        
        $pdf = Pdf::loadView('pdf.all-bookings', [
            'bookingsKolam' => $bookingsKolam,
            'bookingsKelas' => $bookingsKelas,
            'bookingsSewaAlat' => $bookingsSewaAlat,
            'user' => $user
        ]);
        
        return $pdf->download('riwayat-semua-booking-' . $user->name . '.pdf');
    }
}
