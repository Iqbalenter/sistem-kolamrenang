<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Booking;
use App\Models\BookingKelas;
use App\Models\BookingSewaAlat;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        // Statistik booking kolam
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $totalRevenue = Booking::where('status_pembayaran', 'lunas')->sum('total_harga');
        
        // Statistik booking kelas
        $totalBookingKelas = BookingKelas::count();
        $pendingBookingKelas = BookingKelas::where('status', 'pending')->count();
        $approvedBookingKelas = BookingKelas::where('status', 'approved')->count();
        $revenueBookingKelas = BookingKelas::where('status_pembayaran', 'lunas')->sum('total_harga');
        
        // Statistik booking sewa alat
        $totalBookingSewaAlat = BookingSewaAlat::count();
        $pendingBookingSewaAlat = BookingSewaAlat::where('status', 'pending')->count();
        $approvedBookingSewaAlat = BookingSewaAlat::where('status', 'approved')->count();
        $revenueBookingSewaAlat = BookingSewaAlat::where('status_pembayaran', 'lunas')->sum('total_harga');
        
        // Pemesanan terbaru kolam (5 terakhir)
        $recentBookings = Booking::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Pemesanan terbaru kelas (5 terakhir)
        $recentBookingKelas = BookingKelas::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // Pemesanan terbaru sewa alat (5 terakhir)
        $recentBookingSewaAlat = BookingSewaAlat::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Booking mendatang kolam (yang sudah approved dan tanggal booking >= hari ini)
        $upcomingBookings = Booking::with('user')
            ->where('status', 'approved')
            ->where('tanggal_booking', '>=', Carbon::today())
            ->orderBy('tanggal_booking', 'asc')
            ->orderBy('created_at', 'asc') // Sort berdasarkan waktu booking dibuat
            ->take(5)
            ->get();
            
        // Booking mendatang kelas (yang sudah approved dan tanggal kelas >= hari ini)
        $upcomingBookingKelas = BookingKelas::with('user')
            ->where('status', 'approved')
            ->where('tanggal_kelas', '>=', Carbon::today())
            ->orderBy('tanggal_kelas', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->take(5)
            ->get();
            
        // Booking mendatang sewa alat (yang sudah approved dan tanggal sewa >= hari ini)
        $upcomingBookingSewaAlat = BookingSewaAlat::with('user')
            ->where('status', 'approved')
            ->where('tanggal_sewa', '>=', Carbon::today())
            ->orderBy('tanggal_sewa', 'asc')
            ->take(5)
            ->get();
        
        // Booking hari ini
        $todayBookings = Booking::with('user')
            ->where('tanggal_booking', Carbon::today())
            ->where('status', 'approved')
            ->count();
            
        // Total pending untuk semua jenis booking (untuk notifikasi sidebar)
        $totalPendingBookings = $pendingBookings;
        $totalPendingBookingKelas = $pendingBookingKelas;
        $totalPendingBookingSewaAlat = $pendingBookingSewaAlat;
        
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalAdmins', 
            'totalBookings', 
            'pendingBookings', 
            'approvedBookings', 
            'totalRevenue',
            'totalBookingKelas',
            'pendingBookingKelas',
            'approvedBookingKelas',
            'revenueBookingKelas',
            'totalBookingSewaAlat',
            'pendingBookingSewaAlat',
            'approvedBookingSewaAlat',
            'revenueBookingSewaAlat',
            'recentBookings',
            'recentBookingKelas',
            'recentBookingSewaAlat',
            'upcomingBookings',
            'upcomingBookingKelas',
            'upcomingBookingSewaAlat',
            'todayBookings',
            'totalPendingBookings',
            'totalPendingBookingKelas',
            'totalPendingBookingSewaAlat'
        ));
    }

    /**
     * Kelola User
     */
    public function users()
    {
        $users = User::where('role', 'user')->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Edit User
     */
    public function editUser(User $user)
    {
        // Pastikan hanya bisa edit user dengan role 'user', bukan admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat mengedit data admin!');
        }
        
        return view('admin.users-edit', compact('user'));
    }

    /**
     * Update User
     */
    public function updateUser(Request $request, User $user)
    {
        // Pastikan hanya bisa edit user dengan role 'user', bukan admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat mengedit data admin!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Delete User
     */
    public function deleteUser(User $user)
    {
        // Pastikan hanya bisa hapus user dengan role 'user', bukan admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus data admin!');
        }

        // Cek apakah user memiliki booking yang masih pending atau approved
        $activeBookings = $user->bookings()->whereIn('status', ['pending', 'approved'])->count();
        
        if ($activeBookings > 0) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus user yang memiliki booking aktif!');
        }

        // Hapus semua booking user yang sudah completed/rejected
        $user->bookings()->delete();
        
        // Hapus user
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Profile Admin
     */
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }
} 