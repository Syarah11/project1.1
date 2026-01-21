@extends('layouts.app')

@section('title', 'Admin - Portal Blog')

@section('content')

{{-- Tailwind CDN (taruh di layout kalau bisa, tapi aman di sini dulu) --}}
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
    }

    .link-profile:hover {
        color: #1d4ed8;
        text-decoration: none;
    }
</style>

<div class="max-w-md mx-auto p-6 bg-gray-50 rounded-lg">

    <h1 class="text-xl font-bold mb-4">Kelola Admin</h1>

    {{-- Profil Admin --}}
    <div class="mb-6">
        <a href="#" class="link-profile text-sm font-medium">Profil Admin</a>

        <div class="profile-section mt-2 rounded-lg p-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    AD
                </div>

                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800">Administrator</h3>
                    <p class="text-sm text-gray-600">admin@example.com</p>
                    <p class="text-xs text-gray-500">Role: Super Admin</p>
                </div>

                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                    ● Active
                </span>
            </div>
        </div>
    </div>

    {{-- Edit Profil --}}
    <div>
        <h2 class="text-sm font-medium mb-2">Edit Profil</h2>

        <div class="edit-section rounded-lg p-6">
            <form id="formAdmin" class="space-y-4">
                <div>
                    <label class="text-xs text-gray-600">Nama Lengkap</label>
                    <input type="text" value="Administrator"
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="text-xs text-gray-600">Email</label>
                    <input type="email" value="admin@example.com"
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="text-xs text-gray-600">Password Baru</label>
                    <input type="password"
                        placeholder="Kosongkan jika tidak diubah"
                        class="w-full px-4 py-2 border rounded">
                </div>

                <div>
                    <label class="text-xs text-gray-600">Konfirmasi Password</label>
                    <input type="password"
                        class="w-full px-4 py-2 border rounded">
                </div>
            </form>

            <div class="flex gap-3 mt-6">
                <button id="btnBatal" class="btn-white flex-1 py-2 rounded">Batal</button>
                <button id="btnSimpan" class="btn-white flex-1 py-2 rounded">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btnBatal').onclick = () => {
        document.getElementById('formAdmin').reset();
        alert('Perubahan dibatalkan');
    };

    document.getElementById('btnSimpan').onclick = () => {
        alert('Profil berhasil diperbarui (simulasi)');
    };
</script>

@endsection
