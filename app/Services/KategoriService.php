<?php

namespace App\Services;

use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriService
{
    public function getAllKategoris($perPage = 10)
    {
        return Kategori::paginate($perPage);
    }

    public function getKategoriById($id)
    {
        return Kategori::findOrFail($id);
    }

    public function createKategori(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return Kategori::create($data);
    }

    public function updateKategori($id, array $data)
    {
        $kategori = $this->getKategoriById($id);
        
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        $kategori->update($data);
        return $kategori->fresh();
    }

    public function deleteKategori($id)
    {
        $kategori = $this->getKategoriById($id);
        return $kategori->delete();
    }

    public function getKategoriWithBeritas($id)
    {
        return Kategori::with('beritas')->findOrFail($id);
    }
}