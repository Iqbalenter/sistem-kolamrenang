<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Booking Kelas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')
    
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">History Booking Kelas Renang</h1>
                    <div class="space-x-4">
                        <a href="{{ route('user.booking.kelas.create') }}" 
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            + Buat Booking Kelas Baru
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
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            @if($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status == 'approved') bg-green-100 text-green-800
                                            @elseif($booking->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            {{ $booking->status_label }}
                                        </span>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            @if($booking->status_pembayaran == 'belum_bayar') bg-gray-100 text-gray-800
                                            @elseif($booking->status_pembayaran == 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status_pembayaran == 'lunas') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $booking->status_pembayaran_label }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Nama Pemesan:</span>
                                            <p class="font-medium">{{ $booking->nama_pemesan }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Jenis Kelas:</span>
                                            <p class="font-medium">{{ $booking->jenis_kelas_label }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Tanggal Kelas:</span>
                                            <p class="font-medium">{{ $booking->tanggal_kelas->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Waktu:</span>
                                            <p class="font-medium">{{ $booking->jam_mulai->format('H:i') }} - {{ $booking->jam_selesai->format('H:i') }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Instruktur:</span>
                                            <p class="font-medium">{{ $booking->instruktur }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Jumlah Peserta:</span>
                                            <p class="font-medium">{{ $booking->jumlah_peserta }} orang</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Total Harga:</span>
                                            <p class="font-medium text-indigo-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Dibuat:</span>
                                            <p class="font-medium">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>

                                    @if($booking->catatan)
                                        <div class="mt-4 p-3 bg-gray-50 rounded-md">
                                            <span class="text-gray-600 text-sm">Catatan:</span>
                                            <p class="text-gray-800">{{ $booking->catatan }}</p>
                                        </div>
                                    @endif

                                    @if($booking->catatan_admin)
                                        <div class="mt-4 p-3 bg-red-50 rounded-md">
                                            <span class="text-red-600 text-sm font-medium">Catatan Admin:</span>
                                            <p class="text-red-800">{{ $booking->catatan_admin }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-6 flex flex-col space-y-2">
                                    <a href="{{ route('user.booking.kelas.show', $booking) }}" 
                                       class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-center text-sm">
                                        Detail
                                    </a>
                                    
                                    @if($booking->status == 'approved' && $booking->status_pembayaran == 'belum_bayar')
                                        <a href="{{ route('user.booking.kelas.payment', $booking) }}" 
                                           class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-center text-sm">
                                            Bayar
                                        </a>
                                    @endif
                                    
                                    @if($booking->status == 'approved' && $booking->status_pembayaran == 'ditolak')
                                        <a href="{{ route('user.booking.kelas.payment', $booking) }}" 
                                           class="bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700 text-center text-sm">
                                            Bayar Ulang
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($bookings instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-6">
                        {{ $bookings->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Booking Kelas</h3>
                    <p class="text-gray-600 mb-6">Anda belum memiliki booking kelas renang. Mulai buat booking pertama Anda!</p>
                    <a href="{{ route('user.booking.kelas.create') }}" 
                       class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700">
                        Buat Booking Kelas Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
