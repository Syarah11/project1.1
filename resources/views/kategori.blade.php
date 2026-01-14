@extends('layouts.app')

@section('title', 'Admin - Portal Blog')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card {
            background-color: #d1d5db;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-active {
            background-color: #e5e7eb;
            border: 3px solid #a855f7;
            box-shadow: 0 4px 20px rgba(168, 85, 247, 0.2);
        }

        .card-active:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(168, 85, 247, 0.3);
        }

        .btn-simpan {
            background-color: transparent;
            border: 1px solid #4b5563;
            transition: all 0.3s ease;
        }

        .btn-simpan:hover {
            background-color: #4b5563;
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <h1 class="text-2xl font-bold mb-6">Kelola Kategori</h1>

        <!-- Grid 2x2 Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Tambah Kategori (Kiri Atas) -->
            <div class="card rounded-lg p-6 min-h-[250px] flex flex-col justify-between">
                <div>
                    <h2 class="text-sm text-gray-700 mb-4">Tambah Kategori</h2>
                    <div class="space-y-4">
                        <input type="text" 
                               placeholder="Nama Kategori" 
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <textarea placeholder="Deskripsi" 
                                  rows="3" 
                                  class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400 resize-none"></textarea>
                    </div>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="btn-simpan px-8 py-2 rounded font-medium">
                        Simpan
                    </button>
                </div>
            </div>

            <!-- Tabel Kategori (Kanan Atas) - Active with Purple Border -->
            <div class="card card-active rounded-lg p-6 min-h-[250px]">
                <h2 class="text-sm text-gray-700 mb-4">Tabel Kategori</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-400">
                                <th class="text-left py-2 px-2 font-semibold">No</th>
                                <th class="text-left py-2 px-2 font-semibold">Nama</th>
                                <th class="text-left py-2 px-2 font-semibold">Slug</th>
                                <th class="text-center py-2 px-2 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-300">
                                <td class="py-2 px-2">1</td>
                                <td class="py-2 px-2">Teknologi</td>
                                <td class="py-2 px-2 text-gray-600">teknologi</td>
                                <td class="py-2 px-2 text-center">
                                    <button class="text-blue-600 hover:text-blue-800 mx-1">✏️</button>
                                    <button class="text-red-600 hover:text-red-800 mx-1">🗑️</button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300">
                                <td class="py-2 px-2">2</td>
                                <td class="py-2 px-2">Bisnis</td>
                                <td class="py-2 px-2 text-gray-600">bisnis</td>
                                <td class="py-2 px-2 text-center">
                                    <button class="text-blue-600 hover:text-blue-800 mx-1">✏️</button>
                                    <button class="text-red-600 hover:text-red-800 mx-1">🗑️</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tambah Tag (Kiri Bawah) -->
            <div class="card rounded-lg p-6 min-h-[250px] flex flex-col justify-between">
                <div>
                    <h2 class="text-sm text-gray-700 mb-4">Tambah Tag</h2>
                    <div class="space-y-4">
                        <input type="text" 
                               placeholder="Nama Tag" 
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <div>
                            <label class="block text-xs text-gray-600 mb-2">Warna Tag</label>
                            <input type="color" 
                                   value="#a855f7" 
                                   class="w-full h-10 border border-gray-300 rounded cursor-pointer">
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="btn-simpan px-8 py-2 rounded font-medium">
                        Simpan
                    </button>
                </div>
            </div>

            <!-- Tabel Tag (Kanan Bawah) -->
            <div class="card rounded-lg p-6 min-h-[250px]">
                <h2 class="text-sm text-gray-700 mb-4">Tabel Tag</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-400">
                                <th class="text-left py-2 px-2 font-semibold">No</th>
                                <th class="text-left py-2 px-2 font-semibold">Nama</th>
                                <th class="text-left py-2 px-2 font-semibold">Warna</th>
                                <th class="text-center py-2 px-2 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-300">
                                <td class="py-2 px-2">1</td>
                                <td class="py-2 px-2">
                                    <span class="inline-block px-3 py-1 rounded-full text-white text-xs" style="background-color: #a855f7">
                                        Programming
                                    </span>
                                </td>
                                <td class="py-2 px-2">
                                    <span class="inline-block w-8 h-8 rounded border" style="background-color: #a855f7"></span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button class="text-blue-600 hover:text-blue-800 mx-1">✏️</button>
                                    <button class="text-red-600 hover:text-red-800 mx-1">🗑️</button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300">
                                <td class="py-2 px-2">2</td>
                                <td class="py-2 px-2">
                                    <span class="inline-block px-3 py-1 rounded-full text-white text-xs" style="background-color: #3b82f6">
                                        Design
                                    </span>
                                </td>
                                <td class="py-2 px-2">
                                    <span class="inline-block w-8 h-8 rounded border" style="background-color: #3b82f6"></span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button class="text-blue-600 hover:text-blue-800 mx-1">✏️</button>
                                    <button class="text-red-600 hover:text-red-800 mx-1">🗑️</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Add click handlers for buttons
        document.querySelectorAll('.btn-simpan').forEach(btn => {
            btn.addEventListener('click', function() {
                alert('Data akan disimpan!');
            });
        });

        // Add hover effect to table rows
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(168, 85, 247, 0.05)';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'transparent';
            });
        });
    </script>
</body>
</html>
@endsection