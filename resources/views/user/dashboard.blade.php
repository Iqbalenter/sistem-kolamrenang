<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Sistem Kolam Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    @include('components.user-navbar')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, {{ $user->name }}!</h2>
                <p class="text-gray-600">Nikmati fasilitas kolam renang kami dengan mudah</p>
            </div>
        </div>

        <!-- User Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- User Info -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Member sejak</p>
                            <p class="text-lg font-bold text-gray-900">{{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Status -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">B</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Booking Aktif</p>
                            <p class="text-lg font-bold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membership -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">M</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="text-lg font-bold text-gray-900">Regular</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            <!-- Booking Kolam -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">🏊</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Booking Kolam</h3>
                    </div>
                    
                    <a href="{{ route('user.booking') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                        Booking Sekarang
                    </a>
                </div>
            </div>

            <!-- Profile -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">👤</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Profile Saya</h3>
                    </div>
                    
                    <a href="{{ route('user.profile') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                        Lihat Profile
                    </a>
                </div>
            </div>

            <!-- History Booking -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">📋</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Riwayat Booking</h3>
                    </div>
                    <a href="{{ route('user.booking.history') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                        Lihat Riwayat
                    </a>
                </div>
            </div>

            <!-- Informasi & Aturan -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">📋</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Informasi & Aturan</h3>
                    </div>
                    <a href="{{ route('user.informasi') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                        Lihat Informasi
                    </a>
                </div>
            </div>

            <!-- Fasilitas -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-teal-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl">🏢</span>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Fasilitas</h3>
                    </div>
                    <a href="{{ route('user.fasilitas') }}" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded inline-block w-full text-center">
                        Lihat Fasilitas
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 