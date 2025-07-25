@extends('admin.layouts.app')

@section('title', 'Kelola Booking Sewa Alat')
@section('page-title', 'Kelola Booking Sewa Alat')
@section('page-description', 'Manajemen semua booking sewa alat renang')

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
                <option value="{{ route('admin.booking-sewa-alat.index') }}" {{ !request('status') && !request('payment') ? 'selected' : '' }}>
                    Semua Booking ({{ $bookings->count() }})
                </option>
                <option value="{{ route('admin.booking-sewa-alat.index', ['status' => 'pending']) }}" {{ request('status') === 'pending' ? 'selected' : '' }}>
                    Pending ({{ $pendingCount }})
                </option>
                <option value="{{ route('admin.booking-sewa-alat.index', ['status' => 'approved']) }}" {{ request('status') === 'approved' ? 'selected' : '' }}>
                    Approved ({{ $approvedCount }})
                </option>
                <option value="{{ route('admin.booking-sewa-alat.index', ['payment' => 'belum_bayar']) }}" {{ request('payment') === 'belum_bayar' ? 'selected' : '' }}>
                    Belum Bayar ({{ $belumBayarCount }})
                </option>
                <option value="{{ route('admin.booking-sewa-alat.index', ['payment' => 'menunggu_konfirmasi']) }}" {{ request('payment') === 'menunggu_konfirmasi' ? 'selected' : '' }}>
                    Menunggu Konfirmasi ({{ $menungguKonfirmasiCount }})
                </option>
            </select>
        </div>
        
        <!-- Desktop: Tab Navigation -->
        <nav class="hidden sm:flex sm:space-x-4 lg:space-x-8 px-4 sm:px-6 overflow-x-auto" aria-label="Tabs">
            <a href="{{ route('admin.booking-sewa-alat.index') }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ !request('status') ? 'border-blue-500 text-blue-600' : '' }}">
                <i class="fas fa-tools mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Semua Booking</span>
                <span class="sm:ml-2 bg-gray-100 text-gray-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $bookings->count() }}</span>
            </a>
            <a href="{{ route('admin.booking-sewa-alat.index', ['status' => 'pending']) }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ request('status') === 'pending' ? 'border-yellow-500 text-yellow-600' : '' }}">
                <i class="fas fa-clock mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Pending</span>
                <span class="sm:ml-2 bg-yellow-100 text-yellow-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $pendingCount }}</span>
            </a>
            <a href="{{ route('admin.booking-sewa-alat.index', ['status' => 'approved']) }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ request('status') === 'approved' ? 'border-green-500 text-green-600' : '' }}">
                <i class="fas fa-check-circle mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Approved</span>
                <span class="sm:ml-2 bg-green-100 text-green-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $approvedCount }}</span>
            </a>
            <a href="{{ route('admin.booking-sewa-alat.index', ['payment' => 'belum_bayar']) }}" 
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm flex-shrink-0
                      {{ request('payment') === 'belum_bayar' ? 'border-red-500 text-red-600' : '' }}">
                <i class="fas fa-exclamation-circle mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Belum Bayar</span>
                <span class="sm:ml-2 bg-red-100 text-red-900 py-0.5 px-1.5 sm:px-2.5 rounded-full text-xs font-medium">{{ $belumBayarCount }}</span>
            </a>
            <a href="{{ route('admin.booking-sewa-alat.index', ['payment' => 'menunggu_konfirmasi']) }}" 
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
                <i class="fas fa-tools mr-2 text-blue-500"></i>
                Daftar Booking Sewa Alat
            </h3>
        </div>
        
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID & Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat & Waktu</th>
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
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->nama_penyewa }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->nomor_telepon }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->jenis_alat_label }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->tanggal_sewa->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->jumlah_alat }} alat ({{ $booking->durasi }} jam)</div>
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
                                    <a href="{{ route('admin.booking-sewa-alat.show', $booking) }}" 
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
                                        <button onclick="approvePayment({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-xs">
                                            <i class="fas fa-check mr-1"></i>
                                            Approve Payment
                                        </button>
                                        <button onclick="showRejectPaymentModal({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-xs">
                                            <i class="fas fa-times mr-1"></i>
                                            Reject Payment
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
        <div class="md:hidden space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-lg shadow-md p-4 space-y-3">
                    <!-- Header -->
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-medium text-gray-900">Booking #{{ $booking->id }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->nama_penyewa }}</div>
                        </div>
                        <div class="flex space-x-2">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800', 
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'completed' => 'bg-blue-100 text-blue-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $booking->status_label }}
                            </span>
                        </div>
                    </div>

                    <!-- Equipment Info -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jenis Alat:</span>
                            <span class="font-medium">{{ $booking->jenis_alat_label }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tanggal:</span>
                            <span class="font-medium">{{ $booking->tanggal_sewa->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Waktu:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jumlah:</span>
                            <span class="font-medium">{{ $booking->jumlah_alat }} alat ({{ $booking->durasi }} jam)</span>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email:</span>
                            <span class="font-medium">{{ $booking->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Telepon:</span>
                            <span class="font-medium">{{ $booking->nomor_telepon }}</span>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="bg-gray-50 rounded-lg p-3 space-y-2">
                        @php
                            $paymentColors = [
                                'belum_bayar' => 'bg-gray-100 text-gray-800',
                                'menunggu_konfirmasi' => 'bg-orange-100 text-orange-800', 
                                'lunas' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Status Pembayaran:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $paymentColors[$booking->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $booking->status_pembayaran_label }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Total:</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                        @if($booking->metode_pembayaran)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Metode:</span>
                                <span class="text-sm font-medium">{{ $booking->metode_pembayaran_label }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2 pt-2">
                        <a href="{{ route('admin.booking-sewa-alat.show', $booking) }}" 
                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm">
                            <i class="fas fa-eye mr-1"></i>
                            Detail
                        </a>
                        <button onclick="confirmDeleteBooking({{ $booking->id }}, '#{{ $booking->id }}')"
                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                            <i class="fas fa-trash mr-1"></i>
                            Hapus
                        </button>
                        
                        @if($booking->status === 'pending')
                            <button onclick="approveBooking({{ $booking->id }})"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm">
                                <i class="fas fa-check mr-1"></i>
                                Approve
                            </button>
                            <button onclick="showRejectModal({{ $booking->id }})"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm">
                                <i class="fas fa-times mr-1"></i>
                                Reject
                            </button>
                        @endif
                        
                        @if($booking->status_pembayaran === 'menunggu_konfirmasi')
                            <button onclick="approvePayment({{ $booking->id }})"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm">
                                <i class="fas fa-check mr-1"></i>
                                Approve Payment
                            </button>
                            <button onclick="showRejectPaymentModal({{ $booking->id }})"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm">
                                <i class="fas fa-times mr-1"></i>
                                Reject Payment
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Booking Sewa Alat</h3>
                <p class="text-gray-600">Belum ada booking sewa alat renang yang masuk.</p>
            </div>
        @endif
    </div>
</div>

<!-- Reject Booking Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Booking</h3>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="alasan_penolakan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" 
                              rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Tolak Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
<div id="rejectPaymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pembayaran</h3>
            <form id="rejectPaymentForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="alasan_penolakan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" 
                              rows="3" placeholder="Masukkan alasan penolakan pembayaran..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectPaymentModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Tolak Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabSelect = document.getElementById('tab-select');
    const bookingRows = document.querySelectorAll('.booking-row');

    function filterBookings(activeTab) {
        bookingRows.forEach(row => {
            const status = row.dataset.status;
            const payment = row.dataset.payment;
            
            switch(activeTab) {
                case 'all':
                    row.style.display = '';
                    break;
                case 'pending':
                    row.style.display = status === 'pending' ? '' : 'none';
                    break;
                case 'approved':
                    row.style.display = status === 'approved' ? '' : 'none';
                    break;
                case 'completed':
                    row.style.display = status === 'completed' ? '' : 'none';
                    break;
                case 'rejected':
                    row.style.display = status === 'rejected' ? '' : 'none';
                    break;
                case 'payment-waiting':
                    row.style.display = payment === 'menunggu_konfirmasi' ? '' : 'none';
                    break;
                case 'payment-confirmed':
                    row.style.display = payment === 'lunas' ? '' : 'none';
                    break;
                case 'payment-rejected':
                    row.style.display = payment === 'ditolak' ? '' : 'none';
                    break;
                default:
                    row.style.display = '';
            }
        });
    }

    // Desktop tab buttons
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const activeTab = this.dataset.tab;
            
            // Update button styles
            tabButtons.forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600');
                btn.classList.add('text-gray-500');
            });
            this.classList.add('border-blue-500', 'text-blue-600');
            this.classList.remove('text-gray-500');
            
            // Filter bookings
            filterBookings(activeTab);
        });
    });

    // Mobile tab select
    if (tabSelect) {
        tabSelect.addEventListener('change', function() {
            filterBookings(this.value);
        });
    }
});

// Booking actions
function approveBooking(bookingId) {
    if (confirm('Apakah Anda yakin ingin menyetujui booking ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.booking-sewa-alat.index') }}/${bookingId}/approve`;
        
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

function showRejectModal(bookingId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `{{ route('admin.booking-sewa-alat.index') }}/${bookingId}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
}

function confirmPayment(bookingId) {
    if (confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.booking-sewa-alat.index') }}/${bookingId}/confirm-payment`;
        
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

function showRejectPaymentModal(bookingId) {
    const modal = document.getElementById('rejectPaymentModal');
    const form = document.getElementById('rejectPaymentForm');
    form.action = `{{ route('admin.booking-sewa-alat.index') }}/${bookingId}/reject-payment`;
    modal.classList.remove('hidden');
}

function closeRejectPaymentModal() {
    const modal = document.getElementById('rejectPaymentModal');
    modal.classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const rejectModal = document.getElementById('rejectModal');
    const rejectPaymentModal = document.getElementById('rejectPaymentModal');
    
    if (event.target === rejectModal) {
        closeRejectModal();
    }
    if (event.target === rejectPaymentModal) {
        closeRejectPaymentModal();
    }
}
</script>
@endsection
