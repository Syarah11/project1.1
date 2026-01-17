<?php

namespace App\Services;

use App\Models\Ejurnal;
use App\Models\GambarEjurnal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EjurnalService
{
    public function getAllEjurnals($perPage = 10)
    {
        return Ejurnal::with(['user', 'gambars'])->paginate($perPage);
    }

    public function getEjurnalById($id)
    {
        return Ejurnal::with(['user', 'gambars'])->findOrFail($id);
    }

    public function createEjurnal(array $data)
    {
        return DB::transaction(function () use ($data) {
            $ejurnal = Ejurnal::create([
                'user_id' => $data['user_id'],
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
            ]);

            if (!empty($data['gambars']) && is_array($data['gambars'])) {
                foreach ($data['gambars'] as $gambar) {
                    $path = $gambar->store('ejurnals', 'public');

                    GambarEjurnal::create([
                        'ejurnal_id' => $ejurnal->id,
                        'user_id' => $data['user_id'],
                        'image' => $path,
                    ]);
                }
            }

            return $ejurnal->load(['user', 'gambars']);
        });
    }

    public function updateEjurnal($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $ejurnal = Ejurnal::findOrFail($id);

            $updateData = [];

            if (isset($data['title'])) {
                $updateData['title'] = $data['title'];
            }

            if (isset($data['description'])) {
                $updateData['description'] = $data['description'];
            }

            $ejurnal->update($updateData);

            if (!empty($data['gambars']) && is_array($data['gambars'])) {
                foreach ($data['gambars'] as $gambar) {
                    $path = $gambar->store('ejurnals', 'public');

                    GambarEjurnal::create([
                        'ejurnal_id' => $ejurnal->id,
                        'user_id' => auth()->id(),
                        'image' => $path,
                    ]);
                }
            }

            return $ejurnal->fresh(['user', 'gambars']);
        });
    }

    public function deleteEjurnal($id)
    {
        return DB::transaction(function () use ($id) {
            $ejurnal = Ejurnal::with('gambars')->findOrFail($id);

            foreach ($ejurnal->gambars as $gambar) {
                Storage::disk('public')->delete($gambar->image);
                $gambar->delete();
            }

            $ejurnal->delete();

            return true;
        });
    }

    public function deleteGambarEjurnal($id)
    {
        $gambar = GambarEjurnal::findOrFail($id);
        Storage::disk('public')->delete($gambar->image);
        return $gambar->delete();
    }
}