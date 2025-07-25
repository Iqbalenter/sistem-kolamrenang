@extends('admin.layouts.app')

@section('title', 'Detail Booking Sewa Alat #' . $bookingSewaAlat->id)
@section('page-title', 'Detail Booking Sewa Alat #' . $bookingSewaAlat->id)
@section('page-description', 'Kelola dan konfirmasi booking sewa alat')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Detail Booking Sewa Alat #{{ $bookingSewaAlat->id }}</h1>
            <a href="{{ route('admin.booking-sewa-alat.index') }}" class="text-indigo-600 hover:text-indigo-800">
                ← Kembali ke Daftar Booking
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
                <div class="flex justify-between">
                    <span class="text-gray-600">User ID:</span>
                    <span class="font-medium">{{ $bookingSewaAlat->user->name ?? 'N/A' }} (#{{ $bookingSewaAlat->user_id }})</span>
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
                    <span class="text-gray-600">Waktu:</span>
                    <span class="font-medium">{{ $bookingSewaAlat->jam_mulai->format('H:i') }} - {{ $bookingSewaAlat->jam_selesai->format('H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Durasi:</span>
                    <span class="font-medium">{{ $bookingSewaAlat->durasi }} jam</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah Alat:</span>
                    <span class="font-medium">{{ $bookingSewaAlat->jumlah_alat }} unit</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Harga per Item:</span>
                    <span class="font-medium">Rp {{ number_format($bookingSewaAlat->harga_per_item, 0, ',', '.') }}/jam</span>
                </div>
                <div class="flex justify-between text-lg font-semibold">
                    <span>Total Harga:</span>
                    <span class="text-indigo-600">Rp {{ number_format($bookingSewaAlat->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($bookingSewaAlat->keterangan)
                <div class="mt-4 pt-4 border-t">
                    <span class="text-gray-600 block mb-1">Keterangan:</span>
                    <p class="text-gray-900">{{ $bookingSewaAlat->keterangan }}</p>
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
                    @if($bookingSewaAlat->tanggal_bayar)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Bayar:</span>
                            <span class="font-medium">{{ $bookingSewaAlat->tanggal_bayar->format('d F Y H:i') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Bukti Pembayaran -->
                @if($bookingSewaAlat->bukti_pembayaran)
                    <div class="mt-4">
                        <span class="text-gray-600 block mb-2">Bukti Pembayaran:</span>
                        <img src="{{ Storage::url($bookingSewaAlat->bukti_pembayaran) }}" 
                             alt="Bukti Pembayaran" 
                             class="max-w-full h-auto rounded-lg border cursor-pointer"
                             onclick="openImageModal('{{ Storage::url($bookingSewaAlat->bukti_pembayaran) }}')">
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

    <!-- Actions -->
    @if($bookingSewaAlat->status_pembayaran === 'menunggu_konfirmasi')
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Tindakan Admin</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Approve Payment -->
                <form action="{{ route('admin.booking-sewa-alat.approve-payment', $bookingSewaAlat) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Setujui Pembayaran</label>
                        <textarea name="catatan_admin" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                  placeholder="Catatan untuk persetujuan (opsional)"></textarea>
                    </div>
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Setujui Pembayaran
                    </button>
                </form>

                <!-- Reject Payment -->
                <form action="{{ route('admin.booking-sewa-alat.reject-payment', $bookingSewaAlat) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tolak Pembayaran</label>
                        <textarea name="catatan_admin" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                  placeholder="Alasan penolakan (wajib)" required></textarea>
                    </div>
                    <button type="submit" 
                            class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                            onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                        Tolak Pembayaran
                    </button>
                </form>
            </div>
        </div>
    @endif

    @if($bookingSewaAlat->status_pembayaran === 'lunas' && $bookingSewaAlat->status === 'menunggu_konfirmasi')
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Konfirmasi Booking</h2>
            
            <form action="{{ route('admin.booking-sewa-alat.confirm', $bookingSewaAlat) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                    <textarea name="catatan_admin" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              placeholder="Catatan untuk konfirmasi (opsional)">{{ $bookingSewaAlat->catatan_admin }}</textarea>
                </div>
                <button type="submit" 
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Konfirmasi Booking
                </button>
            </form>
        </div>
    @endif
</div>

<!-- Modal untuk melihat gambar -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="max-w-4xl max-h-full relative">
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-full rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        document.getElementById('modalImage').src = imageSrc;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
</script>
@endsection
