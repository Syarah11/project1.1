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

    public function createEjurnal(array $data)
    {
        DB::beginTransaction();
        try {
            // Log untuk debug
            Log::info('Creating E-journal', [
                'title' => $data['title'] ?? 'no-title',
                'has_images' => isset($data['images']),
                'images_count' => isset($data['images']) ? count($data['images']) : 0
            ]);

            // Buat ejurnal
            $ejurnal = Ejurnal::create([
                'user_id' => auth()->id(),
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => $data['description'],
                'status' => $data['status'] ?? 'draft',
            ]);

            Log::info('E-journal created', ['id' => $ejurnal->id]);

            // Upload multiple images jika ada
            if (isset($data['images']) && is_array($data['images'])) {
                Log::info('Processing images', ['count' => count($data['images'])]);
                
                foreach ($data['images'] as $index => $image) {
                    try {
                        $path = $this->uploadImage($ejurnal->id, $image);
                        Log::info("Image uploaded", [
                            'index' => $index,
                            'path' => $path
                        ]);
                    } catch (\Exception $e) {
                        Log::error("Failed to upload image $index", [
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            } else {
                Log::warning('No images in request', [
                    'has_images_key' => isset($data['images']),
                    'is_array' => isset($data['images']) ? is_array($data['images']) : false
                ]);
            }

            DB::commit();
            
            return $ejurnal->load(['user', 'gambars']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create E-journal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function getEjurnalById($id)
    {
        return Ejurnal::with(['user', 'gambars'])->findOrFail($id);
    }

    public function updateEjurnal($id, array $data)
    {
        DB::beginTransaction();
        try {
            $ejurnal = Ejurnal::findOrFail($id);

            // Update data ejurnal
            $updateData = [];
            
            if (isset($data['title'])) {
                $updateData['title'] = $data['title'];
                $updateData['slug'] = Str::slug($data['title']);
            }
            
            if (isset($data['description'])) {
                $updateData['description'] = $data['description'];
            }
            
            if (isset($data['status'])) {
                $updateData['status'] = $data['status'];
            }

            if (!empty($updateData)) {
                $ejurnal->update($updateData);
            }

            // Upload new images jika ada
            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $image) {
                    $this->uploadImage($ejurnal->id, $image);
                }
            }

            DB::commit();
            
            return $ejurnal->fresh(['user', 'gambars']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
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