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
                'deskripsi' => 'Berita seputar politik nasional dan internasional',
            ],
            [
                'nama_kategori' => 'Ekonomi',
                'deskripsi' => 'Berita ekonomi dan bisnis',
            ],
            [
                'nama_kategori' => 'Teknologi',
                'deskripsi' => 'Berita teknologi dan inovasi',
            ],
            [
                'nama_kategori' => 'Olahraga',
                'deskripsi' => 'Berita olahraga dan kompetisi',
            ],
            [
                'nama_kategori' => 'Entertainment',
                'deskripsi' => 'Berita hiburan dan selebriti',
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}