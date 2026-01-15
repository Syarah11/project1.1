@extends('layouts.app')

@section('title', 'Admin - Portal Blog')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-section {
            background-color: #d1d5db;
            transition: all 0.3s ease;
        }

        .profile-section:hover {
            background-color: #c7cbd1;
        }

        .edit-section {
            background-color: #d1d5db;
            transition: all 0.3s ease;
        }

        .btn-white {
            background-color: white;
            transition: all 0.3s ease;
        }

        .btn-white:hover {
            background-color: #f3f4f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .link-profile {
            color: #2563eb;
            text-decoration: underline;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .link-profile:hover {
            color: #1d4ed8;
            text-decoration: none;
        }
    </style>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <h1 class="text-xl font-bold mb-4">Kelola Admin</h1>

        <!-- Profil Admin Section -->
        <div class="mb-6">
            <a href="#" class="link-profile text-sm font-medium">Profil Admin</a>
            <div class="profile-section mt-2 rounded-lg p-6 min-h-[80px]">
                <!-- Info Admin -->
                <div class="flex items-center gap-4">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            AD
                        </div>
                    </div>
                    
                    <!-- Info Text -->
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800">Administrator</h3>
                        <p class="text-sm text-gray-600">admin@example.com</p>
                        <p class="text-xs text-gray-500 mt-1">Role: Super Admin</p>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                            ● Active
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profil Section -->
        <div>
            <h2 class="text-sm font-medium mb-2">Edit Profil</h2>
            <div class="edit-section rounded-lg p-6 min-h-[180px]">
                <!-- Form Edit Profil -->
                <form class="space-y-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" 
                               value="Administrator"
                               placeholder="Nama Lengkap" 
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Email</label>
                        <input type="email"
                               value="admin@example.com"
                               placeholder="Email" 
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Password Baru</label>
                        <input type="password" 
                               placeholder="Kosongkan jika tidak ingin mengubah" 
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Konfirmasi Password</label>
                        <input type="password" 
                               placeholder="Konfirmasi password baru" 
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </form>

                <!-- Buttons -->
                <div class="flex gap-3 mt-6">
                    <button class="btn-white flex-1 px-6 py-2.5 rounded-lg font-medium">
                        Batal
                    </button>
                    <button class="btn-white flex-1 px-6 py-2.5 rounded-lg font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle Batal button
        document.querySelectorAll('.btn-white')[0].addEventListener('click', function() {
            const form = document.querySelector('form');
            form.reset();
            alert('Perubahan dibatalkan');
        });

        // Handle Simpan button
        document.querySelectorAll('.btn-white')[1].addEventListener('click', function() {
            const nama = document.querySelector('input[type="text"]').value;
            const email = document.querySelector('input[type="email"]').value;
            const password = document.querySelectorAll('input[type="password"]')[0].value;
            const confirmPass = document.querySelectorAll('input[type="password"]')[1].value;

            // Validasi
            if (!nama.trim() || !email.trim()) {
                alert('Nama dan Email harus diisi!');
                return;
            }

            // Validasi email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Format email tidak valid!');
                return;
            }

            // Validasi password jika diisi
            if (password.trim() !== '') {
                if (password.length < 6) {
                    alert('Password minimal 6 karakter!');
                    return;
                }
                if (password !== confirmPass) {
                    alert('Password dan konfirmasi password tidak cocok!');
                    return;
                }
            }

            // Simulasi update profil
            alert('✓ Profil berhasil diperbarui!\n\nNama: ' + nama + '\nEmail: ' + email);
            
            // Update tampilan profil
            document.querySelector('.profile-section h3').textContent = nama;
            document.querySelector('.profile-section p').textContent = email;
            
            // Reset password fields
            document.querySelectorAll('input[type="password"]').forEach(input => {
                input.value = '';
            });
        });

        // Handle Profil Admin link
        document.querySelector('.link-profile').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Menampilkan profil admin...');
        });
    </script>
</body>
</html>
@endsection