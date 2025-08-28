<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking Sewa Alat #{{ $bookingSewaAlat->id }} - Sistem Kolam Renang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')

    <div class="min-h-screen py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Detail Booking Sewa Alat #{{ $bookingSewaAlat->id }}</h1>
                    <a href="{{ route('user.booking.sewa-alat.history') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Riwayat
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Informasi Booking -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Booking</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Booking:</span>
                            <span class="font-medium">#{{ $bookingSewaAlat->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Booking:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->created_at->format('d F Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status Booking:</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $bookingSewaAlat->status_color }}">
                                {{ $bookingSewaAlat->status_label }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status Pembayaran:</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $bookingSewaAlat->status_pembayaran_color }}">
                                {{ $bookingSewaAlat->status_pembayaran_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Penyewa -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Penyewa</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Penyewa:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->nama_penyewa }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Telepon:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->telepon }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Detail Sewa Alat -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Sewa Alat</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jenis Alat:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->jenis_alat_label }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Sewa:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->tanggal_sewa->format('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jaminan:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->jenis_jaminan_label }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status Pengembalian:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->alat_dikembalikan ? 'Sudah Dikembalikan' : 'Belum Dikembalikan' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Alat:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->jumlah_alat }} unit</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga per Item:</span>
                            <span class="font-medium">Rp {{ number_format($bookingSewaAlat->harga_per_item, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total Harga:</span>
                            <span class="text-indigo-600">Rp {{ number_format($bookingSewaAlat->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($bookingSewaAlat->catatan)
                        <div class="mt-4 pt-4 border-t">
                            <span class="text-gray-600 block mb-1">Catatan:</span>
                            <p class="text-gray-900">{{ $bookingSewaAlat->catatan }}</p>
                        </div>
                    @endif
                </div>

                <!-- Informasi Pembayaran -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pembayaran</h2>
                    
                    @if($bookingSewaAlat->metode_pembayaran)
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode Pembayaran:</span>
                                <span class="font-medium">{{ $bookingSewaAlat->metode_pembayaran_label }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Provider:</span>
                                <span class="font-medium">{{ $bookingSewaAlat->provider_pembayaran }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Tujuan:</span>
                                <span class="font-medium">{{ $bookingSewaAlat->nomor_tujuan }}</span>
                            </div>

                        </div>

                        <!-- Bukti Pembayaran -->
                        @if($bookingSewaAlat->bukti_pembayaran)
                            <div class="mt-4">
                                <span class="text-gray-600 block mb-2">Bukti Pembayaran:</span>
                                <img src="{{ Storage::url($bookingSewaAlat->bukti_pembayaran) }}" 
                                     alt="Bukti Pembayaran" 
                                     class="max-w-full h-auto rounded-lg border">
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 italic">Belum ada informasi pembayaran</p>
                    @endif
                </div>
            </div>

            <!-- Catatan Admin -->
            @if($bookingSewaAlat->catatan_admin)
                <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Catatan Admin</h2>
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-yellow-800">{{ $bookingSewaAlat->catatan_admin }}</p>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Tindakan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($bookingSewaAlat->canMakePayment())
                        @if($bookingSewaAlat->canRetryPayment())
                            <a href="{{ route('user.booking.sewa-alat.payment', $bookingSewaAlat) }}" 
                               class="bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 text-center font-medium">
                                Upload Ulang Pembayaran
                            </a>
                        @else
                            <a href="{{ route('user.booking.sewa-alat.payment', $bookingSewaAlat) }}" 
                               class="bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 text-center font-medium">
                                Bayar Sekarang
                            </a>
                        @endif
                    @elseif($bookingSewaAlat->status === 'pending')
                        <div class="bg-yellow-100 text-yellow-800 py-3 px-6 rounded-lg text-center font-medium">
                            <i class="fas fa-clock mr-2"></i>
                            Menunggu persetujuan admin untuk melakukan pembayaran
                        </div>
                    @elseif($bookingSewaAlat->status_pembayaran === 'menunggu_konfirmasi')
                        <div class="bg-blue-100 text-blue-800 py-3 px-6 rounded-lg text-center font-medium">
                            <i class="fas fa-hourglass-half mr-2"></i>
                            Pembayaran sedang diverifikasi admin
                        </div>
                    @elseif($bookingSewaAlat->status_pembayaran === 'lunas')
                        <div class="bg-green-100 text-green-800 py-3 px-6 rounded-lg text-center font-medium">
                            <i class="fas fa-check-circle mr-2"></i>
                            Pembayaran telah lunas
                        </div>
                    @elseif($bookingSewaAlat->status_pembayaran === 'ditolak')
                        <div class="bg-red-100 text-red-800 py-3 px-6 rounded-lg text-center font-medium">
                            <i class="fas fa-times-circle mr-2"></i>
                            Pembayaran ditolak. Menunggu persetujuan booking untuk pembayaran ulang
                        </div>
                    @else
                        <div class="bg-gray-100 text-gray-600 py-3 px-6 rounded-lg text-center font-medium">
                            <i class="fas fa-info-circle mr-2"></i>
                            Status: {{ $bookingSewaAlat->status_label }} - {{ $bookingSewaAlat->status_pembayaran_label }}
                        </div>
                    @endif

                    @if($bookingSewaAlat->status === 'pending' || $bookingSewaAlat->status_pembayaran === 'belum_bayar')
                        <form action="{{ route('user.booking.sewa-alat.cancel', $bookingSewaAlat) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 font-medium">
                                Batalkan Booking
                            </button>
                        </form>
                    @endif
                </div>

                <div class="mt-4">
                    <a href="{{ route('user.pdf.booking-sewa-alat-detail', $bookingSewaAlat) }}" 
                       class="bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 text-center font-medium block">
                        📄 Export PDF
                    </a>
                </div>

                @if($bookingSewaAlat->status === 'dikonfirmasi')
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-800 font-medium">Booking Anda telah dikonfirmasi! Silakan datang sesuai jadwal untuk mengambil alat.</p>
                        </div>
                    </div>
                @elseif($bookingSewaAlat->status === 'dibatalkan')
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-red-800 font-medium">Booking ini telah dibatalkan.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
