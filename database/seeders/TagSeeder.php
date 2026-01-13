<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\User;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $tags = [
            'Breaking News',
            'Trending',
            'Viral',
            'Update',
            'Eksklusif',
            'Terkini',
            'Hot News',
            'Investigasi',
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'nama_tag' => $tagName,
                'created_by' => $admin->id,
            ]);
        }
    }
}