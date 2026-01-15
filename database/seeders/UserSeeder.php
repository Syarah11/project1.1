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
            'name' => 'Admin User',
            'email' => 'admin@ex.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Regular User
        User::create([
            'name' => 'Faefae',
            'email' => 'user@ex.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // Author User
        User::create([
            'name' => 'Faun',
            'email' => 'author@ex.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}