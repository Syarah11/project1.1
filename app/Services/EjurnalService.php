<?php

// Namespace service Ejurnal
// Menunjukkan bahwa file ini berada di folder App/Services
namespace App\Services;

// Memanggil model Ejurnal (tabel ejurnals)
use App\Models\Ejurnal;

// Memanggil model GambarEjurnal (tabel gambar ejurnal)
use App\Models\GambarEjurnal;

// Digunakan untuk transaksi database (commit & rollback)
use Illuminate\Support\Facades\DB;

// Digunakan untuk mengelola file (upload & hapus gambar)
use Illuminate\Support\Facades\Storage;

// Service berisi logika bisnis Ejurnal
class EjurnalService
{
    // ===============================
    // MENGAMBIL SEMUA DATA EJURNAL (PAGINATION)
    // ===============================
    public function getAllEjurnals($perPage = 10)
    {
        // Mengambil data ejurnal beserta relasi user dan thumbnail
        // paginate($perPage) → data dibagi per halaman
        return Ejurnal::with(['user', 'thumbnail'])->paginate($perPage);
    }

    // ===============================
    // MENGAMBIL 1 DATA EJURNAL BERDASARKAN ID
    // ===============================
    public function getEjurnalById($id)
    {
        // with() → mengambil relasi user dan thumbnail
        // findOrFail() → jika ID tidak ditemukan, otomatis error 404
        return Ejurnal::with(['user', 'thumbnail'])->findOrFail($id);
    }

    // ===============================
    // MENYIMPAN DATA EJURNAL BARU
    // ===============================
   public function createEjurnal(array $data, $thumbnailFile = null)
{
    return DB::transaction(function () use ($data, $thumbnailFile) {

        $ejurnal = Ejurnal::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        // 🔥 SIMPAN FILE & RELASI
        if ($thumbnailFile) {
            $path = $thumbnailFile->store('ejurnals', 'public');

            GambarEjurnal::create([
                'ejurnal_id' => $ejurnal->id,
                'user_id' => auth()->id(),
                'image' => $path,
            ]);
        }

        return $ejurnal->load(['user', 'thumbnail']);
    });
}


    // ===============================
    // MENGUPDATE DATA EJURNAL
    // ===============================
    public function updateEjurnal($id, array $data, $thumbnailFile = null)
{
    return DB::transaction(function () use ($id, $data, $thumbnailFile) {

        $ejurnal = Ejurnal::findOrFail($id);

        // Update data ejurnal
        $ejurnal->update(array_filter([
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
        ]));

        // ✅ KONSISTEN dengan createEjurnal
        if ($thumbnailFile) {
            $path = $thumbnailFile->store('ejurnals', 'public');

            GambarEjurnal::create([
                'ejurnal_id' => $ejurnal->id,
                'user_id' => auth()->id(),
                'image' => $path,
            ]);
        }

        return $ejurnal->fresh(['user', 'thumbnail']);
    });
}

    // ===============================
    // MENGHAPUS EJURNAL BESERTA GAMBAR
    // ===============================
    public function deleteEjurnal($id)
    {
        // Transaksi agar hapus data aman
        return DB::transaction(function () use ($id) {

            // Ambil ejurnal beserta thumbnail-nya
            $ejurnal = Ejurnal::with('thumbnail')->findOrFail($id);

            // Loop semua gambar ejurnal
            foreach ($ejurnal->thumbnail as $gambar) {

                // Hapus file gambar dari storage
                Storage::disk('public')->delete($gambar->image);

                // Hapus data gambar dari database
                $gambar->delete();
            }

            // Hapus data ejurnal
            $ejurnal->delete();

            // Kembalikan true jika berhasil
            return true;
        });
    }

    // ===============================
    // MENGHAPUS 1 GAMBAR EJURNAL SAJA
    // ===============================
    public function deleteGambarEjurnal($id)
    {
        // Ambil data gambar berdasarkan ID
        $gambar = GambarEjurnal::findOrFail($id);

        // Hapus file gambar dari storage
        Storage::disk('public')->delete($gambar->image);

        // Hapus data gambar dari database
        return $gambar->delete();
    }
}
