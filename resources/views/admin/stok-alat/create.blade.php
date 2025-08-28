@extends('admin.layouts.app')

@section('title', 'Tambah Stok Alat')
@section('page-title', 'Tambah Stok Alat')
@section('page-description', 'Menambahkan alat renang baru ke inventori')

@section('content')
<!-- Header Actions -->
<div class="glass-card rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 border border-white border-opacity-20">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <div>
            <h2 class="text-lg sm:text-xl font-semibold text-white">Form Tambah Stok Alat</h2>
            <p class="text-sm text-white text-opacity-80">Isi data alat renang yang akan ditambahkan</p>
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

<!-- Form Tambah Stok -->
<div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <form action="{{ route('admin.stok-alat.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
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
                                    <option value="{{ $jenis->id }}" {{ old('jenis_alat_id') == $jenis->id ? 'selected' : '' }}>
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
                                   value="{{ old('nama_alat') }}"
                                   placeholder="Contoh: Ban Renang Anak"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="stok_total" class="block text-sm font-medium text-gray-700 mb-2">
                                Stok Total <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="stok_total" name="stok_total" 
                                   value="{{ old('stok_total') }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   required>
                        </div>
                        
                        <div>
                            <label for="harga_sewa" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Sewa (per hari) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number" id="harga_sewa" name="harga_sewa" 
                                       value="{{ old('harga_sewa') }}"
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
                                  placeholder="Deskripsi tambahan tentang alat...">{{ old('deskripsi') }}</textarea>
                    </div>

        <!-- Submit Button -->
        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('admin.stok-alat.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-center transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <i class="fas fa-save mr-2"></i>
                Simpan Stok Alat
            </button>
        </div>
    </form>
</div>
@endsection
