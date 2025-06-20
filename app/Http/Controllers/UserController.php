<?php

namespace App\Http\Controllers;

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
        return view('user.dashboard', compact('user'));
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