@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview sistem kolam renang')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Total Booking Kolam -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-swimming-pool text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-blue-100">Booking Kolam</h3>
                <p class="text-2xl font-bold">{{ $totalBookings ?? 0 }}</p>
                @if(isset($pendingBookings) && $pendingBookings > 0)
                    <p class="text-sm text-blue-100">{{ $pendingBookings }} menunggu</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Total Booking Kelas -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-chalkboard-teacher text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-purple-100">Booking Kelas</h3>
                <p class="text-2xl font-bold">{{ $totalBookingKelas ?? 0 }}</p>
                @if(isset($pendingBookingKelas) && $pendingBookingKelas > 0)
                    <p class="text-sm text-purple-100">{{ $pendingBookingKelas }} menunggu</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Total Booking Sewa Alat -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-tools text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-purple-100">Sewa Alat</h3>
                <p class="text-2xl font-bold">{{ $totalBookingSewaAlat ?? 0 }}</p>
                @if(isset($pendingBookingSewaAlat) && $pendingBookingSewaAlat > 0)
                    <p class="text-sm text-purple-100">{{ $pendingBookingSewaAlat }} menunggu</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-coins text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-green-100">Total Pendapatan</h3>
                <p class="text-2xl font-bold">Rp {{ number_format(($totalRevenue ?? 0) + ($revenueBookingKelas ?? 0) + ($revenueBookingSewaAlat ?? 0), 0, ',', '.') }}</p>
                <p class="text-sm text-green-100">Semua layanan</p>
            </div>
        </div>
    </div>
</div>

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

<!-- Booking Kelas & Sewa Alat Section -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 mt-6 sm:mt-8">
    <!-- Recent Booking Kelas -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                    <i class="fas fa-swimming-pool mr-2 text-blue-500"></i>
                    Booking Kelas Terbaru
                </h3>
                <a href="{{ route('admin.booking-kelas.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium text-right sm:text-left">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if(isset($recentBookingKelas) && $recentBookingKelas->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesan</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentBookingKelas as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-none">{{ $booking->nama_pemesan ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500 truncate max-w-[120px] sm:max-w-none">{{ $booking->user->email ?? 'N/A' }}</div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">{{ $booking->jenis_kelas_label ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $booking->jumlah_peserta ?? 0 }} peserta</div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'approved') bg-green-100 text-green-800
                                        @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $booking->status_label ?? 'N/A' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-4 sm:px-6 py-6 sm:py-8 text-center">
                    <i class="fas fa-swimming-pool text-3xl sm:text-4xl text-gray-300 mb-2 sm:mb-3"></i>
                    <p class="text-sm sm:text-base text-gray-500">Belum ada booking kelas</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Booking Sewa Alat -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                    <i class="fas fa-tools mr-2 text-purple-500"></i>
                    Booking Sewa Alat Terbaru
                </h3>
                <a href="{{ route('admin.booking-sewa-alat.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium text-right sm:text-left">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if(isset($recentBookingSewaAlat) && $recentBookingSewaAlat->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentBookingSewaAlat as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-none">{{ $booking->nama_penyewa ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500 truncate max-w-[120px] sm:max-w-none">{{ $booking->user->email ?? 'N/A' }}</div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">{{ $booking->jenis_alat_label ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $booking->jumlah_alat ?? 0 }} unit</div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'approved') bg-green-100 text-green-800
                                        @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $booking->status_label ?? 'N/A' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-4 sm:px-6 py-6 sm:py-8 text-center">
                    <i class="fas fa-tools text-3xl sm:text-4xl text-gray-300 mb-2 sm:mb-3"></i>
                    <p class="text-sm sm:text-base text-gray-500">Belum ada booking sewa alat</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Upcoming Bookings Section -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 mt-6 sm:mt-8">
    <!-- Upcoming Booking Kelas -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                    <i class="fas fa-calendar-plus mr-2 text-green-500"></i>
                    Kelas Mendatang
                </h3>
                <a href="{{ route('admin.booking-kelas.index') }}?status=approved" class="text-green-600 hover:text-green-800 text-sm font-medium text-right sm:text-left">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if(isset($upcomingBookingKelas) && $upcomingBookingKelas->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesan</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($upcomingBookingKelas as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-none">{{ $booking->nama_pemesan ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $booking->jumlah_peserta ?? 0 }} peserta</div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">
                                        {{ $booking->tanggal_kelas ? $booking->tanggal_kelas->format('d/m/Y') : 'N/A' }}
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
                                    <div class="text-xs sm:text-sm text-gray-900">{{ $booking->jenis_kelas_label ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-4 sm:px-6 py-6 sm:py-8 text-center">
                    <i class="fas fa-calendar-check text-3xl sm:text-4xl text-gray-300 mb-2 sm:mb-3"></i>
                    <p class="text-sm sm:text-base text-gray-500">Tidak ada kelas mendatang</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upcoming Booking Sewa Alat -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                    <i class="fas fa-calendar-plus mr-2 text-orange-500"></i>
                    Sewa Alat Mendatang
                </h3>
                <a href="{{ route('admin.booking-sewa-alat.index') }}?status=approved" class="text-orange-600 hover:text-orange-800 text-sm font-medium text-right sm:text-left">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if(isset($upcomingBookingSewaAlat) && $upcomingBookingSewaAlat->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($upcomingBookingSewaAlat as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-none">{{ $booking->nama_penyewa ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $booking->jumlah_alat ?? 0 }} unit</div>
                                </td>
                                <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">
                                        {{ $booking->tanggal_sewa ? $booking->tanggal_sewa->format('d/m/Y') : 'N/A' }}
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
                                    <div class="text-xs sm:text-sm text-gray-900">{{ $booking->jenis_alat_label ?? 'N/A' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-4 sm:px-6 py-6 sm:py-8 text-center">
                    <i class="fas fa-calendar-check text-3xl sm:text-4xl text-gray-300 mb-2 sm:mb-3"></i>
                    <p class="text-sm sm:text-base text-gray-500">Tidak ada sewa alat mendatang</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6 sm:mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
    <!-- Kelola Bookings Kolam -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-start sm:items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-calendar-check text-2xl sm:text-3xl"></i>
            </div>
            <div class="ml-3 sm:ml-4 flex-1">
                <h3 class="text-base sm:text-lg font-semibold">Kelola Booking Kolam</h3>
                <p class="text-blue-100 text-xs sm:text-sm mt-1">Approve/reject booking kolam dan konfirmasi pembayaran</p>
                <a href="{{ route('admin.bookings.index') }}" class="inline-block mt-2 sm:mt-3 bg-white text-blue-600 px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-50 transition-colors">
                    Kelola Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Kelola Booking Kelas -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-start sm:items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-swimming-pool text-2xl sm:text-3xl"></i>
            </div>
            <div class="ml-3 sm:ml-4 flex-1">
                <h3 class="text-base sm:text-lg font-semibold">Kelola Booking Kelas</h3>
                <p class="text-purple-100 text-xs sm:text-sm mt-1">Manage booking kelas renang dan instruktur</p>
                <a href="{{ route('admin.booking-kelas.index') }}" class="inline-block mt-2 sm:mt-3 bg-white text-purple-600 px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-purple-50 transition-colors">
                    Kelola Kelas
                </a>
            </div>
        </div>
    </div>

    <!-- Kelola Sewa Alat -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-start sm:items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-tools text-2xl sm:text-3xl"></i>
            </div>
            <div class="ml-3 sm:ml-4 flex-1">
                <h3 class="text-base sm:text-lg font-semibold">Kelola Sewa Alat</h3>
                <p class="text-purple-100 text-xs sm:text-sm mt-1">Manage sewa alat renang dan inventori</p>
                <a href="{{ route('admin.booking-sewa-alat.index') }}" class="inline-block mt-2 sm:mt-3 bg-white text-purple-600 px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-purple-50 transition-colors">
                    Kelola Sewa Alat
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
</div>
@endsection 