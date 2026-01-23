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
    return Ejurnal::with(['user', 'thumbnail'])->paginate($perPage);
}

    public function getEjurnalById($id)
{
    return Ejurnal::with(['user', 'thumbnail'])->findOrFail($id);
}

   public function createEjurnal(array $data)
{
    return DB::transaction(function () use ($data) {

        $ejurnal = Ejurnal::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        if (!empty($data['thumbnail']) && is_array($data['thumbnail'])) {
            foreach ($data['thumbnail'] as $file) {
                $path = $file->store('ejurnals', 'public');

                GambarEjurnal::create([
                    'ejurnal_id' => $ejurnal->id,
                    'user_id' => auth()->id(),
                    'image' => $path,
                ]);
            }
        }

        return $ejurnal->load(['user', 'thumbnail']);
    });
}

   public function updateEjurnal($id, array $data)
{
    return DB::transaction(function () use ($id, $data) {

        $ejurnal = Ejurnal::findOrFail($id);

        $ejurnal->update(array_filter([
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
        ]));

        if (!empty($data['thumbnail']) && is_array($data['thumbnail'])) {
            foreach ($data['thumbnail'] as $file) {
                $path = $file->store('ejurnals', 'public');

                GambarEjurnal::create([
                    'ejurnal_id' => $ejurnal->id,
                    'user_id' => auth()->id(),
                    'image' => $path,
                ]);
            }
        }

        return $ejurnal->fresh(['user', 'thumbnail']);
    });
}

   public function deleteEjurnal($id)
{
    return DB::transaction(function () use ($id) {

        $ejurnal = Ejurnal::with('thumbnail')->findOrFail($id);

        foreach ($ejurnal->thumbnail as $gambar) {
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
