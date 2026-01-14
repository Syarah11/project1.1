<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'nama' => 'Admin User',  // ← Ubah 'name' ke 'nama'
            'email' => 'admin@ex.com',
            'password' => Hash::make('password123'),
            // 'role' => 'admin',  // ← Hapus ini atau sesuaikan dengan ENUM database
        ]);

        // Regular User
        User::create([
            'nama' => 'Faefae',  // ← Ubah 'name' ke 'nama'
            'email' => 'user@ex.com',
            'password' => Hash::make('password123'),
            // 'role' => 'user',  // ← Hapus atau sesuaikan
        ]);

        // Author User
        User::create([
            'nama' => 'Faun',  // ← Ubah 'name' ke 'nama'
            'email' => 'author@ex.com',
            'password' => Hash::make('password123'),
            // 'role' => 'user',  // ← Hapus atau sesuaikan
        ]);
    }
}