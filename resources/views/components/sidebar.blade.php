<!-- resources/views/components/sidebar.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Blog - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        /* Main Content Area - agar tidak terpotong sidebar */
        .main-content {
            margin-left: 16rem; /* Sama dengan lebar sidebar (w-64 = 16rem) */
            padding: 20px;
            min-height: 100vh;
            background-color: #f3f4f6;
            padding-top: 80px; /* Beri ruang untuk navbar yang fixed */
        }

        /* Ketika sidebar collapsed */
        .sidebar.collapsed ~ .main-content {
            margin-left: 5rem; /* 5rem = lebar sidebar saat collapsed */
        }
        .menu-item {
            transition: all 0.2s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .menu-toggle:hover {
            background: #f0f0f0;
        }

        .menu-toggle i {
            font-size: 20px;
            color: #8b5cf6;
        .btn-logout {
            transition: all 0.3s ease;
            position: absolute; /* Tambahkan position absolute */
            bottom: 30px; /* Jarak dari bawah sidebar - bisa disesuaikan */
            left: 24px; /* Jarak dari kiri */
            right: 24px; /* Jarak dari kanan */
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background 0.3s;
        }
        /* Container tombol logout di sidebar */
        .sidebar .p-6.border-t {
            position: relative;
            margin-top: auto; /* Dorong ke bawah */
            padding-top: 50px; /* Tambah padding atas */
            padding-bottom: 30px; /* Tambah padding bawah */
        }

        .logo-container:hover {
            background: #f8f9fa;
        }

        .logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .logo-text {
            display: none;
        }

        .logo-text.active {
            display: block;
        }

        .logo-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .logo-subtitle {
            font-size: 12px;
            color: #666;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-btn, .settings-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background 0.3s;
            font-size: 18px;
            color: #666;
        }

        .notification-btn:hover, .settings-btn:hover {
            background: #f0f0f0;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .profile-trigger:hover {
            background: #f8f9fa;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-info {
            display: none;
        }

        .profile-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            background: #d4edda;
            color: #155724;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background: #28a745;
            border-radius: 50%;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 280px;
            display: none;
            z-index: 1001;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-header {
            padding: 16px;
            border-bottom: 1px solid #e9ecef;
        }

        .dropdown-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dropdown-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .dropdown-info h4 {
            font-size: 15px;
            margin-bottom: 2px;
        }

        .dropdown-info p {
            font-size: 13px;
            color: #666;
        }

        .dropdown-body {
            padding: 8px 0;
        }

        .dropdown-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            color: #333;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            width: 260px;
            height: calc(100vh - 64px);
            background: white;
            box-shadow: 2px 0 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            z-index: 999;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            box-shadow: 2px 0 30px rgba(0, 0, 0, 0.05);
            transition: width 0.3s ease;
            width: 16rem;
            position: fixed;           /* TAMBAHKAN - sidebar tetap fixed */
            top: 0;                    /* TAMBAHKAN - mulai dari atas */
            left: 0;                   /* TAMBAHKAN - menempel di kiri */
            z-index: 100;              /* TAMBAHKAN - di bawah navbar */
            padding-top: 70px;         /* TAMBAHKAN - beri ruang untuk navbar */
            overflow-y: auto;          /* TAMBAHKAN - scroll jika menu panjang */
        }
        /* TAMBAHKAN CSS BARU INI */
        .sidebar.collapsed {
            transform: translateX(-260px);
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #555;
        }

        .menu-item i {
            width: 20px;
            font-size: 18px;
        }

        .menu-item:hover {
            background: #f8f9fa;
            color: #667eea;
        }

        .menu-item.active {
            background: #fff5f5;
            color: #ff4757;
            border-left: 3px solid #ff4757;
        }

        .menu-item-with-submenu {
            padding: 12px 20px;
            display: flex;
            align-items: center; 
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.3s;
            color: #555;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
        }

        .menu-item-with-submenu:hover {
            background: #f8f9fa;
            color: #667eea;
        }

        .menu-item-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-item-content i {
            width: 20px;
            font-size: 18px;
        }

        .chevron-icon {
            font-size: 12px;
            transition: transform 0.3s;
        }

        .chevron-icon.rotated {
            transform: rotate(180deg);
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .submenu.active {
            max-height: 200px;
        }

        .submenu-item {
            padding: 10px 20px 10px 52px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: #666;
            font-size: 14px;
        }

        .submenu-item:hover {
            background: #f8f9fa;
            color: #667eea;
            padding-left: 56px;
        }

        .submenu-item i {
            font-size: 14px;
            width: 16px;
        }

        .logout-btn {
            margin: 20px;
            padding: 12px;
            background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform 0.2s;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 71, 87, 0.4);
        }

        /* PERBAIKAN UTAMA - Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 64px;
            padding: 20px;
            min-height: calc(100vh - 64px);
            transition: margin-left 0.3s ease;
            background-color: #f5f5f5;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .content-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        @media (min-width: 768px) {
            .profile-info {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
            width: 5rem; /* Lebar sidebar saat collapsed */
        }
      
        /* Sembunyikan teks menu saat collapsed */
        .sidebar.collapsed .menu-text {
            display: none;
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        /* Sembunyikan submenu saat collapsed */
        .sidebar.collapsed .submenu-item {
            display: none;
        }

        /* Sembunyikan chevron (panah) submenu saat collapsed */
        .sidebar.collapsed .chevron-icon {
            display: none;
        }

        /* Pusatkan menu item saat collapsed (hanya icon) */
        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Hover menu saat collapsed tidak bergeser ke kanan */
        .sidebar.collapsed .menu-item:hover {
            padding-left: 1rem;
        }

        /* Border menu aktif pindah ke kanan saat collapsed */
        .sidebar.collapsed .menu-item.active {
            border-left: none;
            border-right: 3px solid #ef4444;
        }

        /* Sembunyikan teks "Logout" saat collapsed */
        .sidebar.collapsed .logout-text {
            display: none;
        }

        /* Sesuaikan tombol logout saat collapsed */
        .sidebar.collapsed .btn-logout {
            width: calc(5rem - 48px);
            padding: 12px 8px;
            justify-content: center;
        }

        /* Navbar Fixed di Atas */
        .navbar {
            background-color: #1e3a8a;
            padding:1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            z-index: 200;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 20px;
        }

        .logo {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .app-name {
            font-weight: 600;
            font-size: 18px;
            color: #f3f4f6;
        }

        /* Tombol Toggle di Navbar */
        .toggle-btn {
            width: 32px;
            height: 32px;
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
            margin-left: 15px;
            outline: none; /* Hilangkan outline saat diklik */
        }

        .toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .toggle-btn:active {
            transform: scale(0.95);
        }

        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 8px;
            transition: background-color 0.3s;
            position: relative;
        }

        .user-dropdown:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background-color: #f59e0b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-name {
            color: #ffffff;
            font-weight: 500;
            font-size: 14px;
        }

        .dropdown-arrow {
            color: #ffffff;
            font-size: 12px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            min-width: 200px;
            overflow: hidden;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            color: #374151;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

       /* Main Content Area - agar tidak terpotong sidebar */
       .main-content {
           margin-left: 16rem; /* 16rem = 256px = lebar sidebar default */
           padding: 20px;
           min-height: 100vh;
           background-color: #f3f4f6;
           padding-top: 80px; /* Ruang untuk navbar fixed (60px) + padding */
           transition: margin-left 0.3s ease; /* Smooth transition saat sidebar collapse */
        }

        /* Ketika sidebar collapsed */
        .sidebar.collapsed ~ .main-content {
            margin-left: 5rem; /* 5rem = 80px = lebar sidebar saat collapsed */
        }

        /* Logout Button - Posisi Fixed di Bawah */
        .btn-logout {
            transition: all 0.3s ease;
            position: fixed; /* Gunakan fixed agar selalu di bawah */
            bottom: 20px; /* Jarak dari bawah layar */
            left: 24px; /* Jarak dari kiri sidebar */
            width: calc(16rem - 48px); /* Lebar = lebar sidebar - padding kiri kanan */
        }

        /* Logout button saat sidebar collapsed */
        .sidebar.collapsed .btn-logout {
            width: calc(5rem - 48px);
            left: 24px;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4) !important;
        }

        /* Container logout - beri ruang di bawah sidebar */
        .sidebar > div:last-child {
            margin-top: auto;
            padding-bottom: 80px; /* Beri ruang agar menu tidak tertutup logout button */
        }

        /* Responsive untuk layar kecil */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding-top: 80px;
            }
    
            .sidebar.collapsed ~ .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-left">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i id="toggleIcon" class="fas fa-bars"></i>
            </button>

            <div class="logo-container" onclick="toggleLogoText()">
                <div class="logo">
                    <i class="fas fa-user"></i>
                </div>
                <div class="logo-text" id="logoText">
                    <h1 class="logo-title">Portal Blog</h1>
                    <p class="logo-subtitle">Super Admin</p>
                </div>
            </div>
        </div>

        <div class="navbar-right">
            <button class="notification-btn">
                <i class="fas fa-bell"></i>
            </button>
            <button class="settings-btn">
                <i class="fas fa-cog"></i>
            </button>

            <div class="profile-dropdown">
                <div class="profile-trigger" onclick="toggleDropdown()">
                    <div class="profile-avatar">AD</div>
                    <div class="profile-info">
                        <div class="profile-name">Administrator</div>
                        <span class="status-badge">
                            <span class="status-dot"></span>
                            Active
                        </span>
                    </div>
                </div>

                <div class="dropdown-menu" id="dropdownMenu">
                    <div class="dropdown-header">
                        <div class="dropdown-profile">
                            <div class="dropdown-avatar">AD</div>
                            <div class="dropdown-info">
                                <h4>Administrator</h4>
                                <p>admin@example.com</p>
                                <p style="font-size: 11px; color: #999;">Role: Super Admin</p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Profil Admin</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                        <a href="#" class="dropdown-item" style="color: #ff4757;">
                            <i class="fas fa-power-off"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
     
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <!-- Dashboard -->
            <a href="{{ url('/') }}" class="menu-item {{ Request::is('/') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <!-- Blog dengan Submenu -->
            <div>
                <button class="menu-item-with-submenu" onclick="toggleSubmenu('blogSubmenu')">
                    <div class="menu-item-content">
                        <i class="fas fa-newspaper"></i>
                        <span>Blog</span>
                    </div>
                    <i id="blogChevron" class="fas fa-chevron-down chevron-icon"></i>
                </button>
                
                <div id="blogSubmenu" class="submenu">
                    <a href="{{ url('/blog/tambah') }}" class="submenu-item">
                        <i class="fas fa-file-circle-plus"></i>
                        <span>Tambah Blog</span>
                    </a>
                     <a href="{{ url('/blog/list') }}" class="submenu-item">
                        <i class="fas fa-list-ul"></i>
                        <span>List Blog</span>
                    </a>
                </div>
            </div>

            <!-- Kategori -->
            <a href="{{ url('/kategori') }}" class="menu-item {{ Request::is('kategori*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span>Kategori</span>
            </a>
<body class="bg-gray-100">
    <!-- Navbar Fixed -->

    <div class="flex">
        <!-- Navbar -->
        <nav class="navbar">
            <!-- Logo, nama aplikasi, dan tombol toggle di kiri -->
            <div class="navbar-brand">
                <div class="logo">PB</div>
                <span class="app-name">Portal Berita</span>
        
                <!-- TAMBAHKAN TOMBOL TOGGLE DI SINI -->
                <button class="toggle-btn" onclick="toggleSidebar()" id="toggleBtn">
                    <i class="fas fa-chevron-left" id="toggleIcon"></i>
                </button>
            </div>

            <!-- User dropdown di kanan -->
            <div class="user-dropdown" id="userDropdown">
                <div class="user-avatar">SA</div>
                <span class="user-name">Super Admin</span>
                <span class="dropdown-arrow">▼</span>
        
                <div class="dropdown-menu" id="dropdownMenu">
                    <div class="dropdown-item" onclick="showPage('admin')">
                        <i class="fas fa-user-gear"></i>
                        <span>Admin</span>
                    </div>
                    <div class="dropdown-item" onclick="showPage('profile')">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </div>
                    <div class="dropdown-item" onclick="logout()">
                        <i class="fas fa-power-off"></i>
                        <span>Logout</span>
                    </div>
                </div>
            </div>
        </nav>
            <!-- Sidebar (TANPA HEADER) -->
            <aside id="sidebar" class="sidebar bg-white flex flex-col">
            
            <!-- Menu -->
            <nav class="flex-1 py-4">
                <ul class="space-y-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="#" onclick="showPage('dashboard'); setActiveMenu(this); return false;" class="menu-item active flex items-center px-6 py-2.5 text-sm">
                            <i class="fas fa-home w-5 text-lg"></i>
                            <span class="ml-3 menu-text">Dashboard</span>
                        </a>
                    </li>

            <!-- Iklan -->
            <a href="{{ url('/iklan') }}" class="menu-item {{ Request::is('iklan*') ? 'active' : '' }}">
                <i class="fas fa-rectangle-ad"></i>
                <span>Iklan</span>
            </a>

            <!-- E-Jurnal -->
             <a href="{{ url('/ejurnal') }}" class="menu-item {{ Request::is('ejurnal*') ? 'active' : '' }}">
                <i class="fas fa-book-bookmark"></i>
                <span>E-Jurnal</span>
            </a>

            <!-- Admin -->
           <a href="{{ url('/admin') }}" class="menu-item {{ Request::is('admin*') ? 'active' : '' }}">
                <i class="fas fa-user-gear"></i>
                <span>Admin</span>
            </a>
        </div>

        <button class="logout-btn">
            <i class="fas fa-power-off"></i>
            <span>Logout</span>
        </button>
    </aside>

    <script>
        let sidebarOpen = true;
        let logoTextVisible = false;
                    <!-- Admin -->
                    <li>
                        <a href="/admin" class="menu-item flex items-center px-6 py-2.5 text-sm text-gray-700 hover:text-gray-900">
                            <i class="fas fa-user-gear w-5 text-lg"></i>
                            <span class="ml-3 menu-text">Admin</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Logout Button -->
            <div class="p-6 border-t border-gray-200">
                <button onclick="logout()" class="btn-logout w-full bg-gradient-to-r from-red-500 to-pink-500 text-white py-2.5 px-4 rounded-lg font-medium flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                    <i class="fas fa-power-off"></i>
                    <span class="logout-text">Logout</span>
                </button>
            </div>
        </aside>
    </div>

    <script>
        // Toggle Dropdown Menu
        const userDropdown = document.getElementById('userDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');

        if (userDropdown && dropdownMenu) {
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('active');
            });

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', function(e) {
                if (!userDropdown.contains(e.target)) {
                    dropdownMenu.classList.remove('active');
                }
            });
}
        // Show/Hide Content Pages
        function showPage(pageId) {
            // Hide all content pages
            document.querySelectorAll('.content-page').forEach(page => {
                page.classList.add('hidden');
            });
            
            // Show selected page
            const selectedPage = document.getElementById(pageId + '-content');
            if (selectedPage) {
                selectedPage.classList.remove('hidden');
            }
            
            // Update URL hash
            window.location.hash = pageId;
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleIcon = document.getElementById('toggleIcon');
            
            sidebarOpen = !sidebarOpen;
            
            if (sidebarOpen) {
                sidebar.classList.remove('collapsed');
                if (mainContent) mainContent.classList.remove('expanded');
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            const blogSubmenu = document.getElementById('blogSubmenu');

            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');

                blogSubmenu.classList.add('hidden');
                document.getElementById('blogIcon').classList.remove('rotate-90');
            } else {
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            }
        }

        // Toggle Submenu
        function toggleSubmenu(id) {
            const sidebar = document.getElementById('sidebar');
            
            // Don't open submenu if sidebar is collapsed
            if (sidebar.classList.contains('collapsed')) {
                return;
            }
            
            const submenu = document.getElementById(id);
            const icon = document.getElementById(id.replace('Submenu', 'Icon'));
            
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                icon.classList.add('rotate-90');
            } else {
                sidebar.classList.add('collapsed');
                if (mainContent) mainContent.classList.add('expanded');
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-times');
            }
        }

        function toggleLogoText() {
            const logoText = document.getElementById('logoText');
            logoTextVisible = !logoTextVisible;
            
            if (logoTextVisible) {
                logoText.classList.add('active');
            } else {
                logoText.classList.remove('active');
            }
        }

        function toggleSubmenu(submenuId) {
            const submenu = document.getElementById(submenuId);
            const chevron = document.getElementById(submenuId.replace('Submenu', 'Chevron'));
            
            submenu.classList.toggle('active');
            chevron.classList.toggle('rotated');
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const profileTrigger = document.querySelector('.profile-trigger');
            
            if (profileTrigger && !profileTrigger.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                if (mainContent) mainContent.classList.add('expanded');
                sidebarOpen = false;
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize();
        // Set Active Menu
        function setActiveMenu(element) {
             // Hapus active dari semua menu
             document.querySelectorAll('.menu-item').forEach(item => {
                 item.classList.remove('active');
             });
    
             // Tambah active ke menu yang diklik
             element.classList.add('active');
        }}
    </script>
</body>
</html>