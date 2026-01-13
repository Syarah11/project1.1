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
                'id_user' => $data['id_user'],
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'] ?? null,
            ]);

            if (isset($data['gambars']) && is_array($data['gambars'])) {
                foreach ($data['gambars'] as $gambar) {
                    $gambarPath = $gambar->store('ejurnals', 'public');
                    
                    GambarEjurnal::create([
                        'id_ejurnal' => $ejurnal->id_ejurnal,
                        'id_user' => $data['id_user'],
                        'gambar' => $gambarPath,
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
            if (isset($data['judul'])) {
                $updateData['judul'] = $data['judul'];
            }
            if (isset($data['deskripsi'])) {
                $updateData['deskripsi'] = $data['deskripsi'];
            }

            $ejurnal->update($updateData);

            if (isset($data['gambars']) && is_array($data['gambars'])) {
                foreach ($data['gambars'] as $gambar) {
                    $gambarPath = $gambar->store('ejurnals', 'public');
                    
                    GambarEjurnal::create([
                        'id_ejurnal' => $ejurnal->id_ejurnal,
                        'id_user' => $data['id_user'],
                        'gambar' => $gambarPath,
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
                Storage::disk('public')->delete($gambar->gambar);
                $gambar->delete();
            }

            return $ejurnal->delete();
        });
    }

    public function deleteGambarEjurnal($id)
    {
        $gambar = GambarEjurnal::findOrFail($id);
        Storage::disk('public')->delete($gambar->gambar);
        return $gambar->delete();
    }
}