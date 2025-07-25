<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Sewa Alat Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')
    
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Booking Sewa Alat Renang</h1>
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
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Informasi Tarif Sewa Alat (Per Jam)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-blue-700">Ban Renang:</span>
                        <span class="font-semibold text-blue-900">Rp 5.000/jam</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Kacamata Renang:</span>
                        <span class="font-semibold text-blue-900">Rp 3.000/jam</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Papan Renang:</span>
                        <span class="font-semibold text-blue-900">Rp 7.000/jam</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Pelampung:</span>
                        <span class="font-semibold text-blue-900">Rp 5.000/jam</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Fins (Kaki Katak):</span>
                        <span class="font-semibold text-blue-900">Rp 8.000/jam</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Snorkel:</span>
                        <span class="font-semibold text-blue-900">Rp 6.000/jam</span>
                    </div>
                </div>
            </div>

            <!-- Form Booking -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('user.booking.sewa-alat.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Data Penyewa -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Penyewa</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_penyewa" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Penyewa <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_penyewa" name="nama_penyewa" 
                                       value="{{ old('nama_penyewa', Auth::user()->name) }}"
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

                    <!-- Detail Sewa -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Sewa Alat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tanggal_sewa" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Sewa <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tanggal_sewa" name="tanggal_sewa" 
                                       value="{{ old('tanggal_sewa') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required>
                            </div>
                            <div>
                                <label for="jenis_alat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Alat <span class="text-red-500">*</span>
                                </label>
                                <select id="jenis_alat" name="jenis_alat" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        required onchange="updateHarga()">
                                    <option value="">Pilih Jenis Alat</option>
                                    <option value="ban_renang" {{ old('jenis_alat') == 'ban_renang' ? 'selected' : '' }}>
                                        Ban Renang (Rp 5.000/jam)
                                    </option>
                                    <option value="kacamata_renang" {{ old('jenis_alat') == 'kacamata_renang' ? 'selected' : '' }}>
                                        Kacamata Renang (Rp 3.000/jam)
                                    </option>
                                    <option value="papan_renang" {{ old('jenis_alat') == 'papan_renang' ? 'selected' : '' }}>
                                        Papan Renang (Rp 7.000/jam)
                                    </option>
                                    <option value="pelampung" {{ old('jenis_alat') == 'pelampung' ? 'selected' : '' }}>
                                        Pelampung (Rp 5.000/jam)
                                    </option>
                                    <option value="fins" {{ old('jenis_alat') == 'fins' ? 'selected' : '' }}>
                                        Fins - Kaki Katak (Rp 8.000/jam)
                                    </option>
                                    <option value="snorkel" {{ old('jenis_alat') == 'snorkel' ? 'selected' : '' }}>
                                        Snorkel (Rp 6.000/jam)
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
                                       required onchange="updateHarga()">
                            </div>
                            <div>
                                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="jam_selesai" name="jam_selesai" 
                                       value="{{ old('jam_selesai') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required onchange="updateHarga()">
                            </div>
                            <div>
                                <label for="jumlah_alat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Alat <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="jumlah_alat" name="jumlah_alat" 
                                       value="{{ old('jumlah_alat', 1) }}"
                                       min="1" max="20"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required onchange="updateHarga()">
                            </div>
                        </div>
                    </div>

                    <!-- Estimasi Harga -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-800 mb-2">Estimasi Total Harga</h4>
                        <div id="harga-display" class="text-2xl font-bold text-indigo-600">
                            Rp 0
                        </div>
                        <div id="detail-harga" class="text-sm text-gray-600 mt-1">
                            Harga akan dihitung otomatis berdasarkan jenis alat, jumlah, dan durasi sewa
                        </div>
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
            const jenisAlat = document.getElementById('jenis_alat').value;
            const jumlahAlat = parseInt(document.getElementById('jumlah_alat').value) || 1;
            const jamMulai = document.getElementById('jam_mulai').value;
            const jamSelesai = document.getElementById('jam_selesai').value;
            
            const hargaPerItem = {
                'ban_renang': 5000,
                'kacamata_renang': 3000,
                'papan_renang': 7000,
                'pelampung': 5000,
                'fins': 8000,
                'snorkel': 6000
            };
            
            if (jenisAlat && hargaPerItem[jenisAlat] && jamMulai && jamSelesai) {
                const start = new Date(`2000-01-01T${jamMulai}`);
                const end = new Date(`2000-01-01T${jamSelesai}`);
                const durasi = (end - start) / (1000 * 60 * 60); // durasi dalam jam
                
                if (durasi > 0) {
                    const totalHarga = hargaPerItem[jenisAlat] * jumlahAlat * durasi;
                    document.getElementById('harga-display').textContent = 
                        'Rp ' + totalHarga.toLocaleString('id-ID');
                    document.getElementById('detail-harga').textContent = 
                        `${durasi} jam × ${jumlahAlat} alat × Rp ${hargaPerItem[jenisAlat].toLocaleString('id-ID')}`;
                } else {
                    document.getElementById('harga-display').textContent = 'Rp 0';
                    document.getElementById('detail-harga').textContent = 'Jam selesai harus lebih besar dari jam mulai';
                }
            } else {
                document.getElementById('harga-display').textContent = 'Rp 0';
                document.getElementById('detail-harga').textContent = 
                    'Harga akan dihitung otomatis berdasarkan jenis alat, jumlah, dan durasi sewa';
            }
        }

        // Update harga saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateHarga();
        });
    </script>
</body>
</html>
