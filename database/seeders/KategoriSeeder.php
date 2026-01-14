<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Politik',
                'slug' => 'politik',
                'deskripsi' => 'Berita seputar politik nasional dan internasional',
            ],
            [
                'nama_kategori' => 'Ekonomi',
                'slug' => 'ekonomi',
                'deskripsi' => 'Berita seputar ekonomi dan bisnis',
            ],
            [
                'nama_kategori' => 'Teknologi',
                'slug' => 'teknologi',
                'deskripsi' => 'Berita seputar perkembangan teknologi',
            ],
            [
                'nama_kategori' => 'Olahraga',
                'slug' => 'olahraga',
                'deskripsi' => 'Berita seputar dunia olahraga',
            ],
            [
                'nama_kategori' => 'Hiburan',
                'slug' => 'hiburan',
                'deskripsi' => 'Berita seputar dunia hiburan',
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}