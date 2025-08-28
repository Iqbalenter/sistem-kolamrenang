<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking #{{ $booking->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Detail Booking #{{ $booking->id }}</h1>
                    <a href="{{ route('user.booking.history') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke History
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Status Booking</h3>
                        <div class="flex items-center space-x-4">
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
                            
                            <span class="px-4 py-2 rounded-full text-sm font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $booking->status_label }}
                            </span>
                            
                            <span class="px-4 py-2 rounded-full text-sm font-medium {{ $paymentColors[$booking->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $booking->status_pembayaran_label }}
                            </span>
                        </div>
                        
                        @if($booking->approved_at)
                            <p class="text-sm text-gray-600 mt-2">
                                Disetujui pada: {{ $booking->approved_at->format('d M Y H:i') }}
                            </p>
                        @endif
                        
                        @if($booking->rejected_at)
                            <p class="text-sm text-gray-600 mt-2">
                                Ditolak pada: {{ $booking->rejected_at->format('d M Y H:i') }}
                            </p>
                        @endif
                    </div>

                    <!-- Booking Details -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Detail Booking</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Informasi Pemesan</h4>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Nama:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->nama_pemesan }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">No. Telepon:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->nomor_telepon }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Email:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->user->email }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Waktu & Tempat</h4>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Jenis Kolam:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->jenis_kolam_label ?? 'Kolam Utama' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Tanggal:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->tanggal_booking->format('d M Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Waktu Akses:</dt>
                                        <dd class="text-sm font-medium">06:00 - 18:00 (Seharian Penuh)</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Jumlah Orang:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->jumlah_orang }} orang</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        @if($booking->catatan)
                            <div class="mt-6 pt-6 border-t">
                                <h4 class="font-medium text-gray-900 mb-2">Catatan</h4>
                                <p class="text-gray-700">{{ $booking->catatan }}</p>
                            </div>
                        @endif
                        
                        @if($booking->catatan_admin)
                            <div class="mt-6 pt-6 border-t">
                                @if($booking->status_pembayaran === 'ditolak')
                                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                        <h4 class="font-medium text-red-900 mb-2 flex items-center">
                                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 15c-.77.833.192 2.5 1.732 2.5z"/>
                                            </svg>
                                            Alasan Penolakan Pembayaran
                                        </h4>
                                        <p class="text-red-800">{{ $booking->catatan_admin }}</p>
                                    </div>
                                @else
                                    <div class="p-4 bg-yellow-50 rounded-lg">
                                        <h4 class="font-medium text-yellow-900 mb-2">Catatan Admin</h4>
                                        <p class="text-yellow-800">{{ $booking->catatan_admin }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Payment Information -->
                    @if($booking->metode_pembayaran)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Pembayaran</h3>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Metode:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->metode_pembayaran_label }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Provider:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->provider_pembayaran }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Nomor Tujuan:</dt>
                                        <dd class="text-sm font-medium">{{ $booking->nomor_tujuan }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">A.n:</dt>
                                        <dd class="text-sm font-medium">Kolam Renang ABC</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            @if($booking->bukti_pembayaran)
                                <h4 class="font-medium text-gray-900 mb-2">Bukti Pembayaran</h4>
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $booking->bukti_pembayaran) }}" 
                                        alt="Bukti Pembayaran" 
                                        class="max-w-full h-auto rounded-lg shadow-md mx-auto"
                                        style="max-height: 400px;">
                                    <p class="text-sm text-gray-500 mt-2">
                                        Upload pada: {{ $booking->updated_at->format('d M Y H:i') }}
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
                                <dt class="text-sm text-gray-500">Harga Ticket:</dt>
                                <dd class="text-sm font-medium">{{ $booking->jenis_kolam_label ?? 'Ticket Utama' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Tarif harian:</dt>
                                <dd class="text-sm font-medium">Rp {{ number_format($booking->tarif_harian ?? 50000, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Jumlah Orang:</dt>
                                <dd class="text-sm font-medium">{{ $booking->jumlah_orang }} orang</dd>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between">
                                    <dt class="text-base font-medium text-gray-900">Total:</dt>
                                    <dd class="text-lg font-bold text-indigo-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Aksi</h3>
                        <div class="space-y-3">
                            @if($booking->status === 'approved' && $booking->status_pembayaran === 'belum_bayar')
                                @if(!$booking->metode_pembayaran)
                                    <a href="{{ route('user.booking.payment', $booking) }}"
                                        class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-center block">
                                        Pilih Metode Pembayaran
                                    </a>
                                @else
                                    <a href="{{ route('user.booking.payment', $booking) }}"
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-center block">
                                        Lanjutkan Pembayaran
                                    </a>
                                    <a href="{{ route('user.booking.payment', $booking) }}"
                                        class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-center block mt-2">
                                        Ganti Metode Pembayaran
                                    </a>
                                @endif
                            @endif

                            @if($booking->status === 'approved' && $booking->status_pembayaran === 'ditolak')
                                <div class="bg-red-50 p-3 rounded-lg mb-3">
                                    <p class="text-sm text-red-800 font-medium mb-1">
                                        Pembayaran Ditolak
                                    </p>
                                    <p class="text-sm text-red-700">
                                        Silakan upload ulang bukti pembayaran yang benar.
                                    </p>
                                </div>
                                <a href="{{ route('user.booking.payment', $booking) }}"
                                    class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-center block">
                                    Upload Ulang Bukti Pembayaran
                                </a>
                            @endif
                            
                            @if($booking->status === 'approved' && $booking->status_pembayaran === 'menunggu_konfirmasi')
                                <div class="bg-orange-50 p-3 rounded-lg">
                                    <p class="text-sm text-orange-800">
                                        Bukti pembayaran Anda sedang dalam proses verifikasi admin.
                                    </p>
                                </div>
                            @endif
                            
                            @if($booking->status === 'pending')
                                <div class="bg-yellow-50 p-3 rounded-lg">
                                    <p class="text-sm text-yellow-800">
                                        Booking Anda menunggu persetujuan admin.
                                    </p>
                                </div>
                            @endif
                            
                            <a href="{{ route('user.booking.history') }}" 
                                class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-center block">
                                Kembali ke History
                            </a>
                            
                            <a href="{{ route('user.pdf.booking-kolam-detail', $booking) }}" 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-center block">
                                📄 Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html> 