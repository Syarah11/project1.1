<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\User;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user admin
        $admin = User::where('email', 'admin@ex.com')->first();

        // Jika admin tidak ada, skip
        if (!$admin) {
            $this->command->warn('Admin user tidak ditemukan. Tag seeder dilewati.');
            return;
        }

        $tags = [
            'Breaking News',
            'Trending',
            'Viral',
            'Investigasi',
            'Opini',
            'Eksklusif',
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'nama_tag' => $tagName,
                'slug' => \Illuminate\Support\Str::slug($tagName),
                'created_by' => $admin->id_user,
            ]);
        }
    }
}