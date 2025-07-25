@extends('admin.layouts.app')

@section('title', 'Detail Booking Kelas #' . $bookingKelas->id)
@section('page-title', 'Detail Booking Kelas #' . $bookingKelas->id)
@section('page-description', 'Detail lengkap booking kelas renang')

@section('content')
<div class="min-h-screen py-6 sm:py-12 px-3 sm:px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Booking Kelas #{{ $bookingKelas->id }}</h1>
                <a href="{{ route('admin.booking-kelas.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm sm:text-base">
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
                        
                        <span class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium {{ $statusColors[$bookingKelas->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $bookingKelas->status_label }}
                        </span>
                        
                        <span class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium {{ $paymentColors[$bookingKelas->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $bookingKelas->status_pembayaran_label }}
                        </span>
                    </div>
                    
                    <!-- Timeline -->
                    <div class="border-l-2 border-gray-200 ml-2 sm:ml-4 pl-3 sm:pl-4 space-y-3 sm:space-y-4">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <div class="w-2 h-2 sm:w-3 sm:h-3 bg-blue-500 rounded-full"></div>
                            <div>
                                <p class="text-xs sm:text-sm font-medium">Booking dibuat</p>
                                <p class="text-xs text-gray-500">{{ $bookingKelas->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($bookingKelas->approved_at)
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-2 h-2 sm:w-3 sm:h-3 bg-green-500 rounded-full"></div>
                                <div>
                                    <p class="text-xs sm:text-sm font-medium">Booking disetujui</p>
                                    <p class="text-xs text-gray-500">{{ $bookingKelas->approved_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($bookingKelas->rejected_at)
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-2 h-2 sm:w-3 sm:h-3 bg-red-500 rounded-full"></div>
                                <div>
                                    <p class="text-xs sm:text-sm font-medium">Booking ditolak</p>
                                    <p class="text-xs text-gray-500">{{ $bookingKelas->rejected_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Customer & Booking Details -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Detail Booking</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Customer Information -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">Informasi Customer</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">User Account:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->user->name ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">Email:</dt>
                                    <dd class="text-xs sm:text-sm font-medium break-all">{{ $bookingKelas->user->email }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">Telepon:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->nomor_telepon }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">Nama Peserta:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->nama_pemesan }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Booking Information -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">Detail Kelas</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">Jenis Kelas:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->jenis_kelas_label }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">Tanggal:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->tanggal_kelas->format('d F Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">Waktu:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->jam_mulai->format('H:i') }} - {{ $bookingKelas->jam_selesai->format('H:i') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">Instruktur:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->instruktur }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-xs sm:text-sm text-gray-500">Jumlah Peserta:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->jumlah_peserta }} orang</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    
                    @if($bookingKelas->catatan)
                        <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Catatan dari Customer:</h4>
                            <p class="text-xs sm:text-sm text-gray-700">{{ $bookingKelas->catatan }}</p>
                        </div>
                    @endif

                    @if($bookingKelas->catatan_admin)
                        <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-yellow-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Catatan Admin:</h4>
                            <p class="text-xs sm:text-sm text-gray-700">{{ $bookingKelas->catatan_admin }}</p>
                        </div>
                    @endif
                </div>

                <!-- Payment Information -->
                @if($bookingKelas->metode_pembayaran || $bookingKelas->bukti_pembayaran)
                    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Informasi Pembayaran</h3>
                        
                        @if($bookingKelas->metode_pembayaran)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <dt class="text-xs sm:text-sm text-gray-500">Metode Pembayaran:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->metode_pembayaran_label }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs sm:text-sm text-gray-500">Provider:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->provider_pembayaran }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs sm:text-sm text-gray-500">Nomor Tujuan:</dt>
                                    <dd class="text-xs sm:text-sm font-medium">{{ $bookingKelas->nomor_tujuan }}</dd>
                                </div>
                            </div>
                        @endif
                        
                        @if($bookingKelas->bukti_pembayaran)
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Bukti Pembayaran:</h4>
                                <img src="{{ Storage::url($bookingKelas->bukti_pembayaran) }}" 
                                     alt="Bukti Pembayaran" 
                                     class="max-w-full h-auto max-h-96 rounded-lg border cursor-pointer"
                                     onclick="openImageModal(this.src)">
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-4 sm:space-y-6">
                <!-- Price Summary -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Ringkasan Harga</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600">Harga per orang:</span>
                            <span class="font-medium">Rp {{ number_format($bookingKelas->harga_per_orang, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600">Jumlah peserta:</span>
                            <span class="font-medium">{{ $bookingKelas->jumlah_peserta }} orang</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between text-sm sm:text-base font-semibold">
                            <span>Total:</span>
                            <span class="text-green-600">Rp {{ number_format($bookingKelas->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Aksi</h3>
                    <div class="space-y-2 sm:space-y-3">
                        @if($bookingKelas->status === 'pending')
                            <button onclick="approveBooking({{ $bookingKelas->id }})"
                                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 text-xs sm:text-sm">
                                <i class="fas fa-check mr-2"></i>Setujui Booking
                            </button>
                            <button onclick="showRejectModal({{ $bookingKelas->id }})"
                                class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 text-xs sm:text-sm">
                                <i class="fas fa-times mr-2"></i>Tolak Booking
                            </button>
                        @endif

                        @if($bookingKelas->status_pembayaran === 'menunggu_konfirmasi')
                            <button onclick="confirmPayment({{ $bookingKelas->id }})"
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 text-xs sm:text-sm">
                                <i class="fas fa-check-circle mr-2"></i>Konfirmasi Pembayaran
                            </button>
                            <button onclick="showRejectPaymentModal({{ $bookingKelas->id }})"
                                class="w-full bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 text-xs sm:text-sm">
                                <i class="fas fa-times-circle mr-2"></i>Tolak Pembayaran
                            </button>
                        @endif

                        <button onclick="confirmDeleteBooking({{ $bookingKelas->id }}, '#{{ $bookingKelas->id }}')"
                            class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 text-xs sm:text-sm">
                            <i class="fas fa-trash mr-2"></i>Hapus Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Reject Booking -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Booking</h3>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan penolakan:</label>
                    <textarea name="catatan_admin" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="3"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Tolak Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Reject Payment -->
<div id="rejectPaymentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pembayaran</h3>
            <form id="rejectPaymentForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan penolakan pembayaran:</label>
                    <textarea name="catatan_admin" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="3"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectPaymentModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Tolak Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Image -->
<div id="imageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50" onclick="closeImageModal()">
    <div class="relative top-10 mx-auto p-5 w-11/12 max-w-4xl">
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="w-full h-auto rounded-lg">
    </div>
</div>

<script>
function approveBooking(id) {
    if (confirm('Apakah Anda yakin ingin menyetujui booking ini?')) {
        fetch(`/admin/booking-kelas/${id}/approve`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}

function confirmDeleteBooking(id, identifier) {
    if (confirm(`Apakah Anda yakin ingin menghapus booking ${identifier}?`)) {
        fetch(`/admin/booking-kelas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        }).then(response => {
            if (response.ok) {
                window.location.href = '/admin/booking-kelas';
            }
        });
    }
}

function showRejectModal(id) {
    document.getElementById('rejectForm').action = `/admin/booking-kelas/${id}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

function confirmPayment(id) {
    if (confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')) {
        fetch(`/admin/booking-kelas/${id}/approve-payment`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}

function showRejectPaymentModal(id) {
    document.getElementById('rejectPaymentForm').action = `/admin/booking-kelas/${id}/reject-payment`;
    document.getElementById('rejectPaymentModal').classList.remove('hidden');
}

function closeRejectPaymentModal() {
    document.getElementById('rejectPaymentModal').classList.add('hidden');
}

function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>

@endsection
