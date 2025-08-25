<?php

namespace App\Http\Controllers;

use App\Models\StokAlat;
use Illuminate\Http\Request;

class StokAlatController extends Controller
{
    // Menampilkan halaman kelola stok alat
    public function index()
    {
        $stokAlats = StokAlat::all();
        return view('admin.stok-alat.index', compact('stokAlats'));
    }

    // Menampilkan form tambah stok alat
    public function create()
    {
        return view('admin.stok-alat.create');
    }

    // Menyimpan stok alat baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_alat' => 'required|in:ban_renang,kacamata_renang,papan_renang,pelampung,fins,snorkel|unique:stok_alats,jenis_alat',
            'nama_alat' => 'required|string|max:255',
            'stok_total' => 'required|integer|min:0',
            'harga_sewa' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        StokAlat::create([
            'jenis_alat' => $request->jenis_alat,
            'nama_alat' => $request->nama_alat,
            'stok_total' => $request->stok_total,
            'stok_tersedia' => $request->stok_total, // Awalnya stok tersedia sama dengan total
            'harga_sewa' => $request->harga_sewa,
            'deskripsi' => $request->deskripsi,
            'is_active' => true
        ]);

        return redirect()->route('admin.stok-alat.index')->with('success', 'Stok alat berhasil ditambahkan!');
    }

    // Menampilkan form edit stok alat
    public function edit(StokAlat $stokAlat)
    {
        return view('admin.stok-alat.edit', compact('stokAlat'));
    }

    // Update stok alat
    public function update(Request $request, StokAlat $stokAlat)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'stok_total' => 'required|integer|min:0',
            'harga_sewa' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Jika stok total berubah, adjust stok tersedia
        $stokTersediaBaru = $stokAlat->stok_tersedia;
        if ($request->stok_total != $stokAlat->stok_total) {
            $selisih = $request->stok_total - $stokAlat->stok_total;
            $stokTersediaBaru = $stokAlat->stok_tersedia + $selisih;
            // Pastikan stok tersedia tidak negatif
            $stokTersediaBaru = max(0, $stokTersediaBaru);
        }

        $stokAlat->update([
            'nama_alat' => $request->nama_alat,
            'stok_total' => $request->stok_total,
            'stok_tersedia' => $stokTersediaBaru,
            'harga_sewa' => $request->harga_sewa,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.stok-alat.index')->with('success', 'Stok alat berhasil diupdate!');
    }

    // Hapus stok alat
    public function destroy(StokAlat $stokAlat)
    {
        $stokAlat->delete();
        return redirect()->route('admin.stok-alat.index')->with('success', 'Stok alat berhasil dihapus!');
    }

    // Method untuk adjust stok manual
    public function adjustStok(Request $request, StokAlat $stokAlat)
    {
        $request->validate([
            'jumlah_adjust' => 'required|integer',
            'keterangan' => 'required|string|max:255'
        ]);

        $stokLama = $stokAlat->stok_tersedia;
        $stokBaru = $stokLama + $request->jumlah_adjust;
        
        // Pastikan stok tidak negatif dan tidak melebihi total
        $stokBaru = max(0, min($stokBaru, $stokAlat->stok_total));
        
        $stokAlat->update(['stok_tersedia' => $stokBaru]);

        return redirect()->route('admin.stok-alat.index')
            ->with('success', "Stok berhasil disesuaikan dari {$stokLama} menjadi {$stokBaru}. Keterangan: {$request->keterangan}");
    }
}
