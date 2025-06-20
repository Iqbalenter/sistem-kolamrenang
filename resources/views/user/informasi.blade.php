<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi & Aturan - Kolam Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')

    <div class="min-h-screen py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-gray-900">📋 Informasi & Aturan Kolam Renang</h1>
                    <a href="{{ route('user.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Dashboard
                    </a>
                </div>
                <p class="text-gray-600 mt-2">Harap baca dan patuhi seluruh aturan untuk keselamatan dan kenyamanan bersama</p>
            </div>

            <!-- Jam Operasional -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-md p-6 mb-6 text-white">
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-4">🕐 JAM OPERASIONAL</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white bg-opacity-20 rounded-lg p-4">
                            <h3 class="font-semibold text-lg">Senin - Jumat</h3>
                            <p class="text-xl">06:00 - 21:00</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-4">
                            <h3 class="font-semibold text-lg">Sabtu - Minggu</h3>
                            <p class="text-xl">05:00 - 22:00</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-4">
                            <h3 class="font-semibold text-lg">Hari Libur</h3>
                            <p class="text-xl">05:00 - 22:00</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Larangan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-red-600 mb-6 flex items-center">
                        🚫 DILARANG / LARANGAN
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <span class="text-2xl">🚭</span>
                            <div>
                                <h3 class="font-semibold text-red-800">Merokok</h3>
                                <p class="text-red-700 text-sm">Dilarang merokok di area kolam renang dan sekitarnya</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <span class="text-2xl">🍺</span>
                            <div>
                                <h3 class="font-semibold text-red-800">Minuman Beralkohol</h3>
                                <p class="text-red-700 text-sm">Dilarang membawa dan mengonsumsi minuman beralkohol</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <span class="text-2xl">🏃‍♂️</span>
                            <div>
                                <h3 class="font-semibold text-red-800">Berlari di Area Kolam</h3>
                                <p class="text-red-700 text-sm">Dilarang berlari di area sekitar kolam karena licin</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <span class="text-2xl">🦶</span>
                            <div>
                                <h3 class="font-semibold text-red-800">Sepatu di Area Kolam</h3>
                                <p class="text-red-700 text-sm">Dilarang menggunakan sepatu di area kolam</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <span class="text-2xl">🍖</span>
                            <div>
                                <h3 class="font-semibold text-red-800">Makanan di Kolam</h3>
                                <p class="text-red-700 text-sm">Dilarang membawa makanan ke area kolam</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <span class="text-2xl">📱</span>
                            <div>
                                <h3 class="font-semibold text-red-800">Menggunakan HP Saat Berenang</h3>
                                <p class="text-red-700 text-sm">Dilarang menggunakan handphone saat di dalam kolam</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <span class="text-2xl">💥</span>
                            <div>
                                <h3 class="font-semibold text-red-800">Terjun dari Tepi Kolam</h3>
                                <p class="text-red-700 text-sm">Dilarang terjun/melompat dari tepi kolam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peringatan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-yellow-600 mb-6 flex items-center">
                        ⚠️ PERINGATAN
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <span class="text-2xl">👶</span>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Anak-anak</h3>
                                <p class="text-yellow-700 text-sm">Anak di bawah 12 tahun harus didampingi orang dewasa</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <span class="text-2xl">🚿</span>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Mandi Sebelum Berenang</h3>
                                <p class="text-yellow-700 text-sm">Wajib mandi dengan sabun sebelum masuk kolam</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <span class="text-2xl">🏊‍♀️</span>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Kemampuan Berenang</h3>
                                <p class="text-yellow-700 text-sm">Pastikan dapat berenang atau gunakan pelampung</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <span class="text-2xl">🩱</span>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Pakaian Renang</h3>
                                <p class="text-yellow-700 text-sm">Wajib menggunakan pakaian renang yang sesuai</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <span class="text-2xl">🩴</span>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Alas Kaki Anti-Slip</h3>
                                <p class="text-yellow-700 text-sm">Gunakan sandal anti-slip di area sekitar kolam</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <span class="text-2xl">🧴</span>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Sunscreen</h3>
                                <p class="text-yellow-700 text-sm">Gunakan sunscreen untuk kolam outdoor</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <span class="text-2xl">💊</span>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Kondisi Kesehatan</h3>
                                <p class="text-yellow-700 text-sm">Jangan berenang jika dalam kondisi sakit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Penting -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-2xl font-bold text-blue-600 mb-6 flex items-center">
                    ℹ️ INFORMASI PENTING
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="text-2xl">🏥</span>
                            <div>
                                <h3 class="font-semibold text-blue-800">Pertolongan Pertama</h3>
                                <p class="text-blue-700 text-sm">Tersedia kotak P3K dan petugas medis siaga</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="text-2xl">👮‍♂️</span>
                            <div>
                                <h3 class="font-semibold text-blue-800">Petugas Keamanan</h3>
                                <p class="text-blue-700 text-sm">Petugas keamanan 24 jam menjaga area kolam</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="text-2xl">🚿</span>
                            <div>
                                <h3 class="font-semibold text-blue-800">Fasilitas Mandi</h3>
                                <p class="text-blue-700 text-sm">Tersedia kamar mandi dan bilas dengan air hangat</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="text-2xl">🏪</span>
                            <div>
                                <h3 class="font-semibold text-blue-800">Toko</h3>
                                <p class="text-blue-700 text-sm">Tersedia toko perlengkapan renang dan minuman</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="text-2xl">🅿️</span>
                            <div>
                                <h3 class="font-semibold text-blue-800">Parkir</h3>
                                <p class="text-blue-700 text-sm">Area parkir gratis untuk pengunjung</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="text-2xl">🛗</span>
                            <div>
                                <h3 class="font-semibold text-blue-800">Loker</h3>
                                <p class="text-blue-700 text-sm">Tersedia loker dengan biaya sewa Rp 5.000</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="text-2xl">📞</span>
                            <div>
                                <h3 class="font-semibold text-blue-800">Kontak Darurat</h3>
                                <p class="text-blue-700 text-sm">Hubungi: +62 813-7676-7690</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="text-2xl">📋</span>
                            <div>
                                <h3 class="font-semibold text-blue-800">Booking</h3>
                                <p class="text-blue-700 text-sm">Lakukan reservasi minimal H-1 untuk jaminan slot</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tata Tertib -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-2xl font-bold text-green-600 mb-6 flex items-center">
                    📝 TATA TERTIB UMUM
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-lg text-green-800 mb-3">✅ Yang Harus Dilakukan:</h3>
                        <ul class="space-y-2 text-green-700">
                            <li class="flex items-center space-x-2">
                                <span class="text-green-500">✓</span>
                                <span>Daftar/check-in terlebih dahulu di resepsionis</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-green-500">✓</span>
                                <span>Simpan barang berharga di loker</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-green-500">✓</span>
                                <span>Ikuti instruksi petugas kolam renang</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-green-500">✓</span>
                                <span>Jaga kebersihan area kolam</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-green-500">✓</span>
                                <span>Laporkan kecelakaan/insiden segera</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-green-500">✓</span>
                                <span>Hormati pengunjung lain</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-lg text-red-800 mb-3">❌ Yang Tidak Boleh:</h3>
                        <ul class="space-y-2 text-red-700">
                            <li class="flex items-center space-x-2">
                                <span class="text-red-500">✗</span>
                                <span>Mengganggu ketenangan pengunjung lain</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-red-500">✗</span>
                                <span>Membuang sampah sembarangan</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-red-500">✗</span>
                                <span>Menggunakan kamera/video tanpa izin</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-red-500">✗</span>
                                <span>Membawa hewan peliharaan</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-red-500">✗</span>
                                <span>Berisik atau berteriak keras</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-red-500">✗</span>
                                <span>Mencuri atau merusak fasilitas</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sanksi -->
            <div class="bg-red-600 rounded-lg shadow-md p-6 mt-6 text-white">
                <h2 class="text-2xl font-bold mb-4 flex items-center">
                    ⚖️ SANKSI PELANGGARAN
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <h3 class="font-semibold text-lg">Pelanggaran Ringan</h3>
                        <p class="text-sm mt-2">Teguran lisan dan peringatan tertulis</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <h3 class="font-semibold text-lg">Pelanggaran Sedang</h3>
                        <p class="text-sm mt-2">Diminta keluar dari area kolam hari itu</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <h3 class="font-semibold text-lg">Pelanggaran Berat</h3>
                        <p class="text-sm mt-2">Dilarang masuk permanen + ganti rugi</p>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">📞 KONTAK KAMI</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <span class="text-3xl">📞</span>
                        <h3 class="font-semibold text-lg mt-2">Telepon</h3>
                        <p class="text-gray-600">+62 813-7676-7690</p>
                    </div>
                    <div>
                        <span class="text-3xl">📍</span>
                        <h3 class="font-semibold text-lg mt-2">Alamat</h3>
                        <p class="text-gray-600">FQX7+WFV, Jl. Limau Manis 20362 Tg Morawa A Sumatera Utara</p>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-8">
                <a href="{{ route('user.dashboard') }}" 
                    class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        // Smooth scroll for better user experience
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html> 