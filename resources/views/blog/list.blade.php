<!-- resources/views/blog/list.blade.php -->
@extends('layouts.app')

@section('title', 'List Blog - Portal Blog')

@section('content')
<div class="list-blog-container" style="padding: 20px; font-family: Arial, sans-serif;">
    
    <!-- Tambah Blog Button -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('blog.tambah') }}" style="text-decoration: none;">
            <button style="padding: 10px 25px; 
                           background-color: #d0d0d0; 
                           border: none; 
                           border-radius: 6px; 
                           font-size: 14px; 
                           color: #333;
                           cursor: pointer;
                           transition: background-color 0.3s;">
                Tambah Blog
            </button>
        </a>
    </div>
    
    <!-- Tabel Blog -->
    <div class="table-container" style="background-color: #f5f5f5; 
                                        border-radius: 8px;
                                        padding: 20px;
                                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                        overflow-x: auto;">
        
        <!-- Search Box -->
        <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 18px; color: #333; margin: 0;">Tabel Blog</h2>
            <input type="text" 
                   id="searchInput" 
                   placeholder="Cari blog..." 
                   onkeyup="searchTable()"
                   style="padding: 8px 15px; 
                          border: 1px solid #ccc; 
                          border-radius: 5px; 
                          font-size: 14px;
                          width: 250px;">
        </div>
        
        <table id="blogTable" style="width: 100%; 
                                     border-collapse: collapse; 
                                     background-color: white;
                                     border-radius: 6px;
                                     overflow: hidden;">
            <thead>
                <tr style="background-color: #d0d0d0;">
                    <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; font-size: 14px; border-bottom: 2px solid #b0b0b0;">No</th>
                    <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; font-size: 14px; border-bottom: 2px solid #b0b0b0;">Judul</th>
                    <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; font-size: 14px; border-bottom: 2px solid #b0b0b0;">Kategori</th>
                    <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; font-size: 14px; border-bottom: 2px solid #b0b0b0;">Penulis</th>
                    <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; font-size: 14px; border-bottom: 2px solid #b0b0b0;">Tanggal</th>
                    <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; font-size: 14px; border-bottom: 2px solid #b0b0b0;">Views</th>
                    <th style="padding: 12px 15px; text-align: center; font-weight: 600; color: #333; font-size: 14px; border-bottom: 2px solid #b0b0b0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs ?? [] as $index => $blog)
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">{{ $index + 1 }}</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">{{ $blog->judul }}</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">{{ $blog->kategori }}</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">{{ $blog->penulis }}</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">{{ $blog->created_at->format('d/m/Y') }}</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">{{ number_format($blog->views) }}</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <div class="dropdown-container" style="display: inline-block; position: relative;">
                            <button type="button" onclick="toggleDropdown(event, {{ $blog->id }})" class="menu-button" style="padding: 6px 10px; 
                                           background-color: #666; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 4px; 
                                           font-size: 16px; 
                                           cursor: pointer;
                                           transition: background-color 0.3s;">
                                ⋮
                            </button>
                            <div id="dropdown-{{ $blog->id }}" class="dropdown-menu" style="display: none; 
                                        position: absolute; 
                                        right: 0; 
                                        top: 100%; 
                                        background: white; 
                                        border: 1px solid #ddd; 
                                        border-radius: 4px; 
                                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                                        min-width: 120px;
                                        z-index: 1000;
                                        margin-top: 5px;">
                                <a href="{{ route('blog.edit', $blog->id) }}" style="display: block; 
                                          padding: 10px 15px; 
                                          color: #333; 
                                          text-decoration: none; 
                                          font-size: 14px;
                                          border-bottom: 1px solid #eee;
                                          transition: background-color 0.2s;">
                                    📝 Edit
                                </a>
                                <a href="javascript:void(0)" onclick="confirmDelete({{ $blog->id }})" style="display: block; 
                                          padding: 10px 15px; 
                                          color: #f44336; 
                                          text-decoration: none; 
                                          font-size: 14px;
                                          transition: background-color 0.2s;">
                                    🗑️ Hapus
                                </a>
                            </div>
                        </div>
                        <form id="delete-form-{{ $blog->id }}" action="{{ route('blog.destroy', $blog->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <!-- Sample Data -->
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">1</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">Tutorial Laravel untuk Pemula</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Tutorial</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Admin</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">10/01/2026</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">1,250</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <div class="dropdown-container" style="display: inline-block; position: relative;">
                            <button type="button" onclick="toggleDropdown(event, 1)" class="menu-button" style="padding: 6px 10px; 
                                           background-color: #666; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 4px; 
                                           font-size: 16px; 
                                           cursor: pointer;">
                                ⋮
                            </button>
                            <div id="dropdown-1" class="dropdown-menu" style="display: none; 
                                        position: absolute; 
                                        right: 0; 
                                        top: 100%; 
                                        background: white; 
                                        border: 1px solid #ddd; 
                                        border-radius: 4px; 
                                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                                        min-width: 120px;
                                        z-index: 1000;
                                        margin-top: 5px;">
                                <a href="#" style="display: block; padding: 10px 15px; color: #333; text-decoration: none; font-size: 14px; border-bottom: 1px solid #eee;">📝 Edit</a>
                                <a href="javascript:void(0)" onclick="confirmDelete(1)" style="display: block; padding: 10px 15px; color: #f44336; text-decoration: none; font-size: 14px;">🗑️ Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">2</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">Tips Optimasi Website</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Web Development</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Admin</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">08/01/2026</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">7,340</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <div class="dropdown-container" style="display: inline-block; position: relative;">
                            <button type="button" onclick="toggleDropdown(event, 2)" class="menu-button" style="padding: 6px 10px; 
                                           background-color: #666; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 4px; 
                                           font-size: 16px; 
                                           cursor: pointer;">
                                ⋮
                            </button>
                            <div id="dropdown-2" class="dropdown-menu" style="display: none; 
                                        position: absolute; 
                                        right: 0; 
                                        top: 100%; 
                                        background: white; 
                                        border: 1px solid #ddd; 
                                        border-radius: 4px; 
                                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                                        min-width: 120px;
                                        z-index: 1000;
                                        margin-top: 5px;">
                                <a href="#" style="display: block; padding: 10px 15px; color: #333; text-decoration: none; font-size: 14px; border-bottom: 1px solid #eee;">📝 Edit</a>
                                <a href="javascript:void(0)" onclick="confirmDelete(2)" style="display: block; padding: 10px 15px; color: #f44336; text-decoration: none; font-size: 14px;">🗑️ Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">3</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">Mengenal Chart.js dalam 10 Menit</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">JavaScript</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Admin</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">05/01/2026</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">890</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <div class="dropdown-container" style="display: inline-block; position: relative;">
                            <button type="button" onclick="toggleDropdown(event, 3)" class="menu-button" style="padding: 6px 10px; 
                                           background-color: #666; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 4px; 
                                           font-size: 16px; 
                                           cursor: pointer;">
                                ⋮
                            </button>
                            <div id="dropdown-3" class="dropdown-menu" style="display: none; 
                                        position: absolute; 
                                        right: 0; 
                                        top: 100%; 
                                        background: white; 
                                        border: 1px solid #ddd; 
                                        border-radius: 4px; 
                                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                                        min-width: 120px;
                                        z-index: 1000;
                                        margin-top: 5px;">
                                <a href="#" style="display: block; padding: 10px 15px; color: #333; text-decoration: none; font-size: 14px; border-bottom: 1px solid #eee;">📝 Edit</a>
                                <a href="javascript:void(0)" onclick="confirmDelete(3)" style="display: block; padding: 10px 15px; color: #f44336; text-decoration: none; font-size: 14px;">🗑️ Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">4</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">Cara Membuat REST API dengan Laravel</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Backend</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Admin</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">03/01/2026</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">4,560</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <div class="dropdown-container" style="display: inline-block; position: relative;">
                            <button type="button" onclick="toggleDropdown(event, 4)" class="menu-button" style="padding: 6px 10px; 
                                           background-color: #666; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 4px; 
                                           font-size: 16px; 
                                           cursor: pointer;">
                                ⋮
                            </button>
                            <div id="dropdown-4" class="dropdown-menu" style="display: none; 
                                        position: absolute; 
                                        right: 0; 
                                        top: 100%; 
                                        background: white; 
                                        border: 1px solid #ddd; 
                                        border-radius: 4px; 
                                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                                        min-width: 120px;
                                        z-index: 1000;
                                        margin-top: 5px;">
                                <a href="#" style="display: block; padding: 10px 15px; color: #333; text-decoration: none; font-size: 14px; border-bottom: 1px solid #eee;">📝 Edit</a>
                                <a href="javascript:void(0)" onclick="confirmDelete(4)" style="display: block; padding: 10px 15px; color: #f44336; text-decoration: none; font-size: 14px;">🗑️ Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">5</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">Design Pattern dalam PHP</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">PHP</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Admin</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">01/01/2026</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">1,000</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <div class="dropdown-container" style="display: inline-block; position: relative;">
                            <button type="button" onclick="toggleDropdown(event, 5)" class="menu-button" style="padding: 6px 10px; 
                                           background-color: #666; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 4px; 
                                           font-size: 16px; 
                                           cursor: pointer;">
                                ⋮
                            </button>
                            <div id="dropdown-5" class="dropdown-menu" style="display: none; 
                                        position: absolute; 
                                        right: 0; 
                                        top: 100%; 
                                        background: white; 
                                        border: 1px solid #ddd; 
                                        border-radius: 4px; 
                                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                                        min-width: 120px;
                                        z-index: 1000;
                                        margin-top: 5px;">
                                <a href="#" style="display: block; padding: 10px 15px; color: #333; text-decoration: none; font-size: 14px; border-bottom: 1px solid #eee;">📝 Edit</a>
                                <a href="javascript:void(0)" onclick="confirmDelete(5)" style="display: block; padding: 10px 15px; color: #f44336; text-decoration: none; font-size: 14px;">🗑️ Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" style="display: none; 
                             position: fixed; 
                             top: 0; 
                             left: 0; 
                             width: 100%; 
                             height: 100%; 
                             background: rgba(0,0,0,0.5); 
                             z-index: 9999;
                             justify-content: center;
                             align-items: center;">
    <div style="background: white; 
                padding: 30px; 
                border-radius: 8px; 
                max-width: 400px; 
                text-align: center;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
        <h3 style="margin-top: 0; color: #333; font-size: 18px;">Konfirmasi Hapus</h3>
        <p style="color: #666; margin: 20px 0;">Anda yakin ingin menghapus blog ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center; margin-top: 25px;">
            <button onclick="closeDeleteModal()" style="padding: 10px 25px; 
                           background-color: #ccc; 
                           color: #333; 
                           border: none; 
                           border-radius: 5px; 
                           cursor: pointer;
                           font-size: 14px;">
                Tidak
            </button>
            <button onclick="executeDelete()" style="padding: 10px 25px; 
                           background-color: #f44336; 
                           color: white; 
                           border: none; 
                           border-radius: 5px; 
                           cursor: pointer;
                           font-size: 14px;">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<!-- Modal Success -->
<div id="successModal" style="display: none; 
                              position: fixed; 
                              top: 0; 
                              left: 0; 
                              width: 100%; 
                              height: 100%; 
                              background: rgba(0,0,0,0.5); 
                              z-index: 9999;
                              justify-content: center;
                              align-items: center;">
    <div style="background: white; 
                padding: 30px; 
                border-radius: 8px; 
                max-width: 400px; 
                text-align: center;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
        <div style="font-size: 48px; color: #4CAF50; margin-bottom: 15px;">✓</div>
        <h3 style="margin: 0; color: #333; font-size: 18px;">Blog berhasil dihapus</h3>
        <button onclick="closeSuccessModal()" style="margin-top: 25px;
                       padding: 10px 30px; 
                       background-color: #4CAF50; 
                       color: white; 
                       border: none; 
                       border-radius: 5px; 
                       cursor: pointer;
                       font-size: 14px;">
            OK
        </button>
    </div>
</div>

<style>
    button:hover {
        opacity: 0.8;
    }
    
    #blogTable tbody tr:hover {
        background-color: #f9f9f9;
    }
    
    .dropdown-menu a:hover {
        background-color: #f5f5f5;
    }
    
    .menu-button:hover {
        background-color: #555 !important;
    }
</style>

<script>
    let currentDeleteId = null;
    
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('blogTable');
        const tr = table.getElementsByTagName('tr');
        
        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td');
            let found = false;
            
            for (let j = 0; j < td.length - 1; j++) {
                if (td[j]) {
                    let txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            
            tr[i].style.display = found ? '' : 'none';
        }
    }
    
    function toggleDropdown(event, id) {
        event.stopPropagation();
        
        // Close all other dropdowns
        const allDropdowns = document.querySelectorAll('.dropdown-menu');
        allDropdowns.forEach(dropdown => {
            if (dropdown.id !== 'dropdown-' + id) {
                dropdown.style.display = 'none';
            }
        });
        
        // Toggle current dropdown
        const dropdown = document.getElementById('dropdown-' + id);
        if (dropdown) {
            dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
        }
    }
    
    function confirmDelete(id) {
        currentDeleteId = id;
        document.getElementById('deleteModal').style.display = 'flex';
        // Close dropdown
        const dropdown = document.getElementById('dropdown-' + id);
        if (dropdown) dropdown.style.display = 'none';
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        currentDeleteId = null;
    }
    
    function executeDelete() {
        if (currentDeleteId) {
            const form = document.getElementById('delete-form-' + currentDeleteId);
            if (form) {
                form.submit();
            }
            closeDeleteModal();
            document.getElementById('successModal').style.display = 'flex';
        }
    }
    
    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown-container')) {
            const allDropdowns = document.querySelectorAll('.dropdown-menu');
            allDropdowns.forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        }
    });
</script>
@endsection