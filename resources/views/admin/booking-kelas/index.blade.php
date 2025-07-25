@extends('admin.layouts.app')

@section('title', 'Kelola Booking Kelas')
@section('page-title', 'Kelola Booking Kelas')
@section('page-description', 'Manajemen semua booking kelas renang')

@section('content')
@php
    $pendingCount = $bookings->where('status', 'pending')->count();
    $approvedCount = $bookings->where('status', 'approved')->count();
    $belumBayarCount = $bookings->where('status_pembayaran', 'belum_bayar')->count();
    $menungguKonfirmasiCount = $bookings->where('status_pembayaran', 'menunggu_konfirmasi')->count();
@endphp

<!-- Filter Tabs -->
<div class="bg-white rounded-xl shadow-lg mb-4 sm:mb-6">
    <div class="border-b border-gray-200">
        <!-- Mobile: Dropdown Navigation -->
        <div class="sm:hidden">
            <select onchange="window.location.href = this.value" class="block w-full px-4 py-3 text-sm font-medium text-gray-700 bg-white border-0 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="{{ route('admin.booking-kelas.index') }}" {{ !request('status') && !request('payment') ? 'selected' : '' }}>
                    Semua Booking ({{ $bookings->count() }})
                </option>
                <option value="{{ route('admin.booking-kelas.index', ['status' => 'pending']) }}" {{ request('status') === 'pending' ? 'selected' : '' }}>
                    Pending ({{ $pendingCount }})
                </option>
                <option value="{{ route('admin.booking-kelas.index', ['status' => 'approved']) }}" {{ request('status') === 'approved' ? 'selected' : '' }}>
                    Approved ({{ $approvedCount }})
                </option>
                <option value="{{ route('admin.booking-kelas.index', ['payment' => 'belum_bayar']) }}" {{ request('payment') === 'belum_bayar' ? 'selected' : '' }}>
                    Belum Bayar ({{ $belumBayarCount }})
                </option>
                <option value="{{ route('admin.booking-kelas.index', ['payment' => 'menunggu_konfirmasi']) }}" {{ request('payment') === 'menunggu_konfirmasi' ? 'selected' : '' }}>
                    Menunggu Konfirmasi ({{ $menungguKonfirmasiCount }})
                </option>
            </select>
        </div>
        
        <!-- Desktop: Tab Navigation -->
        <nav class="hidden sm:flex sm:space-x-4 lg:space-x-8 px-4 sm:px-6 overflow-x-auto" aria-label="Tabs">
            <a href="{{ route('admin.booking-kelas.index') }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ !request('status') ? 'border-blue-500 text-blue-600' : '' }}">
                <i class="fas fa-swimming-pool mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Semua Booking</span>
                <span class="sm:ml-2 bg-gray-100 text-gray-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $bookings->count() }}</span>
            </a>
            <a href="{{ route('admin.booking-kelas.index', ['status' => 'pending']) }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ request('status') === 'pending' ? 'border-yellow-500 text-yellow-600' : '' }}">
                <i class="fas fa-clock mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Pending</span>
                <span class="sm:ml-2 bg-yellow-100 text-yellow-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $pendingCount }}</span>
            </a>
            <a href="{{ route('admin.booking-kelas.index', ['status' => 'approved']) }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ request('status') === 'approved' ? 'border-green-500 text-green-600' : '' }}">
                <i class="fas fa-check-circle mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Approved</span>
                <span class="sm:ml-2 bg-green-100 text-green-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $approvedCount }}</span>
            </a>
            <a href="{{ route('admin.booking-kelas.index', ['payment' => 'belum_bayar']) }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ request('payment') === 'belum_bayar' ? 'border-red-500 text-red-600' : '' }}">
                <i class="fas fa-exclamation-circle mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Belum Bayar</span>
                <span class="sm:ml-2 bg-red-100 text-red-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $belumBayarCount }}</span>
            </a>
            <a href="{{ route('admin.booking-kelas.index', ['payment' => 'menunggu_konfirmasi']) }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ request('payment') === 'menunggu_konfirmasi' ? 'border-orange-500 text-orange-600' : '' }}">
                <i class="fas fa-hourglass-half mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Menunggu Konfirmasi</span>
                <span class="sm:ml-2 bg-orange-100 text-orange-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $menungguKonfirmasiCount }}</span>
            </a>
        </nav>
    </div>
</div>

<!-- Booking List -->
@if($bookings->count() > 0)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                <i class="fas fa-swimming-pool mr-2 text-blue-500"></i>
                Daftar Booking Kelas
            </h3>
        </div>
        
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID & Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas & Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">#{{ $booking->id }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->nama_pemesan }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->nomor_telepon }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->jenis_kelas_label }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->tanggal_kelas->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->jam_mulai->format('H:i') }} - {{ $booking->jam_selesai->format('H:i') }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->jumlah_peserta }} peserta</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800', 
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'completed' => 'bg-blue-100 text-blue-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    @if($booking->status === 'pending')
                                        <i class="fas fa-clock mr-1"></i>
                                    @elseif($booking->status === 'approved')
                                        <i class="fas fa-check mr-1"></i>
                                    @elseif($booking->status === 'rejected')
                                        <i class="fas fa-times mr-1"></i>
                                    @elseif($booking->status === 'completed')
                                        <i class="fas fa-check-circle mr-1"></i>
                                    @endif
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $paymentColors = [
                                        'belum_bayar' => 'bg-gray-100 text-gray-800',
                                        'menunggu_konfirmasi' => 'bg-orange-100 text-orange-800', 
                                        'lunas' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentColors[$booking->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                    @if($booking->status_pembayaran === 'belum_bayar')
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                    @elseif($booking->status_pembayaran === 'menunggu_konfirmasi')
                                        <i class="fas fa-clock mr-1"></i>
                                    @elseif($booking->status_pembayaran === 'lunas')
                                        <i class="fas fa-check-circle mr-1"></i>
                                    @elseif($booking->status_pembayaran === 'ditolak')
                                        <i class="fas fa-times-circle mr-1"></i>
                                    @endif
                                    {{ $booking->status_pembayaran_label }}
                                </span>
                                <div class="text-xs text-gray-900 mt-1 font-medium">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </div>
                                @if($booking->metode_pembayaran)
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $booking->metode_pembayaran_label }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-col space-y-1">
                                    <a href="{{ route('admin.booking-kelas.show', $booking) }}" 
                                        class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-xs">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail
                                    </a>
                                    <button onclick="confirmDeleteBooking({{ $booking->id }}, '#{{ $booking->id }}')"
                                        class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-xs">
                                        <i class="fas fa-trash mr-1"></i>
                                        Hapus
                                    </button>
                                    
                                    @if($booking->status === 'pending')
                                        <button onclick="approveBooking({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-xs">
                                            <i class="fas fa-check mr-1"></i>
                                            Approve
                                        </button>
                                        <button onclick="showRejectModal({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-xs">
                                            <i class="fas fa-times mr-1"></i>
                                            Reject
                                        </button>
                                    @endif
                                    
                                    @if($booking->status_pembayaran === 'menunggu_konfirmasi')
                                        <button onclick="confirmPayment({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-xs">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Confirm
                                        </button>
                                        <button onclick="showRejectPaymentModal({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Reject
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Mobile View -->
        <div class="lg:hidden">
            @foreach($bookings as $booking)
                <div class="border-b border-gray-200 p-4 sm:p-6 hover:bg-gray-50">
                    <div class="flex items-start justify-between space-x-3">
                        <div class="flex items-start space-x-3 flex-1 min-w-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-xs">#{{ $booking->id }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="mb-2 sm:mb-0">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $booking->nama_pemesan }}</h4>
                                        <p class="text-xs text-gray-500">{{ $booking->user->email }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->nomor_telepon }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    <div>
                                        <span class="font-medium text-gray-500">Kelas:</span>
                                        <span class="text-gray-900">{{ $booking->jenis_kelas_label }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-500">Tanggal:</span>
                                        <span class="text-gray-900">{{ $booking->tanggal_kelas->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-500">Waktu:</span>
                                        <span class="text-gray-900">{{ $booking->jam_mulai->format('H:i') }} - {{ $booking->jam_selesai->format('H:i') }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-500">Peserta:</span>
                                        <span class="text-gray-900">{{ $booking->jumlah_peserta }} orang</span>
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex flex-wrap gap-2">
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
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $booking->status_label }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $paymentColors[$booking->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $booking->status_pembayaran_label }}
                                    </span>
                                </div>
                                
                                <div class="mt-3 flex flex-wrap gap-1">
                                    <a href="{{ route('admin.booking-kelas.show', $booking) }}" 
                                        class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs hover:bg-blue-200">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </a>
                                    <button onclick="confirmDeleteBooking({{ $booking->id }}, '#{{ $booking->id }}')"
                                        class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs hover:bg-gray-200">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                    
                                    @if($booking->status === 'pending')
                                        <button onclick="approveBooking({{ $booking->id }})"
                                            class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">
                                            <i class="fas fa-check mr-1"></i>Approve
                                        </button>
                                        <button onclick="showRejectModal({{ $booking->id }})"
                                            class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">
                                            <i class="fas fa-times mr-1"></i>Reject
                                        </button>
                                    @endif
                                    
                                    @if($booking->status_pembayaran === 'menunggu_konfirmasi')
                                        <button onclick="confirmPayment({{ $booking->id }})"
                                            class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">
                                            <i class="fas fa-check-circle mr-1"></i>Confirm
                                        </button>
                                        <button onclick="showRejectPaymentModal({{ $booking->id }})"
                                            class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">
                                            <i class="fas fa-times-circle mr-1"></i>Reject
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-sm font-medium text-gray-900">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </div>
                            @if($booking->metode_pembayaran)
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $booking->metode_pembayaran_label }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-lg p-8 sm:p-12 text-center">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-swimming-pool text-4xl sm:text-5xl"></i>
        </div>
        <h3 class="text-lg sm:text-xl font-medium text-gray-900 mb-2">Belum Ada Booking Kelas</h3>
        <p class="text-gray-600">Belum ada booking kelas renang yang masuk.</p>
    </div>
@endif

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
                location.reload();
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
</script>

@endsection
