<?php

namespace App\Services;

use App\Models\Ejurnal;
use Illuminate\Support\Str;

class EjurnalService
{
    public function getAllEjurnals($perPage = 10)
    {
        return Ejurnal::with('user','gambars')->paginate($perPage);
    }

    public function createEjurnal(array $data)
    {
        // Upload gambar jika ada
        if (isset($data['gambar']) && $data['gambar']) {
            $data['gambar'] = ImageService::upload(
                $data['gambar'],
                'ejurnals',
                300
            );
        }

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title'] ?? 'ejurnal');

        return Ejurnal::create($data);
    }

    public function getEjurnalById($id)
    {
        return Ejurnal::with('user')->findOrFail($id);
    }

    public function updateEjurnal($id, array $data)
    {
        $ejurnal = Ejurnal::findOrFail($id);

        // Handle gambar upload
        if (isset($data['gambar']) && $data['gambar']) {
            ImageService::delete($ejurnal->gambar);
            $data['gambar'] = ImageService::upload(
                $data['gambar'],
                'ejurnals',
                300
            );
        }

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $ejurnal->update($data);
        return $ejurnal;
    }

    public function deleteEjurnal($id)
    {
        $ejurnal = Ejurnal::findOrFail($id);
        ImageService::delete($ejurnal->gambar);
        $ejurnal->delete();
    }

    public function deleteGambarEjurnal($id)
    {
        $ejurnal = Ejurnal::findOrFail($id);
        ImageService::delete($ejurnal->gambar);
        $ejurnal->update(['gambar' => null]);
    }
}