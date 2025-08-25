<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Booking #{{ $booking->id }} - Sistem Kolam Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')

    <div class="min-h-screen py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Pembayaran Booking #{{ $booking->id }}</h1>
                    <a href="{{ route('user.booking.show', $booking) }}" class="text-indigo-600 hover:text-indigo-800">
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
            @if($booking->status_pembayaran === 'ditolak')
                <div class="mb-6 p-6 bg-red-50 border-l-4 border-red-400 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 15c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-800">Pembayaran Ditolak</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p class="mb-2">Bukti pembayaran Anda telah ditolak oleh admin dengan alasan:</p>
                                @if($booking->catatan_admin)
                                    <div class="bg-red-100 p-3 rounded-md border border-red-200">
                                        <p class="font-medium">Alasan penolakan:</p>
                                        <p class="mt-1">{{ $booking->catatan_admin }}</p>
                                    </div>
                                @endif
                                <p class="mt-3">
                                    <strong>Langkah selanjutnya:</strong> Silakan pilih metode pembayaran dan upload ulang bukti pembayaran yang sesuai dengan nominal dan ketentuan yang berlaku.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    @if(!$booking->metode_pembayaran)
                        <!-- Pilihan Metode Pembayaran -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold mb-6">Pilih Metode Pembayaran</h3>
                            
                            <form id="paymentForm" action="{{ route('user.booking.select-payment-method', $booking) }}" method="POST">
                                @csrf
                                <input type="hidden" id="selectedMethod" name="metode_pembayaran" value="">
                                <input type="hidden" id="selectedProvider" name="provider_pembayaran" value="">
                                <input type="hidden" id="selectedNumber" name="nomor_tujuan" value="">
                                
                                <!-- Transfer Bank -->
                                <div class="mb-8">
                                    <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center">
                                        <span class="text-2xl mr-2">🏦</span>
                                        Transfer Bank
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($paymentMethods['transfer_bank']['providers'] as $bank => $account)
                                            <div class="bank-option border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all"
                                                data-method="transfer_bank" data-provider="{{ $bank }}" data-number="{{ $account }}">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h5 class="font-medium text-gray-900">{{ $bank }}</h5>
                                                        <p class="text-sm text-gray-600">{{ $account }}</p>
                                                        <p class="text-xs text-gray-500">a.n. Kolam Renang ABC</p>
                                                    </div>
                                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full check-circle"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- E-Wallet -->
                                <div class="mb-8">
                                    <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center">
                                        <span class="text-2xl mr-2">💳</span>
                                        E-Wallet
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($paymentMethods['e_wallet']['providers'] as $ewallet => $number)
                                            <div class="bank-option border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all"
                                                data-method="e_wallet" data-provider="{{ $ewallet }}" data-number="{{ $number }}">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h5 class="font-medium text-gray-900">{{ $ewallet }}</h5>
                                                        <p class="text-sm text-gray-600">{{ $number }}</p>
                                                        <p class="text-xs text-gray-500">a.n. Kolam Renang ABC</p>
                                                    </div>
                                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full check-circle"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" id="confirmPaymentBtn" disabled
                                        class="px-6 py-3 bg-gray-400 text-white rounded-lg font-medium disabled:cursor-not-allowed">
                                        Konfirmasi Metode Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <!-- Informasi Metode Pembayaran Terpilih -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold mb-4">Metode Pembayaran Dipilih</h3>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-blue-900">{{ $booking->metode_pembayaran_label }}</h4>
                                        <p class="text-blue-800">{{ $booking->provider_pembayaran }}</p>
                                        <p class="text-sm text-blue-700">{{ $booking->nomor_tujuan }}</p>
                                        <p class="text-xs text-blue-600">a.n. Kolam Renang ABC</p>
                                    </div>
                                    @if($booking->status_pembayaran === 'belum_bayar')
                                        <form action="{{ route('user.booking.select-payment-method', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="metode_pembayaran" value="">
                                            <input type="hidden" name="provider_pembayaran" value="">
                                            <input type="hidden" name="nomor_tujuan" value="">
                                            <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
                                                Ganti Metode
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Upload Bukti Pembayaran -->
                            @if($booking->status_pembayaran === 'belum_bayar')
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                                    <h4 class="font-medium text-gray-900 mb-4">Upload Bukti Pembayaran</h4>
                                    
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                        <p class="text-sm text-yellow-800">
                                            <strong>Total yang harus dibayar:</strong><br>
                                            <span class="text-lg font-bold text-yellow-900">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                                        </p>
                                    </div>
                                    
                                    <form action="{{ route('user.booking.upload-payment', $booking) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Bukti Pembayaran</label>
                                            <input type="file" name="bukti_pembayaran" accept="image/*" required
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                                        </div>
                                        
                                        <button type="submit" 
                                            class="w-full bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 font-medium">
                                            Upload Bukti Pembayaran
                                        </button>
                                    </form>
                                </div>
                            @elseif($booking->status_pembayaran === 'menunggu_konfirmasi')
                                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                    <h4 class="font-medium text-orange-900 mb-2">Status: Menunggu Konfirmasi</h4>
                                    <p class="text-sm text-orange-800">
                                        Bukti pembayaran Anda sedang dalam proses verifikasi admin. Mohon tunggu konfirmasi.
                                    </p>
                                </div>
                                
                                @if($booking->bukti_pembayaran)
                                    <div class="mt-4">
                                        <h4 class="font-medium text-gray-900 mb-2">Bukti Pembayaran yang Diupload</h4>
                                        <img src="{{ asset('storage/' . $booking->bukti_pembayaran) }}" 
                                            alt="Bukti Pembayaran" 
                                            class="max-w-xs rounded-lg shadow-md">
                                    </div>
                                @endif
                            @elseif($booking->status_pembayaran === 'lunas')
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <h4 class="font-medium text-green-900 mb-2">✅ Pembayaran Lunas</h4>
                                    <p class="text-sm text-green-800">
                                        Pembayaran Anda telah dikonfirmasi oleh admin. Terima kasih!
                                    </p>
                                </div>
                            @elseif($booking->status_pembayaran === 'ditolak')
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                    <h4 class="font-medium text-red-900 mb-2">❌ Pembayaran Ditolak</h4>
                                    <p class="text-sm text-red-800">
                                        Bukti pembayaran Anda ditolak. Silakan upload ulang bukti pembayaran yang valid.
                                    </p>
                                </div>

                                <!-- Upload Ulang Bukti Pembayaran -->
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                                    <h4 class="font-medium text-gray-900 mb-4">Upload Ulang Bukti Pembayaran</h4>
                                    
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                        <p class="text-sm text-yellow-800">
                                            <strong>Total yang harus dibayar:</strong><br>
                                            <span class="text-lg font-bold text-yellow-900">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                                        </p>
                                    </div>
                                    
                                    <form action="{{ route('user.booking.upload-payment', $booking) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Bukti Pembayaran Baru</label>
                                            <input type="file" name="bukti_pembayaran" accept="image/*" required
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                                        </div>
                                        
                                        <button type="submit" 
                                            class="w-full bg-red-600 text-white px-4 py-3 rounded-md hover:bg-red-700 font-medium">
                                            Upload Ulang Bukti Pembayaran
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Ringkasan Booking -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Ringkasan Booking</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Nama Pemesan:</dt>
                                <dd class="font-medium">{{ $booking->nama_pemesan }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Jenis Kolam:</dt>
                                <dd class="font-medium">{{ $booking->jenis_kolam_label ?? 'Kolam Utama' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Tanggal:</dt>
                                <dd class="font-medium">{{ $booking->tanggal_booking->format('d M Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                                            <dt class="text-gray-500">Waktu Akses:</dt>
                            <dd class="font-medium">06:00 - 18:00 (Seharian Penuh)</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Jumlah Orang:</dt>
                                <dd class="font-medium">{{ $booking->jumlah_orang }} orang</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Total Pembayaran -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                        <h3 class="text-lg font-semibold mb-4">Total Pembayaran</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Jenis Kolam:</span>
                                <span>{{ $booking->jenis_kolam_label ?? 'Kolam Utama' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tarif harian:</span>
                                <span>Rp {{ number_format($booking->tarif_harian ?? 50000, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Akses:</span>
                                <span>Seharian Penuh</span>
                            </div>
                            <hr class="border-white/20 my-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total:</span>
                                <span>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Instruksi Pembayaran -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Instruksi Pembayaran</h3>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex">
                                <span class="bg-indigo-100 text-indigo-800 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">1</span>
                                <span>Pilih metode pembayaran yang Anda inginkan</span>
                            </div>
                            <div class="flex">
                                <span class="bg-indigo-100 text-indigo-800 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">2</span>
                                <span>Lakukan pembayaran sesuai nominal yang tertera</span>
                            </div>
                            <div class="flex">
                                <span class="bg-indigo-100 text-indigo-800 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">3</span>
                                <span>Upload bukti pembayaran yang jelas</span>
                            </div>
                            <div class="flex">
                                <span class="bg-indigo-100 text-indigo-800 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">4</span>
                                <span>Tunggu konfirmasi dari admin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript untuk menangani pilihan metode pembayaran
        document.addEventListener('DOMContentLoaded', function() {
            const options = document.querySelectorAll('.bank-option');
            const confirmBtn = document.getElementById('confirmPaymentBtn');
            const selectedMethod = document.getElementById('selectedMethod');
            const selectedProvider = document.getElementById('selectedProvider');
            const selectedNumber = document.getElementById('selectedNumber');

            // Check if elements exist
            if (!confirmBtn || !selectedMethod || !selectedProvider || !selectedNumber) {
                return; // Exit if not on payment selection page
            }

            options.forEach(option => {
                option.addEventListener('click', function() {
                    // Reset semua pilihan
                    options.forEach(opt => {
                        opt.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50');
                        opt.classList.add('border-gray-200');
                        const circle = opt.querySelector('.check-circle');
                        if (circle) {
                            circle.classList.remove('bg-blue-500', 'bg-green-500');
                            circle.classList.add('border-gray-300');
                            circle.innerHTML = '';
                        }
                    });

                    // Highlight pilihan yang dipilih
                    const method = this.dataset.method;
                    const checkCircle = this.querySelector('.check-circle');
                    
                    if (method === 'transfer_bank') {
                        this.classList.add('border-blue-500', 'bg-blue-50');
                        if (checkCircle) {
                            checkCircle.classList.remove('border-gray-300');
                            checkCircle.classList.add('bg-blue-500');
                        }
                    } else {
                        this.classList.add('border-green-500', 'bg-green-50');
                        if (checkCircle) {
                            checkCircle.classList.remove('border-gray-300');
                            checkCircle.classList.add('bg-green-500');
                        }
                    }
                    
                    if (checkCircle) {
                        checkCircle.innerHTML = '<span class="text-white text-xs font-bold">✓</span>';
                    }

                    // Set values
                    selectedMethod.value = this.dataset.method || '';
                    selectedProvider.value = this.dataset.provider || '';
                    selectedNumber.value = this.dataset.number || '';

                    // Enable button
                    confirmBtn.disabled = false;
                    confirmBtn.classList.remove('bg-gray-400');
                    confirmBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                    confirmBtn.style.cursor = 'pointer';
                });
            });
        });
    </script>
</body>
</html>