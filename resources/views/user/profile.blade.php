<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Sistem Kolam Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    @include('components.user-navbar')

    <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-3 sm:mb-4 p-3 sm:p-4 bg-green-100 border border-green-400 text-green-700 rounded text-sm sm:text-base">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-3 sm:mb-4 p-3 sm:p-4 bg-red-100 border border-red-400 text-red-700 rounded text-sm sm:text-base">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-gray-900">👤 Profile Saya</h1>
                    <a href="{{ route('user.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Dashboard
                    </a>
                </div>
            <p class="text-gray-600 mt-2">Kelola informasi akun dan data pribadi Anda</p>
        </div>

        <!-- Profile Information -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-4 sm:p-6">
                <div class="flex flex-col sm:flex-row items-center sm:items-start mb-4 sm:mb-6">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl sm:text-2xl font-bold mb-4 sm:mb-0 sm:mr-6 flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="text-center sm:text-left min-w-0">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 break-words">{{ Auth::user()->name }}</h3>
                        <p class="text-sm sm:text-base text-gray-600">Member sejak {{ Auth::user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4 sm:pt-6">
                    <dl class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2">
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm sm:text-base text-gray-900 break-words">{{ Auth::user()->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm sm:text-base text-gray-900 break-all">{{ Auth::user()->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500">Role</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500">Status Membership</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ Auth::user()->membership_status_label }} Member
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 sm:mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 text-center">
                <div class="text-3xl sm:text-4xl mb-3 sm:mb-4">📅</div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 sm:mb-2">Booking Kolam</h3>
                <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">Reservasi kolam renang</p>
                <a href="{{ route('user.booking') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 sm:px-4 py-2 rounded inline-block text-sm sm:text-base transition-colors w-full sm:w-auto">
                    Booking Sekarang
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 text-center">
                <div class="text-3xl sm:text-4xl mb-3 sm:mb-4">🏢</div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 sm:mb-2">Lihat Fasilitas</h3>
                <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">Jelajahi fasilitas kami</p>
                <a href="{{ route('user.fasilitas') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 sm:px-4 py-2 rounded inline-block text-sm sm:text-base transition-colors w-full sm:w-auto">
                    Lihat Fasilitas
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 text-center sm:col-span-2 lg:col-span-1">
                <div class="text-3xl sm:text-4xl mb-3 sm:mb-4">🏠</div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 sm:mb-2">Kembali ke Home</h3>
                <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">Halaman utama</p>
                <a href="{{ route('user.dashboard') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-3 sm:px-4 py-2 rounded inline-block text-sm sm:text-base transition-colors w-full sm:w-auto">
                    Ke Home
                </a>
            </div>
        </div>
    </div>
</body>
</html> 