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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal {
            animation: fadeIn 0.3s ease-out;
        }

        .card {
            background-color: #d1d5db;
            transition: all 0.3s ease;
        }

        .btn-simpan {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            transition: all 0.3s ease;
        }

        .btn-simpan:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background: rgba(139, 92, 246, 0.05);
        }

        .btn-action {
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <h1 class="text-2xl font-bold mb-6">Kelola Kategori</h1>

        <!-- Grid Layout 2x2 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Tambah Kategori (Kiri Atas) -->
            <div class="card rounded-lg p-6 min-h-[200px] flex flex-col">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tambah Kategori</h2>
                <form id="formAddCategory" class="flex-1 flex flex-col">
                    <div class="flex-1">
                        <label class="block text-xs text-gray-700 mb-2 font-medium">Nama Kategori</label>
                        <input type="text" 
                               id="newCategoryName"
                               placeholder="Masukkan nama kategori"
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div class="flex justify-center mt-6">
                        <button type="submit" 
                                class="btn-simpan text-white px-8 py-2 rounded font-medium">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Kategori (Kanan Atas) -->
            <div class="card rounded-lg p-6 min-h-[200px]">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tabel Kategori</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-400">
                                <th class="text-left py-2 px-2 font-semibold text-xs">Nama Kategori</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Jumlah</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Edit</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody">
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-2 px-2">Teknologi</td>
                                <td class="py-2 px-2 text-center">
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">12</span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="editCategory('Teknologi', 12)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="deleteCategory(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-2 px-2">Bisnis</td>
                                <td class="py-2 px-2 text-center">
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">8</span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="editCategory('Bisnis', 8)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="deleteCategory(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-2 px-2">Pendidikan</td>
                                <td class="py-2 px-2 text-center">
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">15</span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="editCategory('Pendidikan', 15)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="deleteCategory(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tambah Tag (Kiri Bawah) -->
            <div class="card rounded-lg p-6 min-h-[200px] flex flex-col">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tambah Tag</h2>
                <form id="formAddTag" class="flex-1 flex flex-col">
                    <div class="flex-1">
                        <label class="block text-xs text-gray-700 mb-2 font-medium">Nama Tag</label>
                        <input type="text" 
                               id="newTagName"
                               placeholder="Masukkan nama tag"
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div class="flex justify-center mt-6">
                        <button type="submit" 
                                class="btn-simpan text-white px-8 py-2 rounded font-medium">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Tag (Kanan Bawah) -->
            <div class="card rounded-lg p-6 min-h-[200px]">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tabel Tag</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-400">
                                <th class="text-left py-2 px-2 font-semibold text-xs">Nama Tag</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Jumlah</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Edit</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="tagTableBody">
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-2 px-2">
                                    <span class="text-gray-700 text-xs font-medium">
                                        <i class="fas fa-tag mr-1"></i> Programming
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">25</span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="editTag('Programming', 25)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="deleteTag(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-2 px-2">
                                    <span class="text-gray-700 text-xs font-medium">
                                        <i class="fas fa-tag mr-1"></i> Design
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">18</span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="editTag('Design', 18)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="deleteTag(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-2 px-2">
                                    <span class="text-gray-700 text-xs font-medium">
                                        <i class="fas fa-tag mr-1"></i> Tutorial
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">32</span>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="editTag('Tutorial', 32)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <button onclick="deleteTag(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="modalEditCategory" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="modal bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6">
                <h3 class="text-white text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Kategori
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" 
                           id="editCategoryName"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Kategori</label>
                    <input type="number" 
                           id="editCategoryCount"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div class="flex gap-3 pt-2">
                    <button onclick="closeModal('modalEditCategory')" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button onclick="saveCategory()" class="flex-1 btn-simpan text-white py-3 rounded-lg font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tag -->
    <div id="modalEditTag" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="modal bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6">
                <h3 class="text-white text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Tag
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tag</label>
                    <input type="text" 
                           id="editTagName"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tag</label>
                    <input type="number" 
                           id="editTagCount"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div class="flex gap-3 pt-2">
                    <button onclick="closeModal('modalEditTag')" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button onclick="saveTag()" class="flex-1 btn-simpan text-white py-3 rounded-lg font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentEditRow = null;

        // Add Category
        document.getElementById('formAddCategory').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('newCategoryName').value.trim();

            if (!name) {
                alert('Nama kategori harus diisi!');
                return;
            }

            const tbody = document.getElementById('categoryTableBody');
            const newRow = tbody.insertRow(0);
            newRow.className = 'border-b border-gray-300 table-row';
            newRow.innerHTML = `
                <td class="py-2 px-2">${name}</td>
                <td class="py-2 px-2 text-center">
                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">0</span>
                </td>
                <td class="py-2 px-2 text-center">
                    <button onclick="editCategory('${name}', 0)" class="btn-action text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td class="py-2 px-2 text-center">
                    <button onclick="deleteCategory(this)" class="btn-action text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            document.getElementById('newCategoryName').value = '';
            alert('✓ Kategori berhasil ditambahkan!');
        });

        // Edit Category
        function editCategory(name, count) {
            document.getElementById('editCategoryName').value = name;
            document.getElementById('editCategoryCount').value = count;
            document.getElementById('modalEditCategory').classList.remove('hidden');
            
            // Find and store the row being edited
            const rows = document.querySelectorAll('#categoryTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === name) {
                    currentEditRow = row;
                }
            });
        }

        // Save Category
        function saveCategory() {
            const name = document.getElementById('editCategoryName').value.trim();
            const count = document.getElementById('editCategoryCount').value;

            if (!name) {
                alert('Nama kategori harus diisi!');
                return;
            }

            if (currentEditRow) {
                currentEditRow.cells[0].textContent = name;
                currentEditRow.cells[1].querySelector('span').textContent = count;
                currentEditRow.cells[2].querySelector('button').setAttribute('onclick', `editCategory('${name}', ${count})`);
            }

            closeModal('modalEditCategory');
            alert('✓ Kategori berhasil diupdate!');
        }

        // Delete Category
        function deleteCategory(btn) {
            if (confirm('Yakin ingin menghapus kategori ini?')) {
                btn.closest('tr').remove();
                alert('✓ Kategori berhasil dihapus!');
            }
        }

        // Add Tag
        document.getElementById('formAddTag').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('newTagName').value.trim();

            if (!name) {
                alert('Nama tag harus diisi!');
                return;
            }

            const tbody = document.getElementById('tagTableBody');
            const newRow = tbody.insertRow(0);
            newRow.className = 'border-b border-gray-300 table-row';
            newRow.innerHTML = `
                <td class="py-2 px-2">
                    <span class="text-gray-700 text-xs font-medium">
                        <i class="fas fa-tag mr-1"></i> ${name}
                    </span>
                </td>
                <td class="py-2 px-2 text-center">
                    <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">0</span>
                </td>
                <td class="py-2 px-2 text-center">
                    <button onclick="editTag('${name}', 0)" class="btn-action text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td class="py-2 px-2 text-center">
                    <button onclick="deleteTag(this)" class="btn-action text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            document.getElementById('newTagName').value = '';
            alert('✓ Tag berhasil ditambahkan!');
        });

        // Edit Tag
        function editTag(name, count) {
            document.getElementById('editTagName').value = name;
            document.getElementById('editTagCount').value = count;
            document.getElementById('modalEditTag').classList.remove('hidden');
            
            // Find and store the row being edited
            const rows = document.querySelectorAll('#tagTableBody tr');
            rows.forEach(row => {
                const tagName = row.cells[0].querySelector('span').textContent.trim().replace('', '').trim();
                if (tagName === name) {
                    currentEditRow = row;
                }
            });
        }

        // Save Tag
        function saveTag() {
            const name = document.getElementById('editTagName').value.trim();
            const count = document.getElementById('editTagCount').value;

            if (!name) {
                alert('Nama tag harus diisi!');
                return;
            }

            if (currentEditRow) {
                const tagSpan = currentEditRow.cells[0].querySelector('span');
                tagSpan.innerHTML = `<i class="fas fa-tag mr-1"></i> ${name}`;
                currentEditRow.cells[1].querySelector('span').textContent = count;
                currentEditRow.cells[2].querySelector('button').setAttribute('onclick', `editTag('${name}', ${count})`);
            }

            closeModal('modalEditTag');
            alert('✓ Tag berhasil diupdate!');
        }

        // Delete Tag
        function deleteTag(btn) {
            if (confirm('Yakin ingin menghapus tag ini?')) {
                btn.closest('tr').remove();
                alert('✓ Tag berhasil dihapus!');
            }
        }

        // Close Modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            currentEditRow = null;
        }

        // Close modal on outside click
        document.querySelectorAll('[id^="modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });
    </script>
</body>
</html>
@endsection