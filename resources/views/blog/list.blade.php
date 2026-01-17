<!-- resources/views/blog/list.blade.php -->
@extends('layouts.app')

@section('title', 'List Blog - Portal Blog')

@section('content')
<div class="list-blog-container" style="padding: 20px; font-family: Arial, sans-serif;">
    
    <!-- Title -->
    
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
                        <a href="{{ route('blog.edit', $blog->id) }}" style="text-decoration: none;">
                            <button style="padding: 6px 12px; 
                                           background-color: #4CAF50; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 4px; 
                                           font-size: 12px; 
                                           cursor: pointer;
                                           margin-right: 5px;
                                           transition: background-color 0.3s;">
                                Edit
                            </button>
                        </a>
                        <form action="{{ route('blog.destroy', $blog->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus blog ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="padding: 6px 12px; 
                                           background-color: #f44336; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 4px; 
                                           font-size: 12px; 
                                           cursor: pointer;
                                           transition: background-color 0.3s;">
                                Hapus
                            </button>
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
                        <button style="padding: 6px 12px; 
                                       background-color: #4CAF50; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;
                                       margin-right: 5px;">
                            Edit
                        </button>
                        <button style="padding: 6px 12px; 
                                       background-color: #f44336; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;">
                            Hapus
                        </button>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">2</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">Tips Optimasi Website</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Web Development</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Admin</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">08/01/2026</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">2,340</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <button style="padding: 6px 12px; 
                                       background-color: #4CAF50; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;
                                       margin-right: 5px;">
                            Edit
                        </button>
                        <button style="padding: 6px 12px; 
                                       background-color: #f44336; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;">
                            Hapus
                        </button>
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
                        <button style="padding: 6px 12px; 
                                       background-color: #4CAF50; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;
                                       margin-right: 5px;">
                            Edit
                        </button>
                        <button style="padding: 6px 12px; 
                                       background-color: #f44336; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;">
                            Hapus
                        </button>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">4</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">Cara Membuat REST API dengan Laravel</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Backend</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Admin</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">03/01/2026</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">1,560</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <button style="padding: 6px 12px; 
                                       background-color: #4CAF50; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;
                                       margin-right: 5px;">
                            Edit
                        </button>
                        <button style="padding: 6px 12px; 
                                       background-color: #f44336; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;">
                            Hapus
                        </button>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">5</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #333; font-weight: 500;">Design Pattern dalam PHP</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">PHP</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">Admin</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">01/01/2026</td>
                    <td style="padding: 12px 15px; font-size: 14px; color: #555;">720</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <button style="padding: 6px 12px; 
                                       background-color: #4CAF50; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;
                                       margin-right: 5px;">
                            Edit
                        </button>
                        <button style="padding: 6px 12px; 
                                       background-color: #f44336; 
                                       color: white; 
                                       border: none; 
                                       border-radius: 4px; 
                                       font-size: 12px; 
                                       cursor: pointer;">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        
        
    </div>
    
</div>

<style>
    button:hover {
        opacity: 0.8;
    }
    
    #blogTable tbody tr:hover {
        background-color: #f9f9f9;
    }
</style>

<script>
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
</script>
@endsection