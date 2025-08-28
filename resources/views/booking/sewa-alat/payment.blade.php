<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Booking Sewa Alat #{{ $bookingSewaAlat->id }} - Sistem Kolam Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')

    <div class="min-h-screen py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Pembayaran Booking Sewa Alat #{{ $bookingSewaAlat->id }}</h1>
                    <a href="{{ route('user.booking.sewa-alat.show', $bookingSewaAlat) }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Detail
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

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Notifikasi Pembayaran Ditolak -->
            @if($bookingSewaAlat->status_pembayaran === 'ditolak')
                <div class="mb-6 p-6 bg-red-50 border-l-4 border-red-400 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Pembayaran Ditolak</h3>
                            <div class="mt-1 text-sm text-red-700">
                                <p>Pembayaran sebelumnya ditolak oleh admin. Silakan pilih metode pembayaran dan upload bukti pembayaran yang baru.</p>
                                @if($bookingSewaAlat->catatan_admin)
                                    <p class="mt-2 font-medium">Catatan Admin: {{ $bookingSewaAlat->catatan_admin }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Detail Booking -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Detail Booking Sewa Alat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Informasi Penyewa</h4>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">ID Booking:</dt>
                                        <dd class="text-sm font-medium">#{{ $bookingSewaAlat->id }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Nama:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->nama_penyewa }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">No. Telepon:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->nomor_telepon }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Email:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->user->email }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Detail Sewa Alat</h4>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Jenis Alat:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->jenis_alat_label }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Tanggal:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->tanggal_sewa->format('d M Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Jaminan:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->jenis_jaminan_label }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Status Pengembalian:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->alat_dikembalikan ? 'Sudah Dikembalikan' : 'Belum Dikembalikan' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Jumlah Alat:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->jumlah_alat }} unit</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        @if($bookingSewaAlat->catatan)
                            <div class="mt-6 pt-6 border-t">
                                <h4 class="font-medium text-gray-900 mb-2">Catatan</h4>
                                <p class="text-gray-700">{{ $bookingSewaAlat->catatan }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Information -->
                    @if($bookingSewaAlat->metode_pembayaran)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Pembayaran</h3>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Metode:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->metode_pembayaran_label }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Provider:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->provider_pembayaran }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Nomor Tujuan:</dt>
                                        <dd class="text-sm font-medium">{{ $bookingSewaAlat->nomor_tujuan }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">A.n:</dt>
                                        <dd class="text-sm font-medium">Kolam Renang Sejahtera</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            @if($bookingSewaAlat->bukti_pembayaran)
                                <h4 class="font-medium text-gray-900 mb-2">Bukti Pembayaran</h4>
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $bookingSewaAlat->bukti_pembayaran) }}" 
                                        alt="Bukti Pembayaran" 
                                        class="max-w-full h-auto rounded-lg shadow-md mx-auto"
                                        style="max-height: 400px;">
                                    <p class="text-sm text-gray-500 mt-2">
                                        Upload pada: {{ $bookingSewaAlat->updated_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Price Summary -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Ringkasan Harga</h3>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Jenis Alat:</dt>
                                <dd class="text-sm font-medium">{{ $bookingSewaAlat->jenis_alat_label }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Harga per Item:</dt>
                                <dd class="text-sm font-medium">Rp {{ number_format($bookingSewaAlat->harga_per_item, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Sewa per Hari:</dt>
                                <dd class="text-sm font-medium">1 hari</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Jumlah alat:</dt>
                                <dd class="text-sm font-medium">{{ $bookingSewaAlat->jumlah_alat }} unit</dd>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between">
                                    <dt class="text-base font-medium text-gray-900">Total:</dt>
                                    <dd class="text-lg font-bold text-indigo-600">Rp {{ number_format($bookingSewaAlat->total_harga, 0, ',', '.') }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                    <!-- Payment Actions -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Pembayaran</h3>
                        <div class="space-y-3">
                            @if(!$bookingSewaAlat->metode_pembayaran)
                                <div class="bg-blue-50 p-3 rounded-lg mb-3">
                                    <p class="text-sm text-blue-800 font-medium mb-1">
                                        Pilih Metode Pembayaran
                                    </p>
                                    <p class="text-sm text-blue-700">
                                        Silakan pilih metode pembayaran yang Anda inginkan.
                                    </p>
                                </div>
                                <button onclick="togglePaymentForm()" 
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-center block">
                                    Pilih Metode Pembayaran
                                </button>
                            @else
                                @if(!$bookingSewaAlat->bukti_pembayaran)
                                    <div class="bg-orange-50 p-3 rounded-lg mb-3">
                                        <p class="text-sm text-orange-800 font-medium mb-1">
                                            Upload Bukti Pembayaran
                                        </p>
                                        <p class="text-sm text-orange-700">
                                            Silakan upload bukti pembayaran sesuai metode yang dipilih.
                                        </p>
                                    </div>
                                    <button onclick="toggleUploadForm()" 
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-center block">
                                        Upload Bukti Pembayaran
                                    </button>
                                    <button onclick="togglePaymentForm()" 
                                        class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-center block mt-2">
                                        Ganti Metode Pembayaran
                                    </button>
                                @else
                                    <div class="bg-green-50 p-3 rounded-lg">
                                        <p class="text-sm text-green-800">
                                            Bukti pembayaran sudah diupload dan sedang dalam proses verifikasi admin.
                                        </p>
                                    </div>
                                @endif
                            @endif
                            
                            <a href="{{ route('user.booking.sewa-alat.show', $bookingSewaAlat) }}" 
                                class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-center block">
                                Kembali ke Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Forms -->
            <div id="payment-form" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pilih Metode Pembayaran</h3>
                        <form action="{{ route('user.booking.sewa-alat.select-payment-method', $bookingSewaAlat) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Metode Pembayaran</label>
                                    <div class="space-y-3">
                                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="radio" name="metode_pembayaran" value="transfer_bank" class="text-indigo-600 focus:ring-indigo-500" required>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Transfer Bank</div>
                                                <div class="text-sm text-gray-500">Transfer ke rekening bank</div>
                                            </div>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="radio" name="metode_pembayaran" value="e_wallet" class="text-indigo-600 focus:ring-indigo-500" required>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">E-Wallet</div>
                                                <div class="text-sm text-gray-500">OVO, GoPay, DANA, dll</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div id="bank-details" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bank Tujuan</label>
                                    <select name="provider_pembayaran_bank" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Pilih Bank</option>
                                        <option value="BCA">BCA</option>
                                        <option value="Mandiri">Bank Mandiri</option>
                                        <option value="BRI">Bank BRI</option>
                                        <option value="BNI">Bank BNI</option>
                                    </select>
                                    
                                    <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                        <p class="text-sm text-blue-800 font-medium">Informasi Transfer:</p>
                                        <div class="text-sm text-blue-700 mt-1">
                                            <p>BCA: 1234567890 a.n. Kolam Renang Sejahtera</p>
                                            <p>Mandiri: 9876543210 a.n. Kolam Renang Sejahtera</p>
                                            <p>BRI: 5555444433 a.n. Kolam Renang Sejahtera</p>
                                            <p>BNI: 7777888899 a.n. Kolam Renang Sejahtera</p>
                                        </div>
                                    </div>
                                </div>

                                <div id="ewallet-details" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">E-Wallet</label>
                                    <select name="provider_pembayaran_ewallet" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Pilih E-Wallet</option>
                                        <option value="OVO">OVO</option>
                                        <option value="GoPay">GoPay</option>
                                        <option value="DANA">DANA</option>
                                        <option value="LinkAja">LinkAja</option>
                                    </select>
                                    
                                    <div class="mt-3 p-3 bg-purple-50 rounded-lg">
                                        <p class="text-sm text-purple-800 font-medium">Informasi E-Wallet:</p>
                                        <div class="text-sm text-purple-700 mt-1">
                                            <p>OVO: 081234567890</p>
                                            <p>GoPay: 081234567890</p>
                                            <p>DANA: 081234567890</p>
                                            <p>LinkAja: 081234567890</p>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="nomor_tujuan" id="nomor_tujuan">
                                <input type="hidden" name="provider_pembayaran" id="provider_pembayaran">

                                <div class="flex space-x-4">
                                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        Pilih Metode Pembayaran
                                    </button>
                                    <button type="button" onclick="togglePaymentForm()" class="flex-1 bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div id="upload-form" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Upload Bukti Pembayaran</h3>
                        <form action="{{ route('user.booking.sewa-alat.upload-payment', $bookingSewaAlat) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                                    <input type="file" name="bukti_pembayaran" accept="image/*" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                                </div>

                                <div class="flex space-x-4">
                                    <button type="submit" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        Upload Bukti Pembayaran
                                    </button>
                                    <button type="button" onclick="toggleUploadForm()" class="flex-1 bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePaymentForm() {
            const paymentForm = document.getElementById('payment-form');
            paymentForm.classList.toggle('hidden');
        }

        function toggleUploadForm() {
            const uploadForm = document.getElementById('upload-form');
            uploadForm.classList.toggle('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const metodePembayaran = document.querySelectorAll('input[name="metode_pembayaran"]');
            const bankDetails = document.getElementById('bank-details');
            const ewalletDetails = document.getElementById('ewallet-details');

            metodePembayaran.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    if (this.value === 'transfer_bank') {
                        bankDetails.classList.remove('hidden');
                        ewalletDetails.classList.add('hidden');
                    } else if (this.value === 'e_wallet') {
                        bankDetails.classList.add('hidden');
                        ewalletDetails.classList.remove('hidden');
                    }
                });
            });

            // Handle provider selection
            const bankSelect = document.querySelector('select[name="provider_pembayaran_bank"]');
            const ewalletSelect = document.querySelector('select[name="provider_pembayaran_ewallet"]');
            const nomorTujuanInput = document.getElementById('nomor_tujuan');
            const providerInput = document.getElementById('provider_pembayaran');

            if (bankSelect) {
                bankSelect.addEventListener('change', function() {
                    const bankInfo = {
                        'BCA': '1234567890',
                        'Mandiri': '9876543210',
                        'BRI': '5555444433',
                        'BNI': '7777888899'
                    };
                    if (this.value && bankInfo[this.value]) {
                        nomorTujuanInput.value = bankInfo[this.value];
                        providerInput.value = this.value;
                    }
                });
            }

            if (ewalletSelect) {
                ewalletSelect.addEventListener('change', function() {
                    if (this.value) {
                        nomorTujuanInput.value = '081234567890';
                        providerInput.value = this.value;
                    }
                });
            }

            // Close modals when clicking outside
            window.onclick = function(event) {
                const paymentForm = document.getElementById('payment-form');
                const uploadForm = document.getElementById('upload-form');
                
                if (event.target == paymentForm) {
                    paymentForm.classList.add('hidden');
                }
                if (event.target == uploadForm) {
                    uploadForm.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>
