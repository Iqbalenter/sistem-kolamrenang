<?php

namespace App\Http\Controllers;

use App\Models\JenisAlat;
use Illuminate\Http\Request;

class JenisAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisAlats = JenisAlat::orderBy('nama')->get();
        return view('admin.jenis-alat.index', compact('jenisAlats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jenis-alat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:jenis_alats,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        JenisAlat::create([
            'kode' => strtolower(str_replace(' ', '_', $request->kode)),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.jenis-alat.index')->with('success', 'Jenis alat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisAlat $jenisAlat)
    {
        return view('admin.jenis-alat.show', compact('jenisAlat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisAlat $jenisAlat)
    {
        return view('admin.jenis-alat.edit', compact('jenisAlat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisAlat $jenisAlat)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:jenis_alats,kode,' . $jenisAlat->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        $jenisAlat->update([
            'kode' => strtolower(str_replace(' ', '_', $request->kode)),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.jenis-alat.index')->with('success', 'Jenis alat berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisAlat $jenisAlat)
    {
        // Cek apakah jenis alat masih digunakan di stok atau booking
        if ($jenisAlat->stokAlats()->count() > 0 || $jenisAlat->bookingSewaAlats()->count() > 0) {
            return redirect()->route('admin.jenis-alat.index')
                ->with('error', 'Jenis alat tidak dapat dihapus karena masih digunakan!');
        }

        $jenisAlat->delete();
        return redirect()->route('admin.jenis-alat.index')->with('success', 'Jenis alat berhasil dihapus!');
    }
}
