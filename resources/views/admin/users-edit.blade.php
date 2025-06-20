@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-description', 'Mengubah data user terdaftar')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Form Edit User -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                <i class="fas fa-user-edit mr-2 text-blue-500"></i>
                Edit Data User
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">
                Perbarui informasi user yang terdaftar
            </p>
        </div>
        
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-4 sm:p-6">
            @csrf
            @method('PUT')
            
            <!-- User ID (Read Only) -->
            <div class="mb-4 sm:mb-6">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                    <i class="fas fa-id-badge mr-2 text-gray-400"></i>
                    User ID
                </label>
                <div class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 text-sm sm:text-base">
                    #{{ $user->id }}
                </div>
            </div>
            
            <!-- Grid untuk form fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Nama -->
                <div class="md:col-span-1">
                    <label for="name" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                        <i class="fas fa-user mr-2 text-gray-400"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap"
                           required>
                    @error('name')
                        <p class="mt-1 text-xs sm:text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div class="md:col-span-1">
                    <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                        Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base @error('email') border-red-500 @enderror"
                           placeholder="Masukkan alamat email"
                           required>
                    @error('email')
                        <p class="mt-1 text-xs sm:text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Role (Read Only) -->
                <div class="md:col-span-1">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                        <i class="fas fa-user-tag mr-2 text-gray-400"></i>
                        Role
                    </label>
                    <div class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                        <span class="inline-flex items-center px-2 sm:px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-user mr-1"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
                
                <!-- Tanggal Daftar (Read Only) -->
                <div class="md:col-span-1">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                        Tanggal Daftar
                    </label>
                    <div class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 text-xs sm:text-sm">
                        <div>{{ $user->created_at->format('d M Y H:i') }}</div>
                        <div class="text-xs text-gray-500">({{ $user->created_at->diffForHumans() }})</div>
                    </div>
                </div>
            </div>
            
            <!-- Total Booking (Read Only) -->
            <div class="mt-4 sm:mt-6 mb-6 sm:mb-8">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                    <i class="fas fa-calendar-check mr-2 text-gray-400"></i>
                    Total Booking
                </label>
                <div class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-lg sm:text-xl font-bold text-blue-600">{{ $user->bookings()->count() }}</span>
                        <span class="text-xs sm:text-sm text-gray-500 ml-2">booking</span>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 sm:pt-6 border-t border-gray-200 space-y-3 sm:space-y-0">
                <a href="{{ route('admin.users') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm sm:text-base">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                
                <button type="submit" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm sm:text-base">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    
    <!-- User Bookings Summary -->
    @if($user->bookings()->count() > 0)
    <div class="mt-6 sm:mt-8 bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                <i class="fas fa-history mr-2 text-green-500"></i>
                Riwayat Booking
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">
                {{ $user->bookings()->count() }} booking ditemukan
            </p>
        </div>
        
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <div class="bg-yellow-50 p-3 sm:p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                            <i class="fas fa-clock text-white text-xs sm:text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600">Pending</p>
                            <p class="text-lg sm:text-xl font-bold text-yellow-600">{{ $user->bookings()->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-3 sm:p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-green-500 rounded-full flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-xs sm:text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600">Approved</p>
                            <p class="text-lg sm:text-xl font-bold text-green-600">{{ $user->bookings()->where('status', 'approved')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-blue-50 p-3 sm:p-4 rounded-lg sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-500 rounded-full flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                            <i class="fas fa-check-circle text-white text-xs sm:text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600">Completed</p>
                            <p class="text-lg sm:text-xl font-bold text-blue-600">{{ $user->bookings()->where('status', 'completed')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 