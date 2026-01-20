@extends('layouts.app')

@section('title', 'Iklan - Portal Blog')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Iklan</title>
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

        .btn-upload {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            transition: all 0.3s ease;
        }

        .btn-upload:hover {
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

        .image-preview {
            max-width: 120px;
            max-height: 80px;
            object-fit: cover;
        }

        .link-text {
            color: #2563eb;
            text-decoration: underline;
            word-break: break-all;
        }

        .link-text:hover {
            color: #1d4ed8;
        }
    </style>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <h1 class="text-2xl font-bold mb-6">Kelola Iklan</h1>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tambah Iklan (1/3 width) -->
            <div class="card rounded-lg p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tambah Iklan</h2>
                <form id="formAddAd" class="space-y-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Judul</label>
                        <input type="text" 
                               id="newAdTitle"
                               placeholder="Judul iklan"
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Tipe</label>
                        <select id="newAdType"
                                class="w-full px-3 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm">
                            <option value="">Pilih posisi iklan</option>
                            <option value="1:1 Slide">1:1 Slide</option>
                            <option value="3:1 Kanan">3:1 Kanan</option>
                            <option value="3:1 Kiri">3:1 Kiri</option>
                            <option value="3:1 Tengah">3:1 Tengah</option>
                            <option value="1:3 Atas">1:3 Atas</option>
                            <option value="1:3 Tengah">1:3 Tengah</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Link</label>
                        <input type="url" 
                               id="newAdLink"
                               placeholder="https://example.com"
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Gambar</label>
                        <div class="bg-white border border-gray-300 rounded p-3 min-h-[100px] flex items-center justify-center cursor-pointer hover:bg-gray-50 transition"
                             onclick="document.getElementById('newAdImage').click()">
                            <div id="previewContainer" class="text-center">
                                <i class="fas fa-image text-gray-400 text-3xl mb-2"></i>
                                <p class="text-xs text-gray-500">Klik untuk upload gambar</p>
                            </div>
                        </div>
                        <input type="file" 
                               id="newAdImage" 
                               accept="image/*" 
                               class="hidden"
                               onchange="previewImage(this, 'previewContainer')">
                    </div>

                    <div class="flex justify-center pt-2">
                        <button type="submit" 
                                class="btn-upload text-white px-8 py-2 rounded font-medium text-sm">
                            <i class="fas fa-plus mr-2"></i>Tambah Iklan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Iklan (2/3 width) -->
            <div class="lg:col-span-2 card rounded-lg p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tabel Iklan</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-400">
                                <th class="text-left py-2 px-2 font-semibold text-xs">No</th>
                                <th class="text-left py-2 px-2 font-semibold text-xs">Judul</th>
                                <th class="text-left py-2 px-2 font-semibold text-xs">Tipe</th>
                                <th class="text-left py-2 px-2 font-semibold text-xs">Link</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Gambar</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Edit</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="adTableBody">
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">1</td>
                                <td class="py-3 px-2 font-medium">Promo Smartphone Terbaru</td>
                                <td class="py-3 px-2">
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">1:1 Slide</span>
                                </td>
                                <td class="py-3 px-2">
                                    <a href="https://example.com/promo" target="_blank" class="link-text text-xs">
                                        https://example.com/promo
                                    </a>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300&h=200&fit=crop" 
                                         alt="Ad" 
                                         class="image-preview mx-auto rounded border border-gray-300">
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editAd(1)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteAd(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">2</td>
                                <td class="py-3 px-2 font-medium">Diskon Laptop Gaming 50%</td>
                                <td class="py-3 px-2">
                                    <span class="inline-block px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">3:1 Kanan</span>
                                </td>
                                <td class="py-3 px-2">
                                    <a href="https://example.com/laptop" target="_blank" class="link-text text-xs">
                                        https://example.com/laptop
                                    </a>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <img src="https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=300&h=200&fit=crop" 
                                         alt="Ad" 
                                         class="image-preview mx-auto rounded border border-gray-300">
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editAd(2)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteAd(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">3</td>
                                <td class="py-3 px-2 font-medium">Kamera DSLR Professional</td>
                                <td class="py-3 px-2">
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">3:1 Kiri</span>
                                </td>
                                <td class="py-3 px-2">
                                    <a href="https://example.com/camera" target="_blank" class="link-text text-xs">
                                        https://example.com/camera
                                    </a>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=300&h=200&fit=crop" 
                                         alt="Ad" 
                                         class="image-preview mx-auto rounded border border-gray-300">
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editAd(3)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteAd(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">4</td>
                                <td class="py-3 px-2 font-medium">Smartwatch Series 5</td>
                                <td class="py-3 px-2">
                                    <span class="inline-block px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">3:1 Tengah</span>
                                </td>
                                <td class="py-3 px-2">
                                    <a href="https://example.com/watch" target="_blank" class="link-text text-xs">
                                        https://example.com/watch
                                    </a>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&h=200&fit=crop" 
                                         alt="Ad" 
                                         class="image-preview mx-auto rounded border border-gray-300">
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editAd(4)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteAd(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">5</td>
                                <td class="py-3 px-2 font-medium">Headphone Wireless Premium</td>
                                <td class="py-3 px-2">
                                    <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs font-medium">1:3 Atas</span>
                                </td>
                                <td class="py-3 px-2">
                                    <a href="https://example.com/headphone" target="_blank" class="link-text text-xs">
                                        https://example.com/headphone
                                    </a>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=200&fit=crop" 
                                         alt="Ad" 
                                         class="image-preview mx-auto rounded border border-gray-300">
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editAd(5)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteAd(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">6</td>
                                <td class="py-3 px-2 font-medium">Tablet Gaming Ultra</td>
                                <td class="py-3 px-2">
                                    <span class="inline-block px-2 py-1 bg-pink-100 text-pink-700 rounded text-xs font-medium">1:3 Tengah</span>
                                </td>
                                <td class="py-3 px-2">
                                    <a href="https://example.com/tablet" target="_blank" class="link-text text-xs">
                                        https://example.com/tablet
                                    </a>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=300&h=200&fit=crop" 
                                         alt="Ad" 
                                         class="image-preview mx-auto rounded border border-gray-300">
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editAd(6)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteAd(this)" class="btn-action text-red-600 hover:text-red-800">
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

    <!-- Modal Edit Iklan -->
    <div id="modalEditAd" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="modal bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6">
                <h3 class="text-white text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Iklan
                </h3>
            </div>
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" 
                           id="editAdTitle"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                    <select id="editAdType"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="1:1 Slide">1:1 Slide</option>
                        <option value="3:1 Kanan">3:1 Kanan</option>
                        <option value="3:1 Kiri">3:1 Kiri</option>
                        <option value="3:1 Tengah">3:1 Tengah</option>
                        <option value="1:3 Atas">1:3 Atas</option>
                        <option value="1:3 Tengah">1:3 Tengah</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link</label>
                    <input type="url" 
                           id="editAdLink"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <div id="editPreviewContainer" class="border border-gray-300 rounded-lg p-4 bg-gray-50 flex items-center justify-center min-h-[150px]">
                        <img id="editCurrentImage" src="" alt="Current" class="max-w-full max-h-[200px] rounded">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Baru (Opsional)</label>
                    <input type="file" 
                           id="editAdImage" 
                           accept="image/*"
                           onchange="previewEditImage(this)"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div class="flex gap-3 pt-4">
                    <button onclick="closeModal('modalEditAd')" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button onclick="saveAd()" class="flex-1 btn-upload text-white py-3 rounded-lg font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentEditRow = null;
        let currentImageFile = null;

        // Get type color
        function getTypeColor(type) {
            const colors = {
                '1:1 Slide': 'bg-blue-100 text-blue-700',
                '3:1 Kanan': 'bg-green-100 text-green-700',
                '3:1 Kiri': 'bg-yellow-100 text-yellow-700',
                '3:1 Tengah': 'bg-red-100 text-red-700',
                '1:3 Atas': 'bg-indigo-100 text-indigo-700',
                '1:3 Tengah': 'bg-pink-100 text-pink-700'
            };
            return colors[type] || 'bg-gray-100 text-gray-700';
        }

        // Preview image for new ad
        function previewImage(input, containerId) {
            const container = document.getElementById(containerId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    container.innerHTML = `
                        <img src="${e.target.result}" class="max-w-full max-h-[100px] rounded">
                    `;
                    currentImageFile = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview image for edit modal
        function previewEditImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('editCurrentImage').src = e.target.result;
                    currentImageFile = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Add Ad
        function addAd(e) {
            if (e) e.preventDefault();
            
            const title = document.getElementById('newAdTitle').value.trim();
            const type = document.getElementById('newAdType').value;
            const link = document.getElementById('newAdLink').value.trim();
            const imageFile = currentImageFile || 'https://via.placeholder.com/120x80/6b7280/ffffff?text=No+Image';

            if (!title || !type || !link) {
                alert('Semua field harus diisi!');
                return;
            }

            // Validate URL
            try {
                new URL(link);
            } catch (e) {
                alert('Link tidak valid! Harus dimulai dengan http:// atau https://');
                return;
            }

            const tbody = document.getElementById('adTableBody');
            const rowCount = tbody.rows.length + 1;
            const newRow = tbody.insertRow(0);
            newRow.className = 'border-b border-gray-300 table-row';
            newRow.innerHTML = `
                <td class="py-3 px-2">${rowCount}</td>
                <td class="py-3 px-2 font-medium">${title}</td>
                <td class="py-3 px-2">
                    <span class="inline-block px-2 py-1 ${getTypeColor(type)} rounded text-xs font-medium">${type}</span>
                </td>
                <td class="py-3 px-2">
                    <a href="${link}" target="_blank" class="link-text text-xs">${link}</a>
                </td>
                <td class="py-3 px-2 text-center">
                    <img src="${imageFile}" alt="Ad" class="image-preview mx-auto rounded border border-gray-300">
                </td>
                <td class="py-3 px-2 text-center">
                    <button onclick="editAd(${rowCount})" class="btn-action text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td class="py-3 px-2 text-center">
                    <button onclick="deleteAd(this)" class="btn-action text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            // Reset form
            document.getElementById('formAddAd').reset();
            document.getElementById('previewContainer').innerHTML = `
                <i class="fas fa-image text-gray-400 text-3xl mb-2"></i>
                <p class="text-xs text-gray-500">Klik untuk upload gambar</p>
            `;
            currentImageFile = null;

            updateRowNumbers();
            alert('✓ Iklan berhasil ditambahkan!');
        }

        // Handle form submit
        document.getElementById('formAddAd').addEventListener('submit', addAd);

        // Edit Ad
        function editAd(id) {
            const rows = document.querySelectorAll('#adTableBody tr');
            const row = rows[id - 1];
            
            if (!row) return;

            currentEditRow = row;

            document.getElementById('editAdTitle').value = row.cells[1].textContent;
            document.getElementById('editAdType').value = row.cells[2].textContent.trim();
            document.getElementById('editAdLink').value = row.cells[3].querySelector('a').href;
            document.getElementById('editCurrentImage').src = row.cells[4].querySelector('img').src;
            
            document.getElementById('modalEditAd').classList.remove('hidden');
        }

        // Save Ad
        function saveAd() {
            const title = document.getElementById('editAdTitle').value.trim();
            const type = document.getElementById('editAdType').value;
            const link = document.getElementById('editAdLink').value.trim();

            if (!title || !type || !link) {
                alert('Semua field harus diisi!');
                return;
            }

            // Validate URL
            try {
                new URL(link);
            } catch (e) {
                alert('Link tidak valid! Harus dimulai dengan http:// atau https://');
                return;
            }

            if (currentEditRow) {
                currentEditRow.cells[1].textContent = title;
                currentEditRow.cells[2].innerHTML = `<span class="inline-block px-2 py-1 ${getTypeColor(type)} rounded text-xs font-medium">${type}</span>`;
                currentEditRow.cells[3].innerHTML = `<a href="${link}" target="_blank" class="link-text text-xs">${link}</a>`;
                
                if (currentImageFile) {
                    currentEditRow.cells[4].querySelector('img').src = currentImageFile;
                }
            }

            closeModal('modalEditAd');
            currentImageFile = null;
            document.getElementById('editAdImage').value = '';
            alert('✓ Iklan berhasil diupdate!');
        }

        // Delete Ad
        function deleteAd(btn) {
            if (confirm('Yakin ingin menghapus iklan ini?')) {
                btn.closest('tr').remove();
                updateRowNumbers();
                alert('✓ Iklan berhasil dihapus!');
            }
        }

        // Update row numbers
        function updateRowNumbers() {
            const rows = document.querySelectorAll('#adTableBody tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
        }

        // Close Modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            currentEditRow = null;
            currentImageFile = null;
        }

        // Close modal on outside click
        document.getElementById('modalEditAd').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('modalEditAd');
            }
        });
    </script>
</body>
</html>
@endsection