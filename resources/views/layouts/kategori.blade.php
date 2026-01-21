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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-3">
                <i class="fas fa-layer-group text-indigo-600"></i>
                Kelola Kategori
            </h1>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Tambah Kategori -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-5 pb-3 border-b-2 border-indigo-100">
                    Tambah Kategori
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                        <input 
                            type="text" 
                            id="inputKategori" 
                            placeholder="Masukkan nama kategori" 
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm"
                        >
                    </div>
                    <button 
                        onclick="tambahKategori()" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2.5 rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-200 shadow-md hover:shadow-lg text-sm"
                    >
                        <i class="fas fa-plus-circle mr-2"></i>Simpan
                    </button>
                </div>
            </div>

            <!-- Tabel Kategori -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-5 pb-3 border-b-2 border-indigo-100">
                    Tabel Kategori
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="text-left py-3 px-3 font-semibold text-gray-700">Nama Kategori</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Jumlah</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Edit</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="tabelKategori">
                            <tr class="border-b border-gray-50 hover:bg-indigo-50 transition-colors">
                                <td class="py-3 px-3 font-medium text-gray-800">Teknologi</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">12</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="editKategori('Teknologi', 12)" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="hapusKategori('Teknologi')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-50 hover:bg-indigo-50 transition-colors">
                                <td class="py-3 px-3 font-medium text-gray-800">Bisnis</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">8</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="editKategori('Bisnis', 8)" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="hapusKategori('Bisnis')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition-colors">
                                <td class="py-3 px-3 font-medium text-gray-800">Pendidikan</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">15</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="editKategori('Pendidikan', 15)" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="hapusKategori('Pendidikan')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tambah Tag -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-5 pb-3 border-b-2 border-indigo-100">
                    Tambah Tag
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Tag</label>
                        <input 
                            type="text" 
                            id="inputTag" 
                            placeholder="Masukkan nama tag" 
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm"
                        >
                    </div>
                    <button 
                        onclick="tambahTag()" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2.5 rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-200 shadow-md hover:shadow-lg text-sm"
                    >
                        <i class="fas fa-plus-circle mr-2"></i>Simpan
                    </button>
                </div>
            </div>

            <!-- Tabel Tag -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-5 pb-3 border-b-2 border-indigo-100">
                    Tabel Tag
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="text-left py-3 px-3 font-semibold text-gray-700">Nama Tag</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Jumlah</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Edit</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="tabelTag">
                            <tr class="border-b border-gray-50 hover:bg-indigo-50 transition-colors">
                                <td class="py-3 px-3 font-medium text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-tag text-indigo-600 text-xs"></i>
                                    Programming
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">25</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="editTag('Programming', 25)" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="hapusTag('Programming')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-50 hover:bg-indigo-50 transition-colors">
                                <td class="py-3 px-3 font-medium text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-tag text-indigo-600 text-xs"></i>
                                    Design
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">18</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="editTag('Design', 18)" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="hapusTag('Design')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition-colors">
                                <td class="py-3 px-3 font-medium text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-tag text-indigo-600 text-xs"></i>
                                    Tutorial
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">32</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="editTag('Tutorial', 32)" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button onclick="hapusTag('Tutorial')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
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
    <div id="modalEditKategori" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-5 rounded-t-2xl">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Kategori
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" id="editNamaKategori" 
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                    <input type="number" id="editJumlahKategori" 
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                </div>
                <div class="flex gap-3 pt-2">
                    <button onclick="simpanEditKategori()" 
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2.5 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md text-sm">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <button onclick="tutupModalEditKategori()" 
                        class="flex-1 bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg hover:bg-gray-300 transition-all text-sm">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tag -->
    <div id="modalEditTag" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-5 rounded-t-2xl">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Tag
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Tag</label>
                    <input type="text" id="editNamaTag" 
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                    <input type="number" id="editJumlahTag" 
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                </div>
                <div class="flex gap-3 pt-2">
                    <button onclick="simpanEditTag()" 
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2.5 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md text-sm">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <button onclick="tutupModalEditTag()" 
                        class="flex-1 bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg hover:bg-gray-300 transition-all text-sm">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let kategoriEdit = null;
        let tagEdit = null;

        function tambahKategori() {
            const input = document.getElementById('inputKategori');
            const nama = input.value.trim();
            
            if (nama === '') {
                alert('Nama kategori tidak boleh kosong!');
                return;
            }

            const tabel = document.getElementById('tabelKategori');
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-50 hover:bg-indigo-50 transition-colors';
            row.innerHTML = `
                <td class="py-3 px-3 font-medium text-gray-800">${nama}</td>
                <td class="py-3 px-3 text-center">
                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">0</span>
                </td>
                <td class="py-3 px-3 text-center">
                    <button onclick="editKategori('${nama}', 0)" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td class="py-3 px-3 text-center">
                    <button onclick="hapusKategori('${nama}')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tabel.appendChild(row);
            input.value = '';
        }

        function tambahTag() {
            const input = document.getElementById('inputTag');
            const nama = input.value.trim();
            
            if (nama === '') {
                alert('Nama tag tidak boleh kosong!');
                return;
            }

            const tabel = document.getElementById('tabelTag');
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-50 hover:bg-indigo-50 transition-colors';
            row.innerHTML = `
                <td class="py-3 px-3 font-medium text-gray-800 flex items-center gap-2">
                    <i class="fas fa-tag text-indigo-600 text-xs"></i>
                    ${nama}
                </td>
                <td class="py-3 px-3 text-center">
                    <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">0</span>
                </td>
                <td class="py-3 px-3 text-center">
                    <button onclick="editTag('${nama}', 0)" class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 p-2 rounded-lg transition-all">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td class="py-3 px-3 text-center">
                    <button onclick="hapusTag('${nama}')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tabel.appendChild(row);
            input.value = '';
        }

        function editKategori(nama, jumlah) {
            kategoriEdit = nama;
            document.getElementById('editNamaKategori').value = nama;
            document.getElementById('editJumlahKategori').value = jumlah;
            document.getElementById('modalEditKategori').classList.remove('hidden');
        }

        function tutupModalEditKategori() {
            document.getElementById('modalEditKategori').classList.add('hidden');
            kategoriEdit = null;
        }

        function simpanEditKategori() {
            const namaBaru = document.getElementById('editNamaKategori').value.trim();
            const jumlahBaru = document.getElementById('editJumlahKategori').value;
            
            if (namaBaru === '') {
                alert('Nama kategori tidak boleh kosong!');
                return;
            }

            const rows = document.querySelectorAll('#tabelKategori tr');
            rows.forEach(row => {
                const namaCell = row.cells[0];
                if (namaCell && namaCell.textContent === kategoriEdit) {
                    namaCell.textContent = namaBaru;
                    row.cells[1].querySelector('span').textContent = jumlahBaru;
                    row.cells[2].querySelector('button').onclick = () => editKategori(namaBaru, jumlahBaru);
                    row.cells[3].querySelector('button').onclick = () => hapusKategori(namaBaru);
                }
            });

            tutupModalEditKategori();
        }

        function editTag(nama, jumlah) {
            tagEdit = nama;
            document.getElementById('editNamaTag').value = nama;
            document.getElementById('editJumlahTag').value = jumlah;
            document.getElementById('modalEditTag').classList.remove('hidden');
        }

        function tutupModalEditTag() {
            document.getElementById('modalEditTag').classList.add('hidden');
            tagEdit = null;
        }

        function simpanEditTag() {
            const namaBaru = document.getElementById('editNamaTag').value.trim();
            const jumlahBaru = document.getElementById('editJumlahTag').value;
            
            if (namaBaru === '') {
                alert('Nama tag tidak boleh kosong!');
                return;
            }

            const rows = document.querySelectorAll('#tabelTag tr');
            rows.forEach(row => {
                const namaCell = row.cells[0];
                if (namaCell) {
                    const textContent = namaCell.textContent.trim();
                    if (textContent === tagEdit) {
                        namaCell.innerHTML = `
                            <i class="fas fa-tag text-indigo-600 text-xs"></i>
                            ${namaBaru}
                        `;
                        row.cells[1].querySelector('span').textContent = jumlahBaru;
                        row.cells[2].querySelector('button').onclick = () => editTag(namaBaru, jumlahBaru);
                        row.cells[3].querySelector('button').onclick = () => hapusTag(namaBaru);
                    }
                }
            });

            tutupModalEditTag();
        }

        function hapusKategori(nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus kategori "${nama}"?`)) {
                const rows = document.querySelectorAll('#tabelKategori tr');
                rows.forEach(row => {
                    const namaCell = row.cells[0];
                    if (namaCell && namaCell.textContent === nama) {
                        row.remove();
                    }
                });
            }
        }

        function hapusTag(nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus tag "${nama}"?`)) {
                const rows = document.querySelectorAll('#tabelTag tr');
                rows.forEach(row => {
                    const namaCell = row.cells[0];
                    if (namaCell) {
                        const textContent = namaCell.textContent.trim();
                        if (textContent === nama) {
                            row.remove();
                        }
                    }
                });
            }
        }

        // Tutup modal saat klik di luar
        document.getElementById('modalEditKategori').addEventListener('click', function(e) {
            if (e.target === this) {
                tutupModalEditKategori();
            }
        });

        document.getElementById('modalEditTag').addEventListener('click', function(e) {
            if (e.target === this) {
                tutupModalEditTag();
            }
        });
    </script>
</body>
</html>
@endsection