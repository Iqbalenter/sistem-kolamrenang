<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Kolam Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')
    
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Booking Kolam Renang</h1>
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

            <!-- Form Booking -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('user.booking.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Informasi Pemesan -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pemesan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-2">Nama Pemesan</label>
                                <input type="text" name="nama_pemesan" id="nama_pemesan" value="{{ old('nama_pemesan', Auth::user()->name) }}" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="tel" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="08123456789">
                            </div>
                        </div>
                    </div>

                    <!-- Detail Booking -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Booking</h3>
                        
                        <!-- Pilihan Jenis Kolam -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Jenis Kolam</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" name="jenis_kolam" id="kolam_anak" value="kolam_anak" 
                                        {{ old('jenis_kolam') == 'kolam_anak' ? 'checked' : '' }}
                                        class="sr-only peer" required>
                                    <label for="kolam_anak" class="block p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 peer-checked:bg-green-50 peer-checked:border-green-500">
                                        <div class="flex items-center">
                                            <div class="text-2xl mr-3">🧒</div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">Kolam Anak</h4>
                                                <p class="text-sm text-gray-600">Rp 15.000/jam</p>
                                                <p class="text-xs text-gray-500">Ukuran 10m x 8m, Kedalaman 0.5-1.0m</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="relative">
                                    <input type="radio" name="jenis_kolam" id="kolam_utama" value="kolam_utama" 
                                        {{ old('jenis_kolam') == 'kolam_utama' || !old('jenis_kolam') ? 'checked' : '' }}
                                        class="sr-only peer" required>
                                    <label for="kolam_utama" class="block p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 peer-checked:bg-blue-50 peer-checked:border-blue-500">
                                        <div class="flex items-center">
                                            <div class="text-2xl mr-3">🏊‍♂️</div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">Kolam Utama</h4>
                                                <p class="text-sm text-gray-600">Rp 25.000/jam</p>
                                                <p class="text-xs text-gray-500">Ukuran 25m x 12m, Kedalaman 1.5-2.5m</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="tanggal_booking" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Booking</label>
                                <input type="date" name="tanggal_booking" id="tanggal_booking" value="{{ old('tanggal_booking') }}" 
                                    min="{{ date('Y-m-d', strtotime('tomorrow')) }}" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label for="jumlah_orang" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Orang</label>
                            <input type="number" name="jumlah_orang" id="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" 
                                min="1" max="50" required
                                class="w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <small class="text-gray-500">Maksimal 50 orang</small>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="border-b pb-6">
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="catatan" id="catatan" rows="3" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Tuliskan catatan tambahan jika ada...">{{ old('catatan') }}</textarea>
                    </div>

                    <!-- Informasi Harga & Pembayaran -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-900 mb-2">Informasi Harga & Pembayaran</h4>
                        <div id="price-info" class="text-blue-800">
                            <p>• Kolam Anak: <span class="font-semibold">Rp 15.000 per jam</span></p>
                            <p>• Kolam Utama: <span class="font-semibold">Rp 25.000 per jam</span></p>
                            <p>• Total harga akan dihitung otomatis berdasarkan jenis kolam dan durasi booking</p>
                            <p>• Pembayaran dilakukan setelah booking disetujui admin</p>
                            <div id="calculated-price" class="mt-2 p-2 bg-white rounded-md hidden">
                                <p class="font-bold text-lg text-blue-900">Estimasi Total: <span id="total-amount">Rp 0</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('user.dashboard') }}" 
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
        // Auto calculate total price based on pool type
        document.addEventListener('DOMContentLoaded', function() {
            const jamMulai = document.getElementById('jam_mulai');
            const jamSelesai = document.getElementById('jam_selesai');
            const kolamAnak = document.getElementById('kolam_anak');
            const kolamUtama = document.getElementById('kolam_utama');
            const calculatedPriceDiv = document.getElementById('calculated-price');
            const totalAmountSpan = document.getElementById('total-amount');
            
            const tarif = {
                'kolam_anak': 15000,
                'kolam_utama': 25000
            };
            
            function calculatePrice() {
                if (jamMulai.value && jamSelesai.value) {
                    const start = new Date('2000-01-01 ' + jamMulai.value);
                    const end = new Date('2000-01-01 ' + jamSelesai.value);
                    const diffHours = (end - start) / (1000 * 60 * 60);
                    
                    if (diffHours > 0) {
                        // Get selected pool type
                        const selectedPool = kolamAnak.checked ? 'kolam_anak' : 'kolam_utama';
                        const tarifPerJam = tarif[selectedPool];
                        const totalPrice = diffHours * tarifPerJam;
                        
                        // Show calculated price
                        totalAmountSpan.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
                        calculatedPriceDiv.classList.remove('hidden');
                        
                        console.log('Jenis Kolam: ' + selectedPool + ', Durasi: ' + diffHours + ' jam, Total: Rp ' + totalPrice.toLocaleString('id-ID'));
                    } else {
                        calculatedPriceDiv.classList.add('hidden');
                    }
                } else {
                    calculatedPriceDiv.classList.add('hidden');
                }
            }
            
            // Add event listeners
            jamMulai.addEventListener('change', calculatePrice);
            jamSelesai.addEventListener('change', calculatePrice);
            kolamAnak.addEventListener('change', calculatePrice);
            kolamUtama.addEventListener('change', calculatePrice);
        });
    </script>
</body>
</html> 