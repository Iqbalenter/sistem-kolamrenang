<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Booking;
use App\Models\BookingKelas;
use App\Models\BookingSewaAlat;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View composer untuk sidebar admin
        View::composer('admin.layouts.app', function ($view) {
            $pendingBookings = Booking::where('status', 'pending')->count();
            $pendingBookingKelas = BookingKelas::where('status', 'pending')->count();
            $pendingBookingSewaAlat = BookingSewaAlat::where('status', 'pending')->count();
            
            $view->with([
                'pendingBookings' => $pendingBookings,
                'pendingBookingKelas' => $pendingBookingKelas,
                'pendingBookingSewaAlat' => $pendingBookingSewaAlat
            ]);
        });
    }
}
