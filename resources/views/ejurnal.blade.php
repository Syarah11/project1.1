@extends('layouts.app')

@section('title', 'E-Jurnal - Portal Blog')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola E-Jurnal</title>
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
            max-width: 80px;
            max-height: 60px;
            object-fit: cover;
        }

        .image-gallery {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .description-text {
            max-height: 80px;
            overflow-y: auto;
        }

        .description-text::-webkit-scrollbar {
            width: 4px;
        }

        .description-text::-webkit-scrollbar-thumb {
            background: #8b5cf6;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <h1 class="text-2xl font-bold mb-6">Kelola E-Jurnal</h1>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tambah Jurnal (1/3 width) -->
            <div class="card rounded-lg p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tambah Jurnal</h2>
                <form id="formAddJournal" class="space-y-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Judul</label>
                        <input type="text" 
                               id="newJournalTitle"
                               placeholder="Judul jurnal"
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Deskripsi</label>
                        <textarea id="newJournalDesc"
                                  placeholder="Deskripsi 1&#10;Deskripsi 2&#10;Deskripsi 3&#10;(Pisahkan dengan enter)"
                                  rows="4"
                                  class="w-full px-3 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">User Name</label>
                        <input type="text" 
                               id="newJournalUser"
                               placeholder="Nama pengguna"
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Gambar (Multiple)</label>
                        <div class="bg-white border border-gray-300 rounded p-3 min-h-[100px] flex items-center justify-center cursor-pointer hover:bg-gray-50 transition"
                             onclick="document.getElementById('newJournalImage').click()">
                            <div id="previewContainer" class="text-center w-full">
                                <i class="fas fa-images text-gray-400 text-3xl mb-2"></i>
                                <p class="text-xs text-gray-500">Klik untuk upload gambar (Multiple)</p>
                            </div>
                        </div>
                        <input type="file" 
                               id="newJournalImage" 
                               accept="image/*"
                               multiple
                               class="hidden"
                               onchange="previewImages(this, 'previewContainer')">
                    </div>

                    <div class="flex justify-center pt-2">
                        <button type="submit" 
                                class="btn-upload text-white px-8 py-2 rounded font-medium text-sm">
                            <i class="fas fa-plus mr-2"></i>Tambah Jurnal
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel E-Jurnal (2/3 width) -->
            <div class="lg:col-span-2 card rounded-lg p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tabel Ejurnal</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-400">
                                <th class="text-left py-2 px-2 font-semibold text-xs">No</th>
                                <th class="text-left py-2 px-2 font-semibold text-xs">Judul</th>
                                <th class="text-left py-2 px-2 font-semibold text-xs">Deskripsi</th>
                                <th class="text-left py-2 px-2 font-semibold text-xs">User Name</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Gambar</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Edit</th>
                                <th class="text-center py-2 px-2 font-semibold text-xs">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="journalTableBody">
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">1</td>
                                <td class="py-3 px-2 font-medium">Machine Learning</td>
                                <td class="py-3 px-2">
                                    <div class="description-text text-xs text-gray-600 space-y-1">
                                        <p>• Implementasi algoritma supervised learning untuk prediksi data</p>
                                        <p>• Penerapan neural networks dalam computer vision dan image recognition</p>
                                        <p>• Optimasi model dengan deep learning framework seperti TensorFlow</p>
                                    </div>
                                </td>
                                <td class="py-3 px-2">Dr. Ahmad</td>
                                <td class="py-3 px-2">
                                    <div class="image-gallery">
                                        <img src="https://images.unsplash.com/photo-1555255707-c07966088b7b?w=200&h=150&fit=crop" 
                                             alt="ML" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=200&h=150&fit=crop" 
                                             alt="AI" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1507146153580-69a1fe6d8aa1?w=200&h=150&fit=crop" 
                                             alt="Neural" class="image-preview rounded border border-gray-300">
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editJournal(1)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteJournal(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">2</td>
                                <td class="py-3 px-2 font-medium">Big Data Analytics</td>
                                <td class="py-3 px-2">
                                    <div class="description-text text-xs text-gray-600 space-y-1">
                                        <p>• Analisis data skala besar menggunakan Apache Hadoop dan Spark</p>
                                        <p>• Visualisasi data real-time dengan Tableau dan Power BI</p>
                                        <p>• Implementasi data warehouse untuk business intelligence</p>
                                    </div>
                                </td>
                                <td class="py-3 px-2">Prof. Siti</td>
                                <td class="py-3 px-2">
                                    <div class="image-gallery">
                                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=200&h=150&fit=crop" 
                                             alt="Analytics" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=200&h=150&fit=crop" 
                                             alt="Dashboard" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=200&h=150&fit=crop" 
                                             alt="Data" class="image-preview rounded border border-gray-300">
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editJournal(2)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteJournal(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">3</td>
                                <td class="py-3 px-2 font-medium">IoT Smart City</td>
                                <td class="py-3 px-2">
                                    <div class="description-text text-xs text-gray-600 space-y-1">
                                        <p>• Sistem monitoring lingkungan dengan sensor IoT berbasis cloud</p>
                                        <p>• Smart parking dan traffic management system terintegrasi</p>
                                        <p>• Integrasi IoT dengan cloud computing infrastructure AWS</p>
                                    </div>
                                </td>
                                <td class="py-3 px-2">Dr. Budi</td>
                                <td class="py-3 px-2">
                                    <div class="image-gallery">
                                        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=200&h=150&fit=crop" 
                                             alt="IoT" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=200&h=150&fit=crop" 
                                             alt="Smart City" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=200&h=150&fit=crop" 
                                             alt="City Tech" class="image-preview rounded border border-gray-300">
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editJournal(3)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteJournal(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">4</td>
                                <td class="py-3 px-2 font-medium">Blockchain Technology</td>
                                <td class="py-3 px-2">
                                    <div class="description-text text-xs text-gray-600 space-y-1">
                                        <p>• Implementasi smart contracts pada platform Ethereum</p>
                                        <p>• Cryptocurrency mining dan distributed ledger technology</p>
                                        <p>• Blockchain untuk supply chain management dan traceability</p>
                                    </div>
                                </td>
                                <td class="py-3 px-2">Dr. Rina</td>
                                <td class="py-3 px-2">
                                    <div class="image-gallery">
                                        <img src="https://images.unsplash.com/photo-1639762681485-074b7f938ba0?w=200&h=150&fit=crop" 
                                             alt="Blockchain" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1621416894569-0f39ed31d247?w=200&h=150&fit=crop" 
                                             alt="Crypto" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1622630998477-20aa696ecb05?w=200&h=150&fit=crop" 
                                             alt="Bitcoin" class="image-preview rounded border border-gray-300">
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editJournal(4)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteJournal(this)" class="btn-action text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-300 table-row">
                                <td class="py-3 px-2">5</td>
                                <td class="py-3 px-2 font-medium">Cybersecurity</td>
                                <td class="py-3 px-2">
                                    <div class="description-text text-xs text-gray-600 space-y-1">
                                        <p>• Penetration testing dan vulnerability assessment sistem</p>
                                        <p>• Enkripsi data dan secure communication protocols</p>
                                        <p>• Incident response dan threat intelligence analysis</p>
                                    </div>
                                </td>
                                <td class="py-3 px-2">Prof. Hendra</td>
                                <td class="py-3 px-2">
                                    <div class="image-gallery">
                                        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=200&h=150&fit=crop" 
                                             alt="Security" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=200&h=150&fit=crop" 
                                             alt="Lock" class="image-preview rounded border border-gray-300">
                                        <img src="https://images.unsplash.com/photo-1614064641938-3bbee52942c7?w=200&h=150&fit=crop" 
                                             alt="Cyber" class="image-preview rounded border border-gray-300">
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="editJournal(5)" class="btn-action text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <button onclick="deleteJournal(this)" class="btn-action text-red-600 hover:text-red-800">
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

    <!-- Modal Edit Jurnal -->
    <div id="modalEditJournal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="modal bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6">
                <h3 class="text-white text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Jurnal
                </h3>
            </div>
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" 
                           id="editJournalTitle"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (pisahkan dengan enter)</label>
                    <textarea id="editJournalDesc"
                              rows="5"
                              placeholder="Deskripsi 1&#10;Deskripsi 2&#10;Deskripsi 3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">User Name</label>
                    <input type="text" 
                           id="editJournalUser"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <div id="editPreviewContainer" class="border border-gray-300 rounded-lg p-4 bg-gray-50 flex flex-wrap gap-2 min-h-[100px]">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Baru (Multiple - Opsional)</label>
                    <input type="file" 
                           id="editJournalImage" 
                           accept="image/*"
                           multiple
                           onchange="previewEditImages(this)"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div class="flex gap-3 pt-4">
                    <button onclick="closeModal('modalEditJournal')" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button onclick="saveJournal()" class="flex-1 btn-upload text-white py-3 rounded-lg font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentEditRow = null;
        let currentImageFiles = [];

        // Preview multiple images for new journal
        function previewImages(input, containerId) {
            const container = document.getElementById(containerId);
            currentImageFiles = [];
            
            if (input.files && input.files.length > 0) {
                container.innerHTML = '<div class="image-gallery w-full"></div>';
                const gallery = container.querySelector('.image-gallery');
                
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'image-preview rounded border border-gray-300';
                        gallery.appendChild(img);
                        currentImageFiles.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Preview images for edit modal
        function previewEditImages(input) {
            const container = document.getElementById('editPreviewContainer');
            
            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach((file) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'image-preview rounded border border-gray-300';
                        container.appendChild(img);
                        currentImageFiles.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Add Journal
        function addJournal(e) {
            if (e) e.preventDefault();
            
            const title = document.getElementById('newJournalTitle').value.trim();
            const desc = document.getElementById('newJournalDesc').value.trim();
            const user = document.getElementById('newJournalUser').value.trim();

            if (!title || !desc || !user) {
                alert('Semua field harus diisi!');
                return;
            }

            if (currentImageFiles.length === 0) {
                alert('Minimal upload 1 gambar!');
                return;
            }

            const tbody = document.getElementById('journalTableBody');
            const rowCount = tbody.rows.length + 1;
            const newRow = tbody.insertRow(0);
            newRow.className = 'border-b border-gray-300 table-row';

            // Format descriptions
            const descriptions = desc.split('\n').filter(d => d.trim()).map(d => `<p>• ${d}</p>`).join('');
            
            // Format images
            const imagesHtml = currentImageFiles.map(img => 
                `<img src="${img}" alt="Journal" class="image-preview rounded border border-gray-300">`
            ).join('');

            newRow.innerHTML = `
                <td class="py-3 px-2">${rowCount}</td>
                <td class="py-3 px-2 font-medium">${title}</td>
                <td class="py-3 px-2">
                    <div class="description-text text-xs text-gray-600 space-y-1">
                        ${descriptions}
                    </div>
                </td>
                <td class="py-3 px-2">${user}</td>
                <td class="py-3 px-2">
                    <div class="image-gallery">
                        ${imagesHtml}
                    </div>
                </td>
                <td class="py-3 px-2 text-center">
                    <button onclick="editJournal(${rowCount})" class="btn-action text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td class="py-3 px-2 text-center">
                    <button onclick="deleteJournal(this)" class="btn-action text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            // Reset form
            document.getElementById('formAddJournal').reset();
            document.getElementById('previewContainer').innerHTML = `
                <i class="fas fa-images text-gray-400 text-3xl mb-2"></i>
                <p class="text-xs text-gray-500">Klik untuk upload gambar (Multiple)</p>
            `;
            currentImageFiles = [];

            updateRowNumbers();
            alert('✓ Jurnal berhasil ditambahkan!');
        }

        // Edit Journal
        function editJournal(id) {
            const rows = document.querySelectorAll('#journalTableBody tr');
            const row = rows[id - 1];
            
            if (!row) return;

            currentEditRow = row;
            currentImageFiles = [];

            document.getElementById('editJournalTitle').value = row.cells[1].textContent;
            
            // Get descriptions
            const descElements = row.cells[2].querySelectorAll('p');
            const descriptions = Array.from(descElements).map(p => p.textContent.replace('• ', '')).join('\n');
            document.getElementById('editJournalDesc').value = descriptions;
            
            document.getElementById('editJournalUser').value = row.cells[3].textContent;
            
            // Show current images
            const images = row.cells[4].querySelectorAll('img');
            const container = document.getElementById('editPreviewContainer');
            container.innerHTML = '';
            images.forEach(img => {
                const newImg = img.cloneNode(true);
                container.appendChild(newImg);
            });
            
            document.getElementById('modalEditJournal').classList.remove('hidden');
        }

        // Save Journal
        function saveJournal() {
            const title = document.getElementById('editJournalTitle').value.trim();
            const desc = document.getElementById('editJournalDesc').value.trim();
            const user = document.getElementById('editJournalUser').value.trim();

            if (!title || !desc || !user) {
                alert('Semua field harus diisi!');
                return;
            }

            if (currentEditRow) {
                currentEditRow.cells[1].textContent = title;
                
                // Update descriptions
                const descriptions = desc.split('\n').filter(d => d.trim()).map(d => `<p>• ${d}</p>`).join('');
                currentEditRow.cells[2].querySelector('.description-text').innerHTML = descriptions;
                
                currentEditRow.cells[3].textContent = user;
                
                // Update images if new ones uploaded
                if (currentImageFiles.length > 0) {
                    const imagesHtml = currentImageFiles.map(img => 
                        `<img src="${img}" alt="Journal" class="image-preview rounded border border-gray-300">`
                    ).join('');
                    currentEditRow.cells[4].querySelector('.image-gallery').innerHTML = imagesHtml;
                }
            }

            closeModal('modalEditJournal');
            currentImageFiles = [];
            document.getElementById('editJournalImage').value = '';
            alert('✓ Jurnal berhasil diupdate!');
        }

        // Delete Journal
        function deleteJournal(btn) {
            if (confirm('Yakin ingin menghapus jurnal ini?')) {
                btn.closest('tr').remove();
                updateRowNumbers();
                alert('✓ Jurnal berhasil dihapus!');
            }
        }

        // Update row numbers
        function updateRowNumbers() {
            const rows = document.querySelectorAll('#journalTableBody tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
        }

        // Close Modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            currentEditRow = null;
            currentImageFiles = [];
        }

        // Handle form submit
        document.getElementById('formAddJournal').addEventListener('submit', addJournal);

        // Close modal on outside click
        document.getElementById('modalEditJournal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('modalEditJournal');
            }
        });
    </script>
</body>
</html>



@endsection