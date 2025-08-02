<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Booking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')
    
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">History Booking</h1>
                    <div class="space-x-4">
                        <a href="{{ route('user.booking.create') }}" 
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            + Buat Booking Baru
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
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

            <!-- Booking List -->
            @if($bookings->count() > 0)
                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Booking #{{ $booking->id }}
                                        </h3>
                                        
                                        <!-- Status Badge -->
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800', 
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'completed' => 'bg-blue-100 text-blue-800'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $booking->status_label }}
                                        </span>
                                        
                                        <!-- Payment Status Badge -->
                                        @php
                                            $paymentColors = [
                                                'belum_bayar' => 'bg-gray-100 text-gray-800',
                                                'menunggu_konfirmasi' => 'bg-orange-100 text-orange-800', 
                                                'lunas' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $paymentColors[$booking->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $booking->status_pembayaran_label }}
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                                            <p class="font-medium">{{ $booking->tanggal_booking->format('d M Y') }}</p>
                                            <p class="text-sm text-gray-600">{{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}</p>
                                        </div>
                                        
                                        <div>
                                            <p class="text-sm text-gray-500">Pemesan</p>
                                            <p class="font-medium">{{ $booking->nama_pemesan }}</p>
                                            <p class="text-sm text-gray-600">{{ $booking->nomor_telepon }}</p>
                                        </div>
                                        
                                        <div>
                                            <p class="text-sm text-gray-500">Harga Ticket</p>
                                            <p class="font-medium">{{ $booking->jenis_kolam_label ?? 'Ticket Utama' }}</p>
                                            <p class="text-sm text-gray-600">Rp {{ number_format($booking->tarif_per_jam ?? 25000, 0, ',', '.') }}/jam</p>
                                        </div>
                                        
                                        <div>
                                            <p class="text-sm text-gray-500">Jumlah Orang</p>
                                            <p class="font-medium">{{ $booking->jumlah_orang }} orang</p>
                                        </div>
                                        
                                        <div>
                                            <p class="text-sm text-gray-500">Total Harga</p>
                                            <p class="font-bold text-lg text-indigo-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($booking->catatan)
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-500">Catatan</p>
                                            <p class="text-gray-700">{{ $booking->catatan }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($booking->catatan_admin)
                                        @if($booking->status_pembayaran === 'ditolak')
                                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                                <p class="text-sm text-red-700 font-medium flex items-center">
                                                    <svg class="h-4 w-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 15c-.77.833.192 2.5 1.732 2.5z"/>
                                                    </svg>
                                                    Alasan Penolakan Pembayaran:
                                                </p>
                                                <p class="text-red-800 mt-1">{{ $booking->catatan_admin }}</p>
                                            </div>
                                        @else
                                            <div class="mb-4 p-3 bg-yellow-50 rounded-lg">
                                                <p class="text-sm text-yellow-700 font-medium">Catatan Admin:</p>
                                                <p class="text-yellow-800">{{ $booking->catatan_admin }}</p>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                
                                <div class="ml-6 flex flex-col space-y-2">
                                    <a href="{{ route('user.booking.show', $booking) }}" 
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        Lihat Detail
                                    </a>
                                    
                                    @if($booking->status === 'approved' && in_array($booking->status_pembayaran, ['belum_bayar', 'menunggu_konfirmasi', 'ditolak']))
                                        <a href="{{ route('user.booking.payment', $booking) }}" 
                                            class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            @if($booking->status_pembayaran === 'belum_bayar')
                                                Bayar Sekarang
                                            @elseif($booking->status_pembayaran === 'ditolak')
                                                Upload Ulang
                                            @else
                                                Lihat Pembayaran
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="mb-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada booking</h3>
                    <p class="text-gray-500 mb-6">Anda belum memiliki booking apapun. Mulai buat booking pertama Anda!</p>
                    <a href="{{ route('user.booking.create') }}" 
                        class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Buat Booking Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html> 