<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking Kelas #{{ $bookingKelas->id }} - Sistem Kolam Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.user-navbar')

    <div class="min-h-screen py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Detail Booking Kelas #{{ $bookingKelas->id }}</h1>
                    <a href="{{ route('user.booking.kelas.history') }}" class="text-indigo-600 hover:text-indigo-800">
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
                            <span class="font-medium">#{{ $bookingKelas->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Booking:</span>
                            <span class="font-medium">{{ $bookingKelas->created_at->format('d F Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status Booking:</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $bookingKelas->status_color }}">
                                {{ $bookingKelas->status_label }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status Pembayaran:</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $bookingKelas->status_pembayaran_color }}">
                                {{ $bookingKelas->status_pembayaran_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Peserta -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Peserta</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Peserta:</span>
                            <span class="font-medium">{{ $bookingKelas->nama_peserta }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Umur:</span>
                            <span class="font-medium">{{ $bookingKelas->umur }} tahun</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Telepon:</span>
                            <span class="font-medium">{{ $bookingKelas->telepon }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium">{{ $bookingKelas->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Detail Kelas -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Kelas</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jenis Kelas:</span>
                            <span class="font-medium">{{ $bookingKelas->jenis_kelas_label }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Kelas:</span>
                            <span class="font-medium">{{ $bookingKelas->tanggal_kelas->format('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Waktu:</span>
                            <span class="font-medium">{{ $bookingKelas->jam_mulai->format('H:i') }} - {{ $bookingKelas->jam_selesai->format('H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Instruktur:</span>
                            <span class="font-medium">{{ $bookingKelas->instruktur ?: 'Belum ditentukan' }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total Harga:</span>
                            <span class="text-indigo-600">Rp {{ number_format($bookingKelas->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($bookingKelas->keterangan)
                        <div class="mt-4 pt-4 border-t">
                            <span class="text-gray-600 block mb-1">Keterangan:</span>
                            <p class="text-gray-900">{{ $bookingKelas->keterangan }}</p>
                        </div>
                    @endif
                </div>

                <!-- Informasi Pembayaran -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pembayaran</h2>
                    
                    @if($bookingKelas->metode_pembayaran)
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode Pembayaran:</span>
                                <span class="font-medium">{{ $bookingKelas->metode_pembayaran_label }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Provider:</span>
                                <span class="font-medium">{{ $bookingKelas->provider_pembayaran }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Tujuan:</span>
                                <span class="font-medium">{{ $bookingKelas->nomor_tujuan }}</span>
                            </div>
                            @if($bookingKelas->tanggal_bayar)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal Bayar:</span>
                                    <span class="font-medium">{{ $bookingKelas->tanggal_bayar->format('d F Y H:i') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Bukti Pembayaran -->
                        @if($bookingKelas->bukti_pembayaran)
                            <div class="mt-4">
                                <span class="text-gray-600 block mb-2">Bukti Pembayaran:</span>
                                <img src="{{ Storage::url($bookingKelas->bukti_pembayaran) }}" 
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
            @if($bookingKelas->catatan_admin)
                <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Catatan Admin</h2>
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-yellow-800">{{ $bookingKelas->catatan_admin }}</p>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Tindakan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($bookingKelas->canMakePayment())
                        @if($bookingKelas->canRetryPayment())
                            <a href="{{ route('user.booking.kelas.payment', $bookingKelas) }}" 
                               class="bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 text-center font-medium">
                                Upload Ulang Pembayaran
                            </a>
                        @else
                            <a href="{{ route('user.booking.kelas.payment', $bookingKelas) }}" 
                               class="bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 text-center font-medium">
                                Bayar Sekarang
                            </a>
                        @endif
                    @elseif($bookingKelas->status_pembayaran === 'ditolak')
                        <div class="bg-gray-100 text-gray-600 py-3 px-6 rounded-lg text-center font-medium">
                            Menunggu persetujuan booking untuk melakukan pembayaran ulang
                        </div>
                    @endif

                    @if($bookingKelas->status === 'menunggu_konfirmasi' || $bookingKelas->status_pembayaran === 'belum_bayar')
                        <form action="{{ route('user.booking.kelas.cancel', $bookingKelas) }}" method="POST" 
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

                @if($bookingKelas->status === 'dikonfirmasi')
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-800 font-medium">Booking Anda telah dikonfirmasi! Silakan datang sesuai jadwal.</p>
                        </div>
                    </div>
                @elseif($bookingKelas->status === 'dibatalkan')
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
