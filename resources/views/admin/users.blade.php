@extends('admin.layouts.app')

@section('title', 'Kelola Users')
@section('page-title', 'Kelola Users')
@section('page-description', 'Daftar semua user yang terdaftar dalam sistem')

@section('content')
<!-- Users Table -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-users mr-2 text-blue-500"></i>
                Daftar User Terdaftar
            </h3>
            <div class="text-sm text-gray-500">
                Total: {{ $users->total() }} user
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama & Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Booking</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-bold">{{ $user->id }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            <i class="fas {{ $user->role === 'admin' ? 'fa-user-shield' : 'fa-user' }} mr-1"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @php
                            $bookingCount = $user->bookings()->count();
                        @endphp
                        <div class="flex items-center">
                            <span class="text-lg font-bold text-blue-600">{{ $bookingCount }}</span>
                            <span class="text-sm text-gray-500 ml-1">booking</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-xs">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" 
                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-xs">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500 text-lg">Tidak ada user ditemukan</p>
                            <p class="text-gray-400 text-sm">Belum ada user yang terdaftar dalam sistem</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- User Statistics Cards -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-white text-lg"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total User</p>
                <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-lg"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">User Baru (30 hari)</p>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'user')->where('created_at', '>=', now()->subDays(30))->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-white text-lg"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">User Aktif Booking</p>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::whereHas('bookings')->where('role', 'user')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteUserForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete(userId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data booking user tersebut.`)) {
        const form = document.getElementById('deleteUserForm');
        form.action = `/admin/users/${userId}`;
        form.submit();
    }
}
</script>
@endsection 