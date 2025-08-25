<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas - Sistem Kolam Renang</title>
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

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-gray-900">🏢 Fasilitas Kolam Renang</h1>
                    <a href="{{ route('user.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Dashboard
                    </a>
                </div>
            <p class="text-gray-600 mt-2">Nikmati berbagai fasilitas modern dan lengkap yang kami sediakan untuk kenyamanan berenang Anda</p>
        </div>

        <!-- Kolam Anak -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-4xl mr-4">🧒</div>
                        <h3 class="text-2xl font-bold">Kolam Anak</h3>
                    </div>
                    <p class="text-green-100">Kolam khusus anak dengan keamanan ekstra</p>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-3">📏</span>
                            <span><strong>Ukuran:</strong> 10m x 8m</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-3">🌊</span>
                            <span><strong>Kedalaman:</strong> 0.5m - 1.0m</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-3">💰</span>
                            <span><strong>Tarif:</strong> Rp 35.000/hari</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-4xl mr-4">🏊‍♂️</div>
                        <h3 class="text-2xl font-bold">Kolam Utama</h3>
                    </div>
                    <p class="text-blue-100">Kolam renang standar olimpik</p>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-blue-500 mr-3">📏</span>
                            <span><strong>Ukuran:</strong> 25m x 12m</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-blue-500 mr-3">🌊</span>
                            <span><strong>Kedalaman:</strong> 1.5m - 2.5m</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-blue-500 mr-3">💰</span>
                            <span><strong>Tarif:</strong> Rp 50.000/hari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kelas Renang -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">🎓 Kelas Renang</h2>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="text-5xl mb-4">👶</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Kelas Anak</h3>
                        <p class="text-gray-600 mb-4">Usia 4-12 tahun</p>
                        <div class="text-sm text-gray-600">
                            <p>• Dasar-dasar berenang</p>
                            <p>• Teknik mengapung</p>
                            <p>• Keamanan air</p>
                        </div>
                        <div class="mt-4 text-blue-600 font-semibold">Rp 200.000/bulan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl mb-4">🏊‍♀️</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Kelas Dewasa</h3>
                        <p class="text-gray-600 mb-4">Usia 13+ tahun</p>
                        <div class="text-sm text-gray-600">
                            <p>• Teknik renang 4 gaya</p>
                            <p>• Latihan stamina</p>
                            <p>• Perbaikan teknik</p>
                        </div>
                        <div class="mt-4 text-blue-600 font-semibold">Rp 300.000/bulan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl mb-4">🏆</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Kelas Kompetisi</h3>
                        <p class="text-gray-600 mb-4">Atlet & Semi-Pro</p>
                        <div class="text-sm text-gray-600">
                            <p>• Teknik tingkat lanjut</p>
                            <p>• Strategi kompetisi</p>
                            <p>• Mental training</p>
                        </div>
                        <div class="mt-4 text-blue-600 font-semibold">Rp 500.000/bulan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ruang Ganti & Loker -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-4xl mr-4">🚿</div>
                        <h3 class="text-2xl font-bold">Ruang Ganti & Loker</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-purple-500 mr-3">👨‍👩‍👧‍👦</span>
                            <span>Ruang ganti terpisah pria & wanita</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-purple-500 mr-3">🔒</span>
                            <span>Loker dengan kunci digital</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-purple-500 mr-3">🚿</span>
                            <span>Shower air panas & dingin</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-4xl mr-4">🍽️</div>
                        <h3 class="text-2xl font-bold">Kafe & Restoran</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-orange-500 mr-3">☕</span>
                            <span>Minuman segar & kopi</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-orange-500 mr-3">🥗</span>
                            <span>Menu makanan sehat</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-orange-500 mr-3">❄️</span>
                            <span>AC & WiFi gratis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fasilitas Tambahan -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">✨ Fasilitas Tambahan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="text-4xl mb-4">🚗</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Parkir Luas</h3>
                    <p class="text-gray-600">Area parkir gratis untuk 50+ kendaraan</p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="text-4xl mb-4">🛡️</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Keamanan 24/7</h3>
                    <p class="text-gray-600">Security & CCTV untuk keamanan</p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="text-4xl mb-4">🏊‍♂️</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Penyewaan Alat</h3>
                    <p class="text-gray-600">Sewa peralatan renang lengkap</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg text-white p-8 text-center">
            <h3 class="text-2xl font-bold mb-4">Siap Menikmati Semua Fasilitas? 🚀</h3>
            <p class="text-xl text-blue-100 mb-6">
                Bergabunglah dengan ribuan member yang sudah merasakan pengalaman berenang terbaik
            </p>
            <a href="{{ route('user.booking') }}" 
               class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-200 inline-block">
                📅 Booking Sekarang
            </a>
        </div>
    </div>
</body>
</html> 