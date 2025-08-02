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
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Informasi Tarif Sewa Alat (Per Hari)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    @foreach($stokAlats as $stokAlat)
                        <div class="flex justify-between">
                            <span class="text-blue-700">{{ $stokAlat->jenisAlat->nama }}:</span>
                            <span class="font-semibold text-blue-900">Rp {{ number_format($stokAlat->harga_sewa, 0, ',', '.') }}/hari</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Form Booking -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('user.booking.sewa-alat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                                    @foreach($stokAlats as $stokAlat)
                                        <option value="{{ $stokAlat->jenisAlat->kode }}" 
                                                data-harga="{{ $stokAlat->harga_sewa }}"
                                                {{ old('jenis_alat') == $stokAlat->jenisAlat->kode ? 'selected' : '' }}>
                                            {{ $stokAlat->jenisAlat->nama }} (Rp {{ number_format($stokAlat->harga_sewa, 0, ',', '.') }}/hari)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
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

                    <!-- Jaminan -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Jaminan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="jenis_jaminan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Jaminan <span class="text-red-500">*</span>
                                </label>
                                <select id="jenis_jaminan" name="jenis_jaminan" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        required>
                                    <option value="">Pilih Jenis Jaminan</option>
                                    <option value="ktp" {{ old('jenis_jaminan') == 'ktp' ? 'selected' : '' }}>KTP</option>
                                    <option value="sim" {{ old('jenis_jaminan') == 'sim' ? 'selected' : '' }}>SIM</option>
                                </select>
                            </div>
                            <div>
                                <label for="foto_jaminan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Jaminan <span class="text-red-500">*</span>
                                </label>
                                <input type="file" id="foto_jaminan" name="foto_jaminan" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Upload foto KTP/SIM Anda (format: JPG, PNG, max 2MB)</p>
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
                            Harga akan dihitung otomatis berdasarkan jenis alat dan jumlah (per hari)
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
        // Error handling untuk JavaScript
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', e.error);
        });

        function updateHarga() {
            try {
                const jenisAlat = document.getElementById('jenis_alat');
                const jumlahAlat = document.getElementById('jumlah_alat');
                const hargaDisplay = document.getElementById('harga-display');
                const detailHarga = document.getElementById('detail-harga');
                
                if (!jenisAlat || !jumlahAlat || !hargaDisplay || !detailHarga) {
                    console.error('Element tidak ditemukan:', {
                        jenisAlat: !!jenisAlat,
                        jumlahAlat: !!jumlahAlat,
                        hargaDisplay: !!hargaDisplay,
                        detailHarga: !!detailHarga
                    });
                    return;
                }
                
                const jenisAlatValue = jenisAlat.value;
                const jumlahAlatValue = parseInt(jumlahAlat.value) || 1;
                
                if (jenisAlatValue) {
                    // Ambil harga dari data-harga attribute
                    const selectedOption = jenisAlat.options[jenisAlat.selectedIndex];
                    const hargaPerItem = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                    
                    if (hargaPerItem > 0) {
                        const totalHarga = hargaPerItem * jumlahAlatValue;
                        hargaDisplay.textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
                        detailHarga.textContent = `${jumlahAlatValue} alat × Rp ${hargaPerItem.toLocaleString('id-ID')}/hari`;
                    } else {
                        hargaDisplay.textContent = 'Rp 0';
                        detailHarga.textContent = 'Harga akan dihitung otomatis berdasarkan jenis alat dan jumlah (per hari)';
                    }
                } else {
                    hargaDisplay.textContent = 'Rp 0';
                    detailHarga.textContent = 'Harga akan dihitung otomatis berdasarkan jenis alat dan jumlah (per hari)';
                }
            } catch (error) {
                console.error('Error in updateHarga:', error);
            }
        }

        // Update harga saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, updating harga...');
            try {
                updateHarga();
            } catch (error) {
                console.error('Error on DOMContentLoaded:', error);
            }
        });

        // Update harga saat input berubah
        document.addEventListener('change', function(e) {
            if (e.target.id === 'jenis_alat' || e.target.id === 'jumlah_alat') {
                try {
                    updateHarga();
                } catch (error) {
                    console.error('Error on change event:', error);
                }
            }
        });

        // Form validation
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const fileInput = form.querySelector('#foto_jaminan');
            
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!allowedTypes.includes(file.type)) {
                    e.preventDefault();
                    alert('File harus berupa gambar (JPG, PNG)');
                    return;
                }
                
                if (file.size > maxSize) {
                    e.preventDefault();
                    alert('Ukuran file maksimal 2MB');
                    return;
                }
            }
        });
    </script>
</body>
</html>
