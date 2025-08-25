<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingKelasController;
use App\Http\Controllers\BookingSewaAlatController;
use App\Http\Controllers\StokAlatController;
use App\Http\Controllers\JenisAlatController;
use App\Http\Controllers\PdfController;

// Route untuk halaman utama (welcome/landing page)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes untuk Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Routes untuk Logout (semua user yang sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Routes untuk Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    
    // Routes untuk booking admin
    Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('admin.bookings.show');
    Route::patch('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('admin.bookings.approve');
    Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('admin.bookings.reject');
    Route::patch('/bookings/{booking}/confirm-payment', [BookingController::class, 'confirmPayment'])->name('admin.bookings.confirm-payment');
    Route::patch('/bookings/{booking}/reject-payment', [BookingController::class, 'rejectPayment'])->name('admin.bookings.reject-payment');
    Route::patch('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('admin.bookings.complete');
    Route::delete('/bookings/{booking}', [BookingController::class, 'deleteBooking'])->name('admin.bookings.delete');
    
    // Routes untuk booking kelas admin
    Route::get('/booking-kelas', [BookingKelasController::class, 'adminIndex'])->name('admin.booking-kelas.index');
    Route::get('/booking-kelas/{bookingKelas}', [BookingKelasController::class, 'show'])->name('admin.booking-kelas.show');
    Route::patch('/booking-kelas/{bookingKelas}/approve', [BookingKelasController::class, 'approve'])->name('admin.booking-kelas.approve');
    Route::patch('/booking-kelas/{bookingKelas}/reject', [BookingKelasController::class, 'reject'])->name('admin.booking-kelas.reject');
    Route::patch('/booking-kelas/{bookingKelas}/approve-payment', [BookingKelasController::class, 'approvePayment'])->name('admin.booking-kelas.approve-payment');
    Route::patch('/booking-kelas/{bookingKelas}/reject-payment', [BookingKelasController::class, 'rejectPayment'])->name('admin.booking-kelas.reject-payment');
    Route::patch('/booking-kelas/{bookingKelas}/confirm', [BookingKelasController::class, 'confirm'])->name('admin.booking-kelas.confirm');
    Route::patch('/booking-kelas/{bookingKelas}/complete', [BookingKelasController::class, 'complete'])->name('admin.booking-kelas.complete');
    Route::delete('/booking-kelas/{bookingKelas}', [BookingKelasController::class, 'deleteBooking'])->name('admin.booking-kelas.delete');
    
    // Routes untuk booking sewa alat admin
    Route::get('/booking-sewa-alat', [BookingSewaAlatController::class, 'adminIndex'])->name('admin.booking-sewa-alat.index');
    Route::get('/booking-sewa-alat/{bookingSewaAlat}', [BookingSewaAlatController::class, 'show'])->name('admin.booking-sewa-alat.show');
    Route::patch('/booking-sewa-alat/{bookingSewaAlat}/approve', [BookingSewaAlatController::class, 'approve'])->name('admin.booking-sewa-alat.approve');
    Route::patch('/booking-sewa-alat/{bookingSewaAlat}/reject', [BookingSewaAlatController::class, 'reject'])->name('admin.booking-sewa-alat.reject');
    Route::patch('/booking-sewa-alat/{bookingSewaAlat}/approve-payment', [BookingSewaAlatController::class, 'approvePayment'])->name('admin.booking-sewa-alat.approve-payment');
    Route::patch('/booking-sewa-alat/{bookingSewaAlat}/reject-payment', [BookingSewaAlatController::class, 'rejectPayment'])->name('admin.booking-sewa-alat.reject-payment');
    Route::patch('/booking-sewa-alat/{bookingSewaAlat}/confirm', [BookingSewaAlatController::class, 'confirm'])->name('admin.booking-sewa-alat.confirm');
    Route::patch('/booking-sewa-alat/{bookingSewaAlat}/complete', [BookingSewaAlatController::class, 'complete'])->name('admin.booking-sewa-alat.complete');
    Route::patch('/booking-sewa-alat/{bookingSewaAlat}/kembalikan-alat', [BookingSewaAlatController::class, 'kembalikanAlat'])->name('admin.booking-sewa-alat.kembalikan-alat');
    Route::delete('/booking-sewa-alat/{bookingSewaAlat}', [BookingSewaAlatController::class, 'deleteBooking'])->name('admin.booking-sewa-alat.delete');
    
    // Routes untuk kelola jenis alat
    Route::resource('jenis-alat', JenisAlatController::class, [
        'names' => [
            'index' => 'admin.jenis-alat.index',
            'create' => 'admin.jenis-alat.create',
            'store' => 'admin.jenis-alat.store',
            'edit' => 'admin.jenis-alat.edit',
            'update' => 'admin.jenis-alat.update',
            'destroy' => 'admin.jenis-alat.destroy'
        ]
    ]);
    
    // Routes untuk kelola stok alat
    Route::resource('stok-alat', StokAlatController::class, [
        'names' => [
            'index' => 'admin.stok-alat.index',
            'create' => 'admin.stok-alat.create',
            'store' => 'admin.stok-alat.store',
            'edit' => 'admin.stok-alat.edit',
            'update' => 'admin.stok-alat.update',
            'destroy' => 'admin.stok-alat.destroy'
        ]
    ]);
    Route::post('/stok-alat/{stokAlat}/adjust', [StokAlatController::class, 'adjustStok'])->name('admin.stok-alat.adjust');
});

// Routes untuk User
Route::middleware(['auth', 'user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/home', [UserController::class, 'home'])->name('user.home');
    Route::get('/fasilitas', [UserController::class, 'fasilitas'])->name('user.fasilitas');
    Route::get('/informasi', [UserController::class, 'informasi'])->name('user.informasi');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/booking', [UserController::class, 'booking'])->name('user.booking');
    
    // Routes untuk booking user
    Route::get('/booking/create', [BookingController::class, 'create'])->name('user.booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('user.booking.store');
    Route::get('/booking/history', [BookingController::class, 'history'])->name('user.booking.history');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('user.booking.show');
    
    // Routes untuk payment
    Route::get('/booking/{booking}/payment', [BookingController::class, 'showPayment'])->name('user.booking.payment');
    Route::post('/booking/{booking}/select-payment-method', [BookingController::class, 'selectPaymentMethod'])->name('user.booking.select-payment-method');
    Route::post('/booking/{booking}/upload-payment', [BookingController::class, 'uploadPayment'])->name('user.booking.upload-payment');
    
    // Routes untuk booking kelas user
    Route::get('/booking-kelas/create', [BookingKelasController::class, 'create'])->name('user.booking.kelas.create');
    Route::post('/booking-kelas', [BookingKelasController::class, 'store'])->name('user.booking.kelas.store');
    Route::get('/booking-kelas/history', [BookingKelasController::class, 'history'])->name('user.booking.kelas.history');
    Route::get('/booking-kelas/{bookingKelas}', [BookingKelasController::class, 'show'])->name('user.booking.kelas.show');
    Route::get('/booking-kelas/{bookingKelas}/payment', [BookingKelasController::class, 'showPayment'])->name('user.booking.kelas.payment');
    Route::post('/booking-kelas/{bookingKelas}/select-payment-method', [BookingKelasController::class, 'selectPaymentMethod'])->name('user.booking.kelas.select-payment-method');
    Route::post('/booking-kelas/{bookingKelas}/upload-payment', [BookingKelasController::class, 'uploadPayment'])->name('user.booking.kelas.upload-payment');
    Route::delete('/booking-kelas/{bookingKelas}/cancel', [BookingKelasController::class, 'cancel'])->name('user.booking.kelas.cancel');
    
    // Routes untuk booking sewa alat user
    Route::get('/booking-sewa-alat/create', [BookingSewaAlatController::class, 'create'])->name('user.booking.sewa-alat.create');
    Route::post('/booking-sewa-alat', [BookingSewaAlatController::class, 'store'])->name('user.booking.sewa-alat.store');
    Route::get('/booking-sewa-alat/history', [BookingSewaAlatController::class, 'history'])->name('user.booking.sewa-alat.history');
    Route::get('/booking-sewa-alat/{bookingSewaAlat}', [BookingSewaAlatController::class, 'show'])->name('user.booking.sewa-alat.show');
    Route::get('/booking-sewa-alat/{bookingSewaAlat}/payment', [BookingSewaAlatController::class, 'showPayment'])->name('user.booking.sewa-alat.payment');
    Route::post('/booking-sewa-alat/{bookingSewaAlat}/select-payment-method', [BookingSewaAlatController::class, 'selectPaymentMethod'])->name('user.booking.sewa-alat.select-payment-method');
    Route::post('/booking-sewa-alat/{bookingSewaAlat}/upload-payment', [BookingSewaAlatController::class, 'uploadPayment'])->name('user.booking.sewa-alat.upload-payment');
    Route::delete('/booking-sewa-alat/{bookingSewaAlat}/cancel', [BookingSewaAlatController::class, 'cancel'])->name('user.booking.sewa-alat.cancel');
    
    // Routes untuk PDF export
    Route::get('/pdf/booking-kolam-detail/{booking}', [PdfController::class, 'bookingKolamDetail'])->name('user.pdf.booking-kolam-detail');
    Route::get('/pdf/booking-kelas-detail/{bookingKelas}', [PdfController::class, 'bookingKelasDetail'])->name('user.pdf.booking-kelas-detail');
    Route::get('/pdf/booking-sewa-alat-detail/{bookingSewaAlat}', [PdfController::class, 'bookingSewaAlatDetail'])->name('user.pdf.booking-sewa-alat-detail');
});

// Routes untuk Admin PDF (bisa diakses admin tanpa prefix user)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/pdf/all-bookings', [PdfController::class, 'allBookings'])->name('admin.pdf.all-bookings');
    Route::get('/pdf/booking-kolam', [PdfController::class, 'bookingKolam'])->name('admin.pdf.booking-kolam');
    Route::get('/pdf/booking-kelas', [PdfController::class, 'bookingKelas'])->name('admin.pdf.booking-kelas');
    Route::get('/pdf/booking-sewa-alat', [PdfController::class, 'bookingSewaAlat'])->name('admin.pdf.booking-sewa-alat');
});