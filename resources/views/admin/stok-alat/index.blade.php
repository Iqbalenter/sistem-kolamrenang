@extends('admin.layouts.app')

@section('title', 'Kelola Stok Alat')
@section('page-title', 'Kelola Stok Alat')
@section('page-description', 'Manajemen inventori alat renang')

@section('content')
<!-- Header Actions -->
<div class="glass-card rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 border border-white border-opacity-20">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <div>
            <h2 class="text-lg sm:text-xl font-semibold text-white">Daftar Stok Alat</h2>
            <p class="text-sm text-white text-opacity-80">Kelola inventori semua alat renang</p>
        </div>
        <a href="{{ route('admin.stok-alat.create') }}" 
           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center justify-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Stok Alat
        </a>
    </div>
</div>

<!-- Tabel Stok Alat -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-900">Data Stok Alat</h3>
    </div>
                
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jenis Alat
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Alat
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stok Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stok Tersedia
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Harga Sewa
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($stokAlats as $stok)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $stok->jenis_alat_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $stok->nama_alat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $stok->stok_total }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 {{ $stok->stok_tersedia <= 0 ? 'text-red-600 font-semibold' : '' }}">
                                            {{ $stok->stok_tersedia }}
                                        </span>
                                        @if($stok->stok_tersedia <= 0)
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Habis
                                            </span>
                                        @elseif($stok->stok_tersedia <= 3)
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Sedikit
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($stok->harga_sewa, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($stok->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.stok-alat.edit', $stok) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            
                                            <!-- Button untuk adjust stok -->
                                            <button onclick="openAdjustModal({{ $stok->id }}, '{{ $stok->nama_alat }}', {{ $stok->stok_tersedia }})"
                                                    class="text-blue-600 hover:text-blue-900">Adjust</button>
                                            
                                            <form action="{{ route('admin.stok-alat.destroy', $stok) }}" method="POST" 
                                                  class="inline" 
                                                  onsubmit="return confirm('Yakin ingin menghapus stok alat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data stok alat
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    <!-- Modal Adjust Stok -->
    <div id="adjustModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Adjust Stok</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="modalDescription">
                        Sesuaikan stok alat. Gunakan angka positif untuk menambah, negatif untuk mengurangi.
                    </p>
                    <form id="adjustForm" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Stok Saat Ini</label>
                            <input type="text" id="currentStock" readonly 
                                   class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                        </div>
                        <div class="mt-4">
                            <label for="jumlah_adjust" class="block text-sm font-medium text-gray-700">Jumlah Penyesuaian</label>
                            <input type="number" id="jumlah_adjust" name="jumlah_adjust" required 
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <p class="text-xs text-gray-500 mt-1">Contoh: +5 untuk menambah, -3 untuk mengurangi</p>
                        </div>
                        <div class="mt-4">
                            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" required 
                                   placeholder="Alasan penyesuaian stok..."
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="items-center px-4 py-3">
                            <button type="submit" 
                                    class="px-4 py-2 bg-indigo-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                Simpan Penyesuaian
                            </button>
                            <button type="button" onclick="closeAdjustModal()"
                                    class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAdjustModal(stokId, namaAlat, stokTersedia) {
            document.getElementById('modalTitle').textContent = `Adjust Stok - ${namaAlat}`;
            document.getElementById('currentStock').value = stokTersedia;
            document.getElementById('adjustForm').action = `/admin/stok-alat/${stokId}/adjust`;
            document.getElementById('jumlah_adjust').value = '';
            document.getElementById('keterangan').value = '';
            document.getElementById('adjustModal').classList.remove('hidden');
        }

        function closeAdjustModal() {
            document.getElementById('adjustModal').classList.add('hidden');
        }
    </script>
@endsection
