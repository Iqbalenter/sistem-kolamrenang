@extends('admin.layouts.app')

@section('title', 'Edit Stok Alat')
@section('page-title', 'Edit Stok Alat')
@section('page-description', 'Mengubah data alat renang')

@section('content')
<!-- Header Actions -->
<div class="glass-card rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 border border-white border-opacity-20">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <div>
            <h2 class="text-lg sm:text-xl font-semibold text-white">Form Edit Stok Alat</h2>
            <p class="text-sm text-white text-opacity-80">Ubah data alat renang: {{ $stokAlat->nama_alat }}</p>
        </div>
        <a href="{{ route('admin.stok-alat.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center justify-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="mb-4 sm:mb-6 p-3 sm:p-4 glass-card border border-red-400 text-white rounded-lg text-sm sm:text-base">
        <div class="flex items-start">
            <i class="fas fa-exclamation-circle mr-2 flex-shrink-0 mt-0.5"></i>
            <div>
                <p class="font-medium mb-2">Terdapat kesalahan pada input:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<!-- Form Edit Stok -->
<div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <form action="{{ route('admin.stok-alat.update', $stokAlat) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jenis_alat_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Alat <span class="text-red-500">*</span>
                            </label>
                            <select id="jenis_alat_id" name="jenis_alat_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required>
                                <option value="">Pilih Jenis Alat</option>
                                @foreach($jenisAlats as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_alat_id', $stokAlat->jenis_alat_id) == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="nama_alat" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Alat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama_alat" name="nama_alat" 
                                   value="{{ old('nama_alat', $stokAlat->nama_alat) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="stok_total" class="block text-sm font-medium text-gray-700 mb-2">
                                Stok Total <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="stok_total" name="stok_total" 
                                   value="{{ old('stok_total', $stokAlat->stok_total) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Stok Tersedia
                            </label>
                            <input type="text" 
                                   value="{{ $stokAlat->stok_tersedia }}"
                                   class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                                   readonly>
                            <p class="text-xs text-gray-500 mt-1">Gunakan fitur Adjust untuk mengubah</p>
                        </div>
                        
                        <div>
                            <label for="harga_sewa" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Sewa (per hari) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number" id="harga_sewa" name="harga_sewa" 
                                       value="{{ old('harga_sewa', $stokAlat->harga_sewa) }}"
                                       min="0" step="500"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  placeholder="Deskripsi tambahan tentang alat...">{{ old('deskripsi', $stokAlat->deskripsi) }}</textarea>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" 
                                   {{ old('is_active', $stokAlat->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Alat yang tidak aktif tidak akan muncul di form booking</p>
                    </div>

        <!-- Submit Button -->
        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('admin.stok-alat.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-center transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-save mr-2"></i>
                Update Stok Alat
            </button>
        </div>
    </form>
</div>
@endsection
