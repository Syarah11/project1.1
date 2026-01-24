<?php

namespace App\Services;

use App\Models\Ejurnal;
use App\Models\GambarEjurnal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EjurnalService
{
    public function getAllEjurnals($perPage = 10)
    {
        return Ejurnal::with(['user', 'gambars'])
            ->latest()
            ->paginate($perPage);
    }

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

        // ✅ GUNAKAN fresh() DI SINI
        return $ejurnal->fresh(['user', 'thumbnail']);
    });
}

    public function getEjurnalById($id)
    {
        return Ejurnal::with(['user', 'gambars'])->findOrFail($id);
    }

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

    public function deleteEjurnal($id)
    {
        DB::beginTransaction();
        try {
            $ejurnal = Ejurnal::findOrFail($id);
            
            // Delete semua gambar terkait
            foreach ($ejurnal->gambars as $gambar) {
                $this->deleteImageFile($gambar->image);
                $gambar->delete();
            }
            
            $ejurnal->delete();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteGambarEjurnal($gambarId)
    {
        DB::beginTransaction();
        try {
            $gambar = GambarEjurnal::findOrFail($gambarId);
            
            $this->deleteImageFile($gambar->image);
            $gambar->delete();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Upload image ke storage dan simpan ke database
     */
    private function uploadImage($ejurnalId, $imageFile)
    {
        $filename = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
        $path = $imageFile->storeAs('ejurnals', $filename, 'public');

        Log::info('Storing image in database', [
            'ejurnal_id' => $ejurnalId,
            'filename' => $filename,
            'path' => $path
        ]);

        GambarEjurnal::create([
            'ejurnal_id' => $ejurnalId,
            'user_id' => auth()->id(),
            'image' => $path,
        ]);

        return $path;
    }

    /**
     * Delete image file dari storage
     */
    private function deleteImageFile($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}