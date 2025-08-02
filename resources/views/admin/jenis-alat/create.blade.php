@extends('admin.layouts.app')

@section('title', 'Tambah Jenis Alat')
@section('page-title', 'Tambah Jenis Alat')
@section('page-description', 'Tambah jenis alat renang baru')

@section('content')
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Tambah Jenis Alat</h1>
                    <a href="{{ route('admin.jenis-alat.index') }}" class="text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Daftar Jenis Alat
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

            <!-- Form Tambah Jenis Alat -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('admin.jenis-alat.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Jenis Alat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kode" name="kode" 
                                   value="{{ old('kode') }}"
                                   placeholder="Contoh: ban_renang"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   required>
                            <p class="text-sm text-gray-500 mt-1">Kode akan otomatis diubah menjadi lowercase dengan underscore</p>
                        </div>
                        
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Jenis Alat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" 
                                   value="{{ old('nama') }}"
                                   placeholder="Contoh: Ban Renang"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  placeholder="Deskripsi tentang jenis alat ini...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.jenis-alat.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Simpan Jenis Alat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 