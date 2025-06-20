@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview sistem kolam renang')

@section('content')
<!-- Tables Section -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
    <!-- Recent Bookings Table -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                    <i class="fas fa-history mr-2 text-blue-500"></i>
                    Pemesanan Terbaru
                </h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium text-right sm:text-left">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if(isset($recentBookings) && $recentBookings->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesan</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentBookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-none">{{ $booking->nama_pemesan ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500 truncate max-w-[120px] sm:max-w-none">{{ $booking->user->email ?? 'N/A' }}</div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">
                                        {{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d/m/Y') : 'N/A' }}
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-500">
                                        @if($booking->jam_mulai && $booking->jam_selesai)
                                            {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap text-xs sm:text-sm text-gray-900 font-medium">
                                    Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-4 sm:px-6 py-6 sm:py-8 text-center">
                    <i class="fas fa-calendar-times text-3xl sm:text-4xl text-gray-300 mb-2 sm:mb-3"></i>
                    <p class="text-sm sm:text-base text-gray-500">Belum ada pemesanan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upcoming Bookings Table -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                    <i class="fas fa-calendar-plus mr-2 text-green-500"></i>
                    Booking Mendatang
                </h3>
                <a href="{{ route('admin.bookings.index') }}?status=approved" class="text-green-600 hover:text-green-800 text-sm font-medium text-right sm:text-left">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if(isset($upcomingBookings) && $upcomingBookings->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesan</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kolam</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($upcomingBookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-none">{{ $booking->nama_pemesan ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $booking->jumlah_orang ?? 0 }} orang</div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">
                                        {{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d/m/Y') : 'N/A' }}
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-500">
                                        @if($booking->jam_mulai && $booking->jam_selesai)
                                            {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    @if($booking->jenis_kolam == 'dewasa')
                                        <div class="text-xs sm:text-sm text-gray-900 font-medium">Kolam Dewasa</div>
                                    @elseif($booking->jenis_kolam == 'anak')
                                        <div class="text-xs sm:text-sm text-gray-900 font-medium">Kolam Anak</div>
                                    @elseif($booking->jenis_kolam == 'vip')
                                        <div class="text-xs sm:text-sm text-gray-900 font-medium">Kolam VIP</div>
                                    @else
                                        <div class="text-xs sm:text-sm text-gray-900 font-medium">{{ $booking->jenis_kolam ?? 'N/A' }}</div>
                                    @endif
                                    <div class="text-xs sm:text-sm text-gray-500">Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-4 sm:px-6 py-6 sm:py-8 text-center">
                    <i class="fas fa-calendar-check text-3xl sm:text-4xl text-gray-300 mb-2 sm:mb-3"></i>
                    <p class="text-sm sm:text-base text-gray-500">Tidak ada booking mendatang</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6 sm:mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
    <!-- Kelola Bookings -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-start sm:items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-calendar-check text-2xl sm:text-3xl"></i>
            </div>
            <div class="ml-3 sm:ml-4 flex-1">
                <h3 class="text-base sm:text-lg font-semibold">Kelola Bookings</h3>
                <p class="text-blue-100 text-xs sm:text-sm mt-1">Approve/reject booking dan konfirmasi pembayaran</p>
                <a href="{{ route('admin.bookings.index') }}" class="inline-block mt-2 sm:mt-3 bg-white text-blue-600 px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-50 transition-colors">
                    Kelola Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Kelola Users -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-start sm:items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-users text-2xl sm:text-3xl"></i>
            </div>
            <div class="ml-3 sm:ml-4 flex-1">
                <h3 class="text-base sm:text-lg font-semibold">Kelola Users</h3>
                <p class="text-green-100 text-xs sm:text-sm mt-1">Manage semua user yang terdaftar</p>
                <a href="{{ route('admin.users') }}" class="inline-block mt-2 sm:mt-3 bg-white text-green-600 px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-green-50 transition-colors">
                    Kelola User
                </a>
            </div>
        </div>
    </div>

    <!-- Add third empty div for spacing on larger screens when there are only 2 items -->
    <div class="hidden xl:block"></div>
</div>
@endsection 