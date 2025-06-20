<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking #{{ $booking->id }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-6 sm:py-12 px-3 sm:px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Booking #{{ $booking->id }}</h1>
                    <a href="{{ route('admin.bookings.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm sm:text-base">
                        ← Kembali ke Daftar Booking
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm sm:text-base">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm sm:text-base">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Status Booking</h3>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0 mb-3 sm:mb-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800', 
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'completed' => 'bg-blue-100 text-blue-800'
                                ];
                                
                                $paymentColors = [
                                    'belum_bayar' => 'bg-gray-100 text-gray-800',
                                    'menunggu_konfirmasi' => 'bg-orange-100 text-orange-800', 
                                    'lunas' => 'bg-green-100 text-green-800',
                                    'ditolak' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            
                            <span class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $booking->status_label }}
                            </span>
                            
                            <span class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium {{ $paymentColors[$booking->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $booking->status_pembayaran_label }}
                            </span>
                        </div>
                        
                        <!-- Timeline -->
                        <div class="border-l-2 border-gray-200 ml-2 sm:ml-4 pl-3 sm:pl-4 space-y-3 sm:space-y-4">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-2 h-2 sm:w-3 sm:h-3 bg-blue-500 rounded-full"></div>
                                <div>
                                    <p class="text-xs sm:text-sm font-medium">Booking dibuat</p>
                                    <p class="text-xs text-gray-500">{{ $booking->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($booking->approved_at)
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <div class="w-2 h-2 sm:w-3 sm:h-3 bg-green-500 rounded-full"></div>
                                    <div>
                                        <p class="text-xs sm:text-sm font-medium">Booking disetujui</p>
                                        <p class="text-xs text-gray-500">{{ $booking->approved_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($booking->rejected_at)
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <div class="w-2 h-2 sm:w-3 sm:h-3 bg-red-500 rounded-full"></div>
                                    <div>
                                        <p class="text-xs sm:text-sm font-medium">Booking ditolak</p>
                                        <p class="text-xs text-gray-500">{{ $booking->rejected_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer & Booking Details -->
                    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Detail Booking</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2 sm:mb-3 text-sm sm:text-base">Informasi Customer</h4>
                                <dl class="space-y-1.5 sm:space-y-2">
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">Nama:</dt>
                                        <dd class="text-xs sm:text-sm font-medium">{{ $booking->nama_pemesan }}</dd>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">Email:</dt>
                                        <dd class="text-xs sm:text-sm font-medium break-all">{{ $booking->user->email }}</dd>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">No. Telepon:</dt>
                                        <dd class="text-xs sm:text-sm font-medium">{{ $booking->nomor_telepon }}</dd>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">User ID:</dt>
                                        <dd class="text-xs sm:text-sm font-medium">#{{ $booking->user_id }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2 sm:mb-3 text-sm sm:text-base">Detail Booking</h4>
                                <dl class="space-y-1.5 sm:space-y-2">
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">Jenis Kolam:</dt>
                                        <dd class="text-xs sm:text-sm font-medium">{{ $booking->jenis_kolam_label ?? 'Kolam Utama' }}</dd>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">Tanggal:</dt>
                                        <dd class="text-xs sm:text-sm font-medium">{{ $booking->tanggal_booking->format('d M Y') }}</dd>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">Waktu:</dt>
                                        <dd class="text-xs sm:text-sm font-medium">{{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}</dd>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">Durasi:</dt>
                                        <dd class="text-xs sm:text-sm font-medium">{{ $booking->durasi }} jam</dd>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <dt class="text-xs sm:text-sm text-gray-500">Jumlah Orang:</dt>
                                        <dd class="text-xs sm:text-sm font-medium">{{ $booking->jumlah_orang }} orang</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        @if($booking->catatan)
                            <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t">
                                <h4 class="font-medium text-gray-900 mb-2 text-sm sm:text-base">Catatan Customer</h4>
                                <p class="text-xs sm:text-sm text-gray-700 bg-gray-50 p-2 sm:p-3 rounded-lg">{{ $booking->catatan }}</p>
                            </div>
                        @endif
                        
                        @if($booking->catatan_admin)
                            <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t">
                                <h4 class="font-medium text-gray-900 mb-2 text-sm sm:text-base">Catatan Admin</h4>
                                <p class="text-xs sm:text-sm text-gray-700 bg-yellow-50 p-2 sm:p-3 rounded-lg">{{ $booking->catatan_admin }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Proof -->
                    @if($booking->bukti_pembayaran)
                        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Bukti Pembayaran</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <img src="{{ asset('storage/' . $booking->bukti_pembayaran) }}" 
                                        alt="Bukti Pembayaran" 
                                        class="w-full h-auto rounded-lg shadow-md cursor-pointer hover:opacity-95 transition-opacity"
                                        onclick="openImageModal('{{ asset('storage/' . $booking->bukti_pembayaran) }}')"
                                        style="max-height: 250px; object-fit: cover;">
                                    <p class="text-xs text-gray-500 mt-2 text-center">Tap untuk memperbesar</p>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2 text-sm sm:text-base">Informasi Upload</h4>
                                    <dl class="space-y-1.5 sm:space-y-2">
                                        <div class="flex flex-col sm:flex-row sm:justify-between">
                                            <dt class="text-xs sm:text-sm text-gray-500">Upload pada:</dt>
                                            <dd class="text-xs sm:text-sm font-medium">{{ $booking->updated_at->format('d M Y H:i') }}</dd>
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:justify-between">
                                            <dt class="text-xs sm:text-sm text-gray-500">Total Harga:</dt>
                                            <dd class="text-xs sm:text-sm font-medium">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</dd>
                                        </div>
                                        @if($booking->metode_pembayaran)
                                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                                <dt class="text-xs sm:text-sm text-gray-500">Metode Pembayaran:</dt>
                                                <dd class="text-xs sm:text-sm font-medium">{{ $booking->metode_pembayaran_label }}</dd>
                                            </div>
                                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                                <dt class="text-xs sm:text-sm text-gray-500">Provider:</dt>
                                                <dd class="text-xs sm:text-sm font-medium">{{ $booking->provider_pembayaran }}</dd>
                                            </div>
                                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                                <dt class="text-xs sm:text-sm text-gray-500">Nomor Tujuan:</dt>
                                                <dd class="text-xs sm:text-sm font-medium">{{ $booking->nomor_tujuan }}</dd>
                                            </div>
                                        @endif
                                        <div class="flex flex-col sm:flex-row sm:justify-between">
                                            <dt class="text-xs sm:text-sm text-gray-500">Status:</dt>
                                            <dd class="text-xs sm:text-sm font-medium">
                                                <span class="px-2 py-1 rounded-full text-xs {{ $paymentColors[$booking->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $booking->status_pembayaran_label }}
                                                </span>
                                            </dd>
                                        </div>
                                    </dl>
                                    
                                    @if($booking->status_pembayaran === 'menunggu_konfirmasi')
                                        <div class="mt-3 sm:mt-4 p-2 sm:p-3 bg-orange-50 rounded-lg">
                                            <p class="text-xs sm:text-sm text-orange-800 font-medium">⚠️ Menunggu konfirmasi Anda</p>
                                            <p class="text-xs text-orange-700 mt-1">Silakan periksa bukti pembayaran dan konfirmasi jika sudah sesuai.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar Actions -->
                <div class="space-y-4 sm:space-y-6">
                    <!-- Price Summary -->
                    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Ringkasan Harga</h3>
                        <dl class="space-y-2 sm:space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-xs sm:text-sm text-gray-500">Jenis Kolam:</dt>
                                <dd class="text-xs sm:text-sm font-medium">{{ $booking->jenis_kolam_label ?? 'Kolam Utama' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-xs sm:text-sm text-gray-500">Tarif per jam:</dt>
                                <dd class="text-xs sm:text-sm font-medium">Rp {{ number_format($booking->tarif_per_jam ?? 25000, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-xs sm:text-sm text-gray-500">Durasi:</dt>
                                <dd class="text-xs sm:text-sm font-medium">{{ $booking->durasi }} jam</dd>
                            </div>
                            <div class="border-t pt-2 sm:pt-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm sm:text-base font-medium text-gray-900">Total:</dt>
                                    <dd class="text-base sm:text-lg font-bold text-indigo-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>

                    <!-- Admin Actions -->
                    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Aksi Admin</h3>
                        <div class="space-y-2 sm:space-y-3">
                            
                            @if($booking->status === 'pending')
                                <!-- Approve Button -->
                                <button onclick="approveBooking({{ $booking->id }})"
                                    class="w-full bg-green-600 text-white px-3 sm:px-4 py-2 rounded-md hover:bg-green-700 flex items-center justify-center text-xs sm:text-sm">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Setujui Booking
                                </button>
                                
                                <!-- Reject Button -->
                                <button onclick="showRejectModal()"
                                    class="w-full bg-red-600 text-white px-3 sm:px-4 py-2 rounded-md hover:bg-red-700 flex items-center justify-center text-xs sm:text-sm">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Tolak Booking
                                </button>
                            @endif
                            
                            @if($booking->status_pembayaran === 'menunggu_konfirmasi')
                                <!-- Confirm Payment Button -->
                                <button onclick="confirmPayment({{ $booking->id }})"
                                    class="w-full bg-green-600 text-white px-3 sm:px-4 py-2 rounded-md hover:bg-green-700 flex items-center justify-center text-xs sm:text-sm">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Konfirmasi Pembayaran
                                </button>
                                
                                <!-- Reject Payment Button -->
                                <button onclick="showRejectPaymentModal()"
                                    class="w-full bg-red-600 text-white px-3 sm:px-4 py-2 rounded-md hover:bg-red-700 flex items-center justify-center text-xs sm:text-sm">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Tolak Pembayaran
                                </button>
                            @endif
                            
                            @if($booking->status === 'approved' && $booking->status_pembayaran === 'lunas')
                                <!-- Complete Button -->
                                <button onclick="completeBooking({{ $booking->id }})"
                                    class="w-full bg-purple-600 text-white px-3 sm:px-4 py-2 rounded-md hover:bg-purple-700 flex items-center justify-center text-xs sm:text-sm">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Selesaikan Booking
                                </button>
                            @endif
                            
                            <!-- Delete Button -->
                            <button onclick="confirmDeleteBooking({{ $booking->id }})"
                                class="w-full bg-red-600 text-white px-3 sm:px-4 py-2 rounded-md hover:bg-red-700 flex items-center justify-center text-xs sm:text-sm">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus Booking
                            </button>
                            
                            <!-- Back Button -->
                            <a href="{{ route('admin.bookings.index') }}" 
                                class="w-full bg-gray-600 text-white px-3 sm:px-4 py-2 rounded-md hover:bg-gray-700 text-center block text-xs sm:text-sm">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="bg-blue-50 rounded-lg p-3 sm:p-4">
                        <h4 class="font-medium text-blue-900 mb-2 text-sm sm:text-base">💡 Info</h4>
                        <div class="text-xs sm:text-sm text-blue-800 space-y-1">
                            @if($booking->status === 'pending')
                                <p>• Booking menunggu persetujuan Anda</p>
                                <p>• Customer akan dapat upload pembayaran setelah disetujui</p>
                            @elseif($booking->status === 'approved' && $booking->status_pembayaran === 'belum_bayar')
                                <p>• Booking sudah disetujui</p>
                                <p>• Menunggu customer upload bukti pembayaran</p>
                            @elseif($booking->status_pembayaran === 'menunggu_konfirmasi')
                                <p>• Customer sudah upload bukti pembayaran</p>
                                <p>• Silakan periksa dan konfirmasi</p>
                            @elseif($booking->status_pembayaran === 'lunas')
                                <p>• Pembayaran sudah dikonfirmasi</p>
                                <p>• Booking siap dilaksanakan</p>
                            @elseif($booking->status_pembayaran === 'ditolak')
                                <p>• Pembayaran telah ditolak</p>
                                <p>• Customer perlu upload ulang bukti pembayaran</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Tolak Booking</h3>
                <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3 sm:mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                        <textarea name="catatan_admin" rows="4" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 text-xs sm:text-sm"
                            placeholder="Jelaskan alasan penolakan booking (mis: jadwal bentrok, fasilitas tidak tersedia, dll)"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 sm:space-x-3">
                        <button type="button" onclick="closeRejectModal()"
                            class="px-3 sm:px-4 py-2 text-gray-600 hover:text-gray-800 text-xs sm:text-sm">Batal</button>
                        <button type="submit" 
                            class="px-3 sm:px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs sm:text-sm">Tolak Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Payment Modal -->
    <div id="rejectPaymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Tolak Pembayaran</h3>
                <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">Bukti pembayaran akan dihapus dan user harus upload ulang bukti pembayaran yang baru.</p>
                <form action="{{ route('admin.bookings.reject-payment', $booking) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3 sm:mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Alasan Penolakan Pembayaran *</label>
                        <textarea name="catatan_admin" rows="4" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 text-xs sm:text-sm"
                            placeholder="Jelaskan alasan penolakan pembayaran (mis: nominal tidak sesuai, bukti tidak jelas, dll)"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 sm:space-x-3">
                        <button type="button" onclick="closeRejectPaymentModal()"
                            class="px-3 sm:px-4 py-2 text-gray-600 hover:text-gray-800 text-xs sm:text-sm">Batal</button>
                        <button type="submit" 
                            class="px-3 sm:px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs sm:text-sm">Tolak Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="relative max-w-full max-h-full">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-full object-contain rounded-lg">
                <button onclick="closeImageModal()" class="absolute top-2 right-2 sm:top-4 sm:right-4 text-white text-xl sm:text-2xl bg-black bg-opacity-50 rounded-full w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center hover:bg-opacity-75">×</button>
            </div>
        </div>
    </div>

    <script>
        function approveBooking(bookingId) {
            if (confirm('Apakah Anda yakin ingin menyetujui booking ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/bookings/${bookingId}/approve`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function showRejectModal() {
            document.getElementById('rejectModal').style.display = 'block';
        }
        
        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }
        
        function showRejectPaymentModal() {
            document.getElementById('rejectPaymentModal').style.display = 'block';
        }
        
        function closeRejectPaymentModal() {
            document.getElementById('rejectPaymentModal').style.display = 'none';
        }
        
        function confirmPayment(bookingId) {
            if (confirm('Konfirmasi pembayaran untuk booking ini?\n\nPastikan bukti pembayaran sudah sesuai dengan total harga.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/bookings/${bookingId}/confirm-payment`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function completeBooking(bookingId) {
            if (confirm('Tandai booking ini sebagai selesai?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/bookings/${bookingId}/complete`;
                
                const csrfToken = document.createElement('input');
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        function confirmDeleteBooking(bookingId) {
            if (confirm('Apakah Anda yakin ingin menghapus booking ini?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data booking termasuk bukti pembayaran.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/bookings/${bookingId}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            const rejectModal = document.getElementById('rejectModal');
            const rejectPaymentModal = document.getElementById('rejectPaymentModal');
            const imageModal = document.getElementById('imageModal');
            
            if (e.target === rejectModal) {
                closeRejectModal();
            }
            if (e.target === rejectPaymentModal) {
                closeRejectPaymentModal();
            }
            if (e.target === imageModal) {
                closeImageModal();
            }
        });
        
        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRejectModal();
                closeRejectPaymentModal();
                closeImageModal();
            }
        });
    </script>
</body>
</html> 