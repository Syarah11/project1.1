<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Tag;
use App\Models\Berita;
use App\Models\Iklan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@ex.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Regular User
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user@ex.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // Create Kategoris
        $teknologi = Kategori::create([
            'name' => 'Teknologi',
            'slug' => 'teknologi',
            'description' => 'Berita seputar teknologi dan inovasi',
        ]);

        $olahraga = Kategori::create([
            'name' => 'Olahraga',
            'slug' => 'olahraga',
            'description' => 'Berita seputar olahraga dan kompetisi',
        ]);

        $politik = Kategori::create([
            'name' => 'Politik',
            'slug' => 'politik',
            'description' => 'Berita seputar politik dan pemerintahan',
        ]);

        $ekonomi = Kategori::create([
            'name' => 'Ekonomi',
            'slug' => 'ekonomi',
            'description' => 'Berita seputar ekonomi dan bisnis',
        ]);

        // Create Tags
        $aiTag = Tag::create([
            'name' => 'AI',
            'slug' => 'ai',
            'created_by' => $admin->id,
        ]);

        $laravelTag = Tag::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
            'created_by' => $admin->id,
        ]);

        $webdevTag = Tag::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'created_by' => $admin->id,
        ]);

        $footballTag = Tag::create([
            'name' => 'Football',
            'slug' => 'football',
            'created_by' => $admin->id,
        ]);

        // Create Beritas
        $berita1 = Berita::create([
            'user_id' => $admin->id,
            'title' => 'Laravel 12 Resmi Dirilis dengan Fitur Baru',
            'slug' => 'laravel-12-resmi-dirilis-dengan-fitur-baru',
            'description' => 'Laravel 12 hadir dengan berbagai fitur menarik yang memudahkan developer dalam membangun aplikasi web modern.',
            'status' => 'published',
            'view_count' => 150,
        ]);

        $berita2 = Berita::create([
            'user_id' => $admin->id,
            'title' => 'AI dan Machine Learning di Tahun 2026',
            'slug' => 'ai-dan-machine-learning-di-tahun-2026',
            'description' => 'Perkembangan AI dan Machine Learning terus berkembang pesat di tahun 2026 dengan berbagai inovasi baru.',
            'status' => 'published',
            'view_count' => 230,
        ]);

        $berita3 = Berita::create([
            'user_id' => $user->id,
            'title' => 'Timnas Indonesia Lolos ke Piala Dunia 2026',
            'slug' => 'timnas-indonesia-lolos-ke-piala-dunia-2026',
            'description' => 'Timnas Indonesia berhasil lolos ke Piala Dunia 2026 setelah mengalahkan Thailand di pertandingan final.',
            'status' => 'published',
            'view_count' => 500,
        ]);

        $berita4 = Berita::create([
            'user_id' => $admin->id,
            'title' => 'Draft: Panduan Lengkap Belajar Laravel untuk Pemula',
            'slug' => 'draft-panduan-lengkap-belajar-laravel-untuk-pemula',
            'description' => 'Panduan lengkap untuk belajar Laravel dari nol hingga mahir.',
            'status' => 'draft',
            'view_count' => 0,
        ]);

        // Attach Kategoris to Beritas (Many-to-Many)
        $berita1->kategoris()->attach([$teknologi->id]);
        $berita2->kategoris()->attach([$teknologi->id]);
        $berita3->kategoris()->attach([$olahraga->id]);
        $berita4->kategoris()->attach([$teknologi->id]);

        // Attach Tags to Beritas (Many-to-Many)
        $berita1->tags()->attach([$laravelTag->id, $webdevTag->id]);
        $berita2->tags()->attach([$aiTag->id]);
        $berita3->tags()->attach([$footballTag->id]);
        $berita4->tags()->attach([$laravelTag->id, $webdevTag->id]);

        // Create Iklans
        Iklan::create([
            'user_id' => $admin->id,
            'name' => 'Iklan Banner Top',
            'link' => 'https://example.com',
            'position' => 'top',
            'priority' => 1,
            'status' => 'active',
        ]);

        Iklan::create([
            'user_id' => $admin->id,
            'name' => 'Iklan Sidebar Kanan',
            'link' => 'https://example.com/sidebar',
            'position' => 'sidebar',
            'priority' => 2,
            'status' => 'active',
        ]);

        Iklan::create([
            'user_id' => $admin->id,
            'name' => 'Iklan Banner Bottom',
            'link' => 'https://example.com/bottom',
            'position' => 'bottom',
            'priority' => 3,
            'status' => 'inactive',
        ]);

        $this->command->info('Database seeded successfully!');
    }
}