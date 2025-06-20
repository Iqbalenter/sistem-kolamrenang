@extends('admin.layouts.app')

@section('title', 'Profile Admin')
@section('page-title', 'Profile Admin')
@section('page-description', 'Kelola informasi profile administrator')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
    <!-- Profile Card -->
    <div class="lg:col-span-1 order-2 lg:order-1">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-4 sm:px-6 py-6 sm:py-8 text-center bg-gradient-to-r from-blue-500 to-purple-600">
                <div class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <span class="text-xl sm:text-2xl lg:text-3xl font-bold text-blue-600">{{ substr($admin->name, 0, 1) }}</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-white">{{ $admin->name }}</h3>
                <p class="text-sm sm:text-base text-blue-100">Administrator</p>
                <div class="mt-3 sm:mt-4 inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-white text-blue-600">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Admin Access
                </div>
            </div>
            <div class="px-4 sm:px-6 py-3 sm:py-4">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center text-xs sm:text-sm">
                        <i class="fas fa-envelope w-4 h-4 sm:w-5 sm:h-5 text-gray-400 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-gray-600 break-all">{{ $admin->email }}</span>
                    </div>
                    <div class="flex items-center text-xs sm:text-sm">
                        <i class="fas fa-calendar-alt w-4 h-4 sm:w-5 sm:h-5 text-gray-400 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-gray-600">Bergabung {{ $admin->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center text-xs sm:text-sm">
                        <i class="fas fa-clock w-4 h-4 sm:w-5 sm:h-5 text-gray-400 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-gray-600">Login terakhir {{ $admin->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="mt-4 sm:mt-6 bg-white shadow-lg rounded-xl p-4 sm:p-6">
            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">
                <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                Statistik Admin
            </h4>
            <div class="space-y-3 sm:space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs sm:text-sm text-gray-600">Total User</span>
                    <span class="font-bold text-blue-600 text-sm sm:text-base">{{ \App\Models\User::where('role', 'user')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs sm:text-sm text-gray-600">Total Booking</span>
                    <span class="font-bold text-green-600 text-sm sm:text-base">{{ \App\Models\Booking::count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs sm:text-sm text-gray-600">Pending Approval</span>
                    <span class="font-bold text-yellow-600 text-sm sm:text-base">{{ \App\Models\Booking::where('status', 'pending')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs sm:text-sm text-gray-600">Revenue Bulan Ini</span>
                    <span class="font-bold text-purple-600 text-xs sm:text-sm break-all">Rp {{ number_format(\App\Models\Booking::where('status_pembayaran', 'lunas')->whereMonth('created_at', now()->month)->sum('total_harga'), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="lg:col-span-2 order-1 lg:order-2">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                    <i class="fas fa-user-edit mr-2 text-blue-500"></i>
                    Informasi Profile
                </h3>
            </div>
            <form class="p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="name" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ $admin->name }}"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base"
                               readonly>
                    </div>
                    <div>
                        <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ $admin->email }}"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base"
                               readonly>
                    </div>
                    <div>
                        <label for="role" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Role
                        </label>
                        <input type="text" 
                               id="role" 
                               name="role" 
                               value="{{ ucfirst($admin->role) }}"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg bg-gray-100 text-sm sm:text-base"
                               readonly>
                    </div>
                    <div>
                        <label for="created_at" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Tanggal Bergabung
                        </label>
                        <input type="text" 
                               id="created_at" 
                               name="created_at" 
                               value="{{ $admin->created_at->format('d M Y H:i') }}"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg bg-gray-100 text-sm sm:text-base"
                               readonly>
                    </div>
                </div>

                <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200">
                    <h4 class="text-sm sm:text-base font-semibold text-gray-900 mb-3 sm:mb-4">
                        <i class="fas fa-key mr-2 text-yellow-500"></i>
                        Keamanan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="password" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                                Password Baru
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Kosongkan jika tidak ingin mengubah"
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                                Konfirmasi Password
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Konfirmasi password baru"
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base">
                        </div>
                    </div>
                </div>

                <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <button type="button" class="px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm sm:text-base">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="submit" class="px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm sm:text-base">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Activity Log -->
        <div class="mt-6 sm:mt-8 bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                    <i class="fas fa-history mr-2 text-green-500"></i>
                    Aktivitas Terbaru
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-sign-in-alt text-blue-600 text-xs sm:text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-900">Login ke sistem</p>
                            <p class="text-xs text-gray-500">{{ now()->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-green-600 text-xs sm:text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-900">Mengakses dashboard admin</p>
                            <p class="text-xs text-gray-500">{{ now()->subMinutes(5)->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-yellow-600 text-xs sm:text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-900">Melihat daftar user</p>
                            <p class="text-xs text-gray-500">{{ now()->subMinutes(10)->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 