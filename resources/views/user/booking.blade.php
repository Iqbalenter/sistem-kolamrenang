<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Kolam - User</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    @include('components.user-navbar')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Booking Kolam Renang</h2>
                <p class="text-gray-600">Reservasi kolam renang untuk waktu yang Anda inginkan</p>
            </div>
        </div>

        <!-- Coming Soon Notice -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <div class="text-6xl mb-4">🚧</div>
            <h3 class="text-xl font-bold text-yellow-800 mb-2">Fitur Booking Sedang Dikembangkan</h3>
            <p class="text-yellow-700 mb-4">
                Sistem booking kolam renang sedang dalam tahap pengembangan. 
                Saat ini Anda dapat menghubungi admin untuk melakukan reservasi.
            </p>
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h4 class="font-bold text-gray-900 mb-2">Kontak Admin:</h4>
                <p class="text-gray-600">📞 Telepon: 0123-456-789</p>
                <p class="text-gray-600">📧 Email: admin@kolamrenang.com</p>
                <p class="text-gray-600">🕒 Jam Operasional: 06:00 - 22:00</p>
            </div>
        </div>

        <!-- Pool Information -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolam Utama -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">🏊‍♂️ Kolam Utama</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><strong>Ukuran:</strong> 25m x 12m</p>
                        <p><strong>Kedalaman:</strong> 1.5m - 2.5m</p>
                        <p><strong>Kapasitas:</strong> 20 orang</p>
                        <p><strong>Tarif:</strong> Rp 25.000/jam</p>
                    </div>
                </div>
            </div>

            <!-- Kolam Anak -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">🧒 Kolam Anak</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><strong>Ukuran:</strong> 10m x 8m</p>
                        <p><strong>Kedalaman:</strong> 0.5m - 1.0m</p>
                        <p><strong>Kapasitas:</strong> 15 anak</p>
                        <p><strong>Tarif:</strong> Rp 15.000/jam</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rules & Guidelines -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-bold text-blue-900 mb-4">📋 Aturan & Panduan Booking</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                <div>
                    <p class="mb-2"><strong>Ketentuan Booking:</strong></p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Booking minimal 1 jam sebelum kedatangan</li>
                        <li>Durasi minimum 1 jam</li>
                        <li>Pembayaran di tempat</li>
                        <li>Membawa peralatan renang sendiri</li>
                    </ul>
                </div>
                <div>
                    <p class="mb-2"><strong>Fasilitas Tersedia:</strong></p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Kamar ganti pria & wanita</li>
                        <li>Shower air panas</li>
                        <li>Locker penyimpanan</li>
                        <li>Area parkir gratis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 