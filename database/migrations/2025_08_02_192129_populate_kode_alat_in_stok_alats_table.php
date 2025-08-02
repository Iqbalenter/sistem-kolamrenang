<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update kode_alat yang kosong dengan nilai unik
        $stokAlats = DB::table('stok_alats')->whereNull('kode_alat')->orWhere('kode_alat', '')->get();
        
        foreach ($stokAlats as $index => $stokAlat) {
            $kodeAlat = 'ALAT-' . str_pad($stokAlat->id, 4, '0', STR_PAD_LEFT);
            DB::table('stok_alats')
                ->where('id', $stokAlat->id)
                ->update(['kode_alat' => $kodeAlat]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kosongkan kembali kode_alat
        DB::table('stok_alats')->update(['kode_alat' => null]);
    }
};
