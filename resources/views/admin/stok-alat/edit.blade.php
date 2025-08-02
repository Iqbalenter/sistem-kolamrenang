@extends('admin.layouts.app')

@section('title', 'Edit Stok Alat')
@section('page-title', 'Edit Stok Alat')
@section('page-description', 'Edit informasi stok alat renang')

@section('content')
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Stok Alat</h1>
                    <a href="{{ route('admin.stok-alat.index') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Daftar Stok
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

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Edit Stok -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('admin.stok-alat.update', $stokAlat) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jenis_alat" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Alat
                            </label>
                            <input type="text" 
                                   value="{{ $stokAlat->jenis_alat_label }}"
                                   class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                                   readonly>
                            <input type="hidden" name="jenis_alat_id" value="{{ $stokAlat->jenis_alat_id }}">
                            <p class="text-xs text-gray-500 mt-1">Jenis alat tidak dapat diubah setelah dibuat</p>
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

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.stok-alat.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Update Stok Alat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
