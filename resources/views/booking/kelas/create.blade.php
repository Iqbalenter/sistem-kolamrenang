<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Kelas Renang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')
    
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Booking Kelas Renang</h1>
                    <a href="{{ route('user.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Info Tarif -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Informasi Tarif Kelas Renang</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-blue-700">Kelas Pemula:</span>
                        <span class="font-semibold text-blue-900">Rp 50.000/orang</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Kelas Menengah:</span>
                        <span class="font-semibold text-blue-900">Rp 75.000/orang</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Kelas Lanjutan:</span>
                        <span class="font-semibold text-blue-900">Rp 100.000/orang</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Kelas Private:</span>
                        <span class="font-semibold text-blue-900">Rp 150.000/orang</span>
                    </div>
                </div>
            </div>

            <!-- Form Booking -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('user.booking.kelas.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Data Pemesan -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pemesan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Pemesan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_pemesan" name="nama_pemesan" 
                                       value="{{ old('nama_pemesan', Auth::user()->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required>
                            </div>
                            <div>
                                <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="nomor_telepon" name="nomor_telepon" 
                                       value="{{ old('nomor_telepon') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Kelas -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Kelas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tanggal_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Kelas <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tanggal_kelas" name="tanggal_kelas" 
                                       value="{{ old('tanggal_kelas') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required>
                            </div>
                            <div>
                                <label for="jenis_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelas <span class="text-red-500">*</span>
                                </label>
                                <select id="jenis_kelas" name="jenis_kelas" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        required onchange="updateHarga()">
                                    <option value="">Pilih Jenis Kelas</option>
                                    <option value="pemula" {{ old('jenis_kelas') == 'pemula' ? 'selected' : '' }}>
                                        Kelas Pemula (Rp 50.000/orang)
                                    </option>
                                    <option value="menengah" {{ old('jenis_kelas') == 'menengah' ? 'selected' : '' }}>
                                        Kelas Menengah (Rp 75.000/orang)
                                    </option>
                                    <option value="lanjutan" {{ old('jenis_kelas') == 'lanjutan' ? 'selected' : '' }}>
                                        Kelas Lanjutan (Rp 100.000/orang)
                                    </option>
                                    <option value="private" {{ old('jenis_kelas') == 'private' ? 'selected' : '' }}>
                                        Kelas Private (Rp 150.000/orang)
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="jam_mulai" name="jam_mulai" 
                                       value="{{ old('jam_mulai') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required>
                            </div>
                            <div>
                                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="jam_selesai" name="jam_selesai" 
                                       value="{{ old('jam_selesai') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required>
                            </div>
                            <div>
                                <label for="jumlah_peserta" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Peserta <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="jumlah_peserta" name="jumlah_peserta" 
                                       value="{{ old('jumlah_peserta', 1) }}"
                                       min="1" max="10"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required onchange="updateHarga()">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="instruktur" class="block text-sm font-medium text-gray-700 mb-2">
                                Instruktur <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="instruktur" name="instruktur" 
                                   value="{{ old('instruktur') }}"
                                   placeholder="Nama instruktur yang diinginkan"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   required>
                            <p class="text-sm text-gray-500 mt-1">
                                Tuliskan nama instruktur yang Anda inginkan atau ketik "Sesuai ketersediaan"
                            </p>
                        </div>
                    </div>

                    <!-- Estimasi Harga -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-800 mb-2">Estimasi Total Harga</h4>
                        <div id="harga-display" class="text-2xl font-bold text-indigo-600">
                            Rp 0
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            Harga akan dihitung otomatis berdasarkan jenis kelas dan jumlah peserta
                        </p>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea id="catatan" name="catatan" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  placeholder="Tuliskan permintaan khusus atau informasi tambahan...">{{ old('catatan') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('user.dashboard') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Buat Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateHarga() {
            const jenisKelas = document.getElementById('jenis_kelas').value;
            const jumlahPeserta = parseInt(document.getElementById('jumlah_peserta').value) || 1;
            
            const hargaPerOrang = {
                'pemula': 50000,
                'menengah': 75000,
                'lanjutan': 100000,
                'private': 150000
            };
            
            if (jenisKelas && hargaPerOrang[jenisKelas]) {
                const totalHarga = hargaPerOrang[jenisKelas] * jumlahPeserta;
                document.getElementById('harga-display').textContent = 
                    'Rp ' + totalHarga.toLocaleString('id-ID');
            } else {
                document.getElementById('harga-display').textContent = 'Rp 0';
            }
        }

        // Update harga saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateHarga();
        });
    </script>
</body>
</html>
