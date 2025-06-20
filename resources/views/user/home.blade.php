<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sistem Kolam Renang</title>
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

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg mb-8 text-white">
            <div class="px-6 py-12 md:px-12">
                <div class="max-w-4xl">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        Selamat Datang di Kolam Renang Kami! 🏊‍♂️
                    </h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-6">
                        Nikmati pengalaman berenang terbaik dengan fasilitas modern dan pelayanan berkualitas
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('user.booking') }}" 
                           class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-200 text-center">
                            📅 Booking Sekarang
                        </a>
                        <a href="{{ route('user.fasilitas') }}" 
                           class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-200 text-center">
                            🏢 Lihat Fasilitas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl text-blue-500 mb-2">🏊‍♂️</div>
                <h3 class="text-xl font-bold text-gray-900">2 Kolam</h3>
                <p class="text-gray-600">Utama & Anak</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl text-green-500 mb-2">⏰</div>
                <h3 class="text-xl font-bold text-gray-900">16 Jam</h3>
                <p class="text-gray-600">Operasional</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl text-purple-500 mb-2">👥</div>
                <h3 class="text-xl font-bold text-gray-900">50+</h3>
                <p class="text-gray-600">Kapasitas</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl text-yellow-500 mb-2">⭐</div>
                <h3 class="text-xl font-bold text-gray-900">Premium</h3>
                <p class="text-gray-600">Fasilitas</p>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Jam Operasional -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    🕒 Jam Operasional
                </h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Senin - Jumat</span>
                        <span class="font-semibold">06:00 - 22:00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sabtu - Minggu</span>
                        <span class="font-semibold">06:00 - 23:00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Hari Libur</span>
                        <span class="font-semibold">07:00 - 22:00</span>
                    </div>
                </div>
            </div>

            <!-- Harga Tiket -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    💰 Harga Tiket
                </h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kolam Utama</span>
                        <span class="font-semibold text-blue-600">Rp 25.000/jam</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kolam Anak</span>
                        <span class="font-semibold text-blue-600">Rp 15.000/jam</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Paket Keluarga</span>
                        <span class="font-semibold text-blue-600">Rp 60.000/hari</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Highlight -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">
                Mengapa Memilih Kolam Renang Kami? 🌟
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl mb-4">🏊‍♀️</div>
                    <h3 class="text-lg font-semibold mb-2">Fasilitas Modern</h3>
                    <p class="text-gray-600">Kolam dengan sistem filtrasi terbaru dan air yang selalu bersih</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl mb-4">👨‍🏫</div>
                    <h3 class="text-lg font-semibold mb-2">Instruktur Berpengalaman</h3>
                    <p class="text-gray-600">Tim instruktur profesional siap membantu Anda belajar berenang</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl mb-4">🛡️</div>
                    <h3 class="text-lg font-semibold mb-2">Keamanan Terjamin</h3>
                    <p class="text-gray-600">Penjaga pantai bersertifikat dan peralatan keselamatan lengkap</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
            <h3 class="text-xl font-bold text-blue-900 mb-2">Siap untuk Berenang? 🚀</h3>
            <p class="text-blue-800 mb-4">
                Jangan tunda lagi! Segera booking kolam renang dan nikmati pengalaman berenang yang tak terlupakan.
            </p>
            <a href="{{ route('user.booking') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition duration-200 inline-block">
                Booking Sekarang 🏊‍♂️
            </a>
        </div>
    </div>
</body>
</html> 