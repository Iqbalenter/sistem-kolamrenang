<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;

// Routes untuk Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
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
});