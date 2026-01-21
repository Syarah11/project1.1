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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-3">
                <i class="fas fa-ad text-indigo-600"></i>
                Kelola Iklan
            </h1>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tambah Iklan -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-5 pb-3 border-b-2 border-indigo-100">
                    Tambah Iklan
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul</label>
                        <input 
                            type="text" 
                            id="inputJudul" 
                            placeholder="Masukkan judul iklan" 
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe</label>
                        <select 
                            id="inputTipe" 
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm"
                        >
                            <option value="">Pilih tipe iklan</option>
                            <option value="Banner">Banner</option>
                            <option value="Sidebar">Sidebar</option>
                            <option value="Pop-up">Pop-up</option>
                            <option value="Video">Video</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Link</label>
                        <input 
                            type="url" 
                            id="inputLink" 
                            placeholder="https://example.com" 
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar</label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="file" 
                                id="inputGambar" 
                                accept="image/*"
                                class="hidden"
                                onchange="previewGambar(event)"
                            >
                            <label for="inputGambar" class="flex-1 px-4 py-2.5 border-2 border-gray-200 rounded-lg text-sm text-gray-500 cursor-pointer hover:border-indigo-500 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-image"></i>
                                <span id="namaFile">Pilih gambar</span>
                            </label>
                        </div>
                        <div id="previewContainer" class="hidden mt-3">
                            <img id="previewImage" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                    </div>
                    
                    <button 
                        onclick="tambahIklan()" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2.5 rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-200 shadow-md hover:shadow-lg text-sm"
                    >
                        <i class="fas fa-upload mr-2"></i>Upload
                    </button>
                </div>
            </div>

            <!-- Tabel Iklan -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-5 pb-3 border-b-2 border-indigo-100">
                    Tabel Iklan
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="text-left py-3 px-2 font-semibold text-gray-700">No</th>
                                <th class="text-left py-3 px-2 font-semibold text-gray-700">Judul</th>
                                <th class="text-left py-3 px-2 font-semibold text-gray-700">Tipe</th>
                                <th class="text-left py-3 px-2 font-semibold text-gray-700">Link</th>
                                <th class="text-center py-3 px-2 font-semibold text-gray-700">Gambar</th>
                                <th class="text-center py-3 px-2 font-semibold text-gray-700">Edit</th>
                                <th class="text-center py-3 px-2 font-semibold text-gray-700">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="tabelIklan">
                            <tr class="border-b border-gray-50 hover:bg-indigo-50 transition-colors">
                                <td class="py-3 px-2 font-medium text-gray-800">1</td>
                                <td class="py-3 px-2 font-medium text-gray-800">Promo Spesial</td>
                                <td class="py-3 px-2">
                                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-2 py-1 rounded-full text-xs font-semibold">Banner</span>
                                </td>
                                <td class="py-3 px-2">
                                    <a href="https://example.com" target="_blank" class="text-indigo-600 hover:underline text-xs">example.com</a>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="lihatGambar('https://via.placeholder.com/300x150')" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-image"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editIklan(1, 'Promo Spesial', 'Banner', 'https://example.com', 'https://via.placeholder.com/300x150')" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="hapusIklan(1)" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-50 hover:bg-indigo-50 transition-colors">
                                <td class="py-3 px-2 font-medium text-gray-800">2</td>
                                <td class="py-3 px-2 font-medium text-gray-800">Diskon Akhir Tahun</td>
                                <td class="py-3 px-2">
                                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-2 py-1 rounded-full text-xs font-semibold">Sidebar</span>
                                </td>
                                <td class="py-3 px-2">
                                    <a href="https://promo.com" target="_blank" class="text-indigo-600 hover:underline text-xs">promo.com</a>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="lihatGambar('https://via.placeholder.com/300x150')" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-image"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editIklan(2, 'Diskon Akhir Tahun', 'Sidebar', 'https://promo.com', 'https://via.placeholder.com/300x150')" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="hapusIklan(2)" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
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
    <div id="modalEditIklan" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-5 rounded-t-2xl sticky top-0">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Iklan
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="editIdIklan">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul</label>
                    <input type="text" id="editJudul" 
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe</label>
                    <select id="editTipe" 
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                        <option value="Banner">Banner</option>
                        <option value="Sidebar">Sidebar</option>
                        <option value="Pop-up">Pop-up</option>
                        <option value="Video">Video</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Link</label>
                    <input type="url" id="editLink" 
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar</label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="file" 
                            id="editInputGambar" 
                            accept="image/*"
                            class="hidden"
                            onchange="previewEditGambar(event)"
                        >
                        <label for="editInputGambar" class="flex-1 px-4 py-2.5 border-2 border-gray-200 rounded-lg text-sm text-gray-500 cursor-pointer hover:border-indigo-500 transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-image"></i>
                            <span>Ganti gambar</span>
                        </label>
                    </div>
                    <div id="editPreviewContainer" class="mt-3">
                        <img id="editPreviewImage" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                    </div>
                </div>
                
                <div class="flex gap-3 pt-2">
                    <button onclick="simpanEditIklan()" 
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2.5 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md text-sm">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <button onclick="tutupModalEditIklan()" 
                        class="flex-1 bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg hover:bg-gray-300 transition-all text-sm">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lihat Gambar -->
    <div id="modalLihatGambar" class="hidden fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="tutupModalLihatGambar()">
        <div class="max-w-4xl w-full">
            <div class="bg-white rounded-2xl p-4">
                <img id="gambarModal" class="w-full h-auto rounded-lg">
            </div>
        </div>
    </div>

    <script>
        let iklanCounter = 3;
        let currentEditId = null;
        let currentImage = null;
        let editImage = null;

        function previewGambar(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('namaFile').textContent = file.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentImage = e.target.result;
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('previewContainer').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function previewEditGambar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    editImage = e.target.result;
                    document.getElementById('editPreviewImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function tambahIklan() {
            const judul = document.getElementById('inputJudul').value.trim();
            const tipe = document.getElementById('inputTipe').value;
            const link = document.getElementById('inputLink').value.trim();
            
            if (judul === '' || tipe === '' || link === '') {
                alert('Semua field harus diisi!');
                return;
            }

            if (!currentImage) {
                alert('Silakan pilih gambar!');
                return;
            }

            const tabel = document.getElementById('tabelIklan');
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-50 hover:bg-indigo-50 transition-colors';
            row.id = `iklan-${iklanCounter}`;
            row.innerHTML = `
                <td class="py-3 px-2 font-medium text-gray-800">${iklanCounter}</td>
                <td class="py-3 px-2 font-medium text-gray-800">${judul}</td>
                <td class="py-3 px-2">
                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-2 py-1 rounded-full text-xs font-semibold">${tipe}</span>
                </td>
                <td class="py-3 px-2">
                    <a href="${link}" target="_blank" class="text-indigo-600 hover:underline text-xs">${new URL(link).hostname}</a>
                </td>
                <td class="py-3 px-2 text-center">
                    <button onclick="lihatGambar('${currentImage}')" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                        <i class="fas fa-image"></i>
                    </button>
                </td>
                <td class="py-3 px-2 text-center">
                    <button onclick="editIklan(${iklanCounter}, '${judul}', '${tipe}', '${link}', '${currentImage}')" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td class="py-3 px-2 text-center">
                    <button onclick="hapusIklan(${iklanCounter})" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tabel.appendChild(row);

            // Reset form
            document.getElementById('inputJudul').value = '';
            document.getElementById('inputTipe').value = '';
            document.getElementById('inputLink').value = '';
            document.getElementById('inputGambar').value = '';
            document.getElementById('namaFile').textContent = 'Pilih gambar';
            document.getElementById('previewContainer').classList.add('hidden');
            currentImage = null;
            iklanCounter++;
        }

        function editIklan(id, judul, tipe, link, gambar) {
            currentEditId = id;
            document.getElementById('editIdIklan').value = id;
            document.getElementById('editJudul').value = judul;
            document.getElementById('editTipe').value = tipe;
            document.getElementById('editLink').value = link;
            document.getElementById('editPreviewImage').src = gambar;
            editImage = gambar;
            document.getElementById('modalEditIklan').classList.remove('hidden');
        }

        function tutupModalEditIklan() {
            document.getElementById('modalEditIklan').classList.add('hidden');
            currentEditId = null;
            editImage = null;
        }

        function simpanEditIklan() {
            const judul = document.getElementById('editJudul').value.trim();
            const tipe = document.getElementById('editTipe').value;
            const link = document.getElementById('editLink').value.trim();
            
            if (judul === '' || tipe === '' || link === '') {
                alert('Semua field harus diisi!');
                return;
            }

            const row = document.getElementById(`iklan-${currentEditId}`);
            if (row) {
                row.cells[1].textContent = judul;
                row.cells[2].innerHTML = `<span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-2 py-1 rounded-full text-xs font-semibold">${tipe}</span>`;
                row.cells[3].innerHTML = `<a href="${link}" target="_blank" class="text-indigo-600 hover:underline text-xs">${new URL(link).hostname}</a>`;
                row.cells[4].querySelector('button').onclick = () => lihatGambar(editImage);
                row.cells[5].querySelector('button').onclick = () => editIklan(currentEditId, judul, tipe, link, editImage);
            }

            tutupModalEditIklan();
        }

        function hapusIklan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus iklan ini?')) {
                const row = document.getElementById(`iklan-${id}`);
                if (row) {
                    row.remove();
                }
            }
        }

        function lihatGambar(url) {
            document.getElementById('gambarModal').src = url;
            document.getElementById('modalLihatGambar').classList.remove('hidden');
        }

        function tutupModalLihatGambar() {
            document.getElementById('modalLihatGambar').classList.add('hidden');
        }

        // Tutup modal edit saat klik di luar
        document.getElementById('modalEditIklan').addEventListener('click', function(e) {
            if (e.target === this) {
                tutupModalEditIklan();
            }
        });
    </script>
</body>
</html>
@endsection