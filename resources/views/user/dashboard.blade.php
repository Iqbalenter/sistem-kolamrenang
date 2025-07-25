<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Sistem Kolam Renang</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .pool-background {
            background-image: url('{{ asset('kolam.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .glass-card h2,
        .glass-card h3,
        .glass-card p {
            color: white !important;
        }
    </style>
</head>
<body class="pool-background">

    @include('components.user-navbar')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 glass-card border border-green-400 text-white rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 glass-card border border-red-400 text-white rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Notifikasi Pembayaran Ditolak -->
        @if($rejectedPaymentKelas->count() > 0 || $rejectedPaymentSewaAlat->count() > 0)
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Perhatian: Ada Pembayaran yang Ditolak</h3>
                        <div class="mt-1 text-sm text-red-700">
                            <p>Anda memiliki {{ $rejectedPaymentKelas->count() + $rejectedPaymentSewaAlat->count() }} pembayaran yang ditolak dan perlu diupload ulang:</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach($rejectedPaymentKelas as $booking)
                                    <li>
                                        <a href="{{ route('user.booking.kelas.show', $booking) }}" class="text-red-800 hover:text-red-900 underline">
                                            Booking Kelas #{{ $booking->id }} - {{ $booking->jenis_kelas_label }}
                                        </a>
                                    </li>
                                @endforeach
                                @foreach($rejectedPaymentSewaAlat as $booking)
                                    <li>
                                        <a href="{{ route('user.booking.sewa-alat.show', $booking) }}" class="text-red-800 hover:text-red-900 underline">
                                            Booking Sewa Alat #{{ $booking->id }} - {{ $booking->jenis_alat_label }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="glass-card overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-2xl font-bold text-white mb-2">Selamat Datang, {{ $user->name }}!</h2>
                <p class="text-white">Nikmati fasilitas kolam renang kami dengan mudah</p>
            </div>
        </div>

        <!-- User Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Member Sejak -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Member sejak</p>
                            <p class="text-lg font-bold text-white">{{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Booking -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-cyan-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">B</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Total Booking</p>
                            <p class="text-lg font-bold text-white">{{ $totalBookings ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">S</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Status</p>
                            <p class="text-lg font-bold text-white">Regular</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Booking Kolam -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-swimming-pool text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Booking Kolam</p>
                            <p class="text-lg font-bold text-white">{{ $totalBookingKolam ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Kelas -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Booking Kelas</p>
                            <p class="text-lg font-bold text-white">{{ $totalBookingKelas ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Sewa Alat -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-tools text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Sewa Alat</p>
                            <p class="text-lg font-bold text-white">{{ $totalBookingSewaAlat ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        @if(isset($recentBookings) && $recentBookings->count() > 0)
        <div class="mb-6">
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="px-6 py-4 border-b border-white border-opacity-20">
                    <h3 class="text-lg font-semibold text-white">
                        <i class="fas fa-history mr-2"></i>
                        Booking Terbaru
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($recentBookings as $booking)
                        <div class="flex items-center justify-between p-4 bg-white bg-opacity-10 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($booking->booking_type === 'kolam')
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-swimming-pool text-white text-xs"></i>
                                        </div>
                                    @elseif($booking->booking_type === 'kelas')
                                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-chalkboard-teacher text-white text-xs"></i>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-tools text-white text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-white">
                                        @if($booking->booking_type === 'kolam')
                                            Booking Kolam #{{ $booking->id }}
                                        @elseif($booking->booking_type === 'kelas')
                                            Booking Kelas #{{ $booking->id }}
                                        @else
                                            Sewa Alat #{{ $booking->id }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-white text-opacity-70">
                                        {{ $booking->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'approved') bg-green-100 text-green-800
                                    @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $booking->status_label ?? ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Menu Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Booking Kolam -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">🏊</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Booking Kolam</h3>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('user.booking') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                            Booking Sekarang
                        </a>
                        <a href="{{ route('user.booking.history') }}" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-1 rounded inline-block w-full text-center text-sm">
                            Riwayat Kolam
                        </a>
                    </div>
                </div>
            </div>

            <!-- Booking Kelas -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">🏊‍♂️</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Booking Kelas</h3>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('user.booking.kelas.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                            Booking Kelas
                        </a>
                        <a href="{{ route('user.booking.kelas.history') }}" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-1 rounded inline-block w-full text-center text-sm">
                            Riwayat Kelas
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sewa Alat -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">🏊‍♀️</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Sewa Alat</h3>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('user.booking.sewa-alat.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                            Sewa Alat
                        </a>
                        <a href="{{ route('user.booking.sewa-alat.history') }}" class="bg-green-400 hover:bg-green-500 text-white px-4 py-1 rounded inline-block w-full text-center text-sm">
                            Riwayat Sewa Alat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">👤</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Profile Saya</h3>
                    </div>
                    <a href="{{ route('user.profile') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                        Lihat Profile
                    </a>
                </div>
            </div>

            <!-- Fasilitas -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">🏢</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Fasilitas</h3>
                    </div>
                    <a href="{{ route('user.fasilitas') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                        Lihat Fasilitas
                    </a>
                </div>
            </div>

            <!-- Informasi -->
            <div class="glass-card overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">ℹ️</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Informasi</h3>
                    </div>
                    <a href="{{ route('user.informasi') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                        Lihat Informasi
                    </a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
