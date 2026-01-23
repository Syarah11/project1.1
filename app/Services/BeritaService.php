<?php

namespace App\Services;

use App\Models\Berita;
use Illuminate\Support\Str;

class BeritaService
{
    public function store(array $data): Berita
    {
        $data['slug'] = Str::slug($data['judul']);
        $data['view_count'] = 0;

        return Berita::create($data);
    }

    public function update(Berita $berita, array $data): Berita
    {
        if (isset($data['judul'])) {
            $data['slug'] = Str::slug($data['judul']);
        }

        $berita->update($data);
        return $berita;
    }

    public function incrementView(Berita $berita): void
    {
        $berita->increment('view_count');
    }
    
}
