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
        }

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

        .main-content {
    margin-left: 260px;
    margin-top: 0;  /* Ubah jadi 0 */
    padding: 30px;
    padding-top: 94px;  /* Total: 64px navbar + 30px spacing */
    transition: margin-left 0.3s ease;
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

        .welcome-title {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }

        .welcome-subtitle {
            color: #666;
            margin-bottom: 30px;
        }

        .demo-cards {
            display: grid;
            gap: 20px;
        }

        .demo-card {
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .demo-card:nth-child(1) {
            background: #e3f2fd;
            border-color: #2196f3;
        }

        .demo-card:nth-child(2) {
            background: #e8f5e9;
            border-color: #4caf50;
        }

        .demo-card:nth-child(3) {
            background: #f3e5f5;
            border-color: #9c27b0;
        }

        .demo-card:nth-child(4) {
            background: #fce4ec;
            border-color: #e91e63;
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .card-content {
            color: #666;
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

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
    </main>

    <script>
        let sidebarOpen = true;
        let logoTextVisible = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleIcon = document.getElementById('toggleIcon');
            
            sidebarOpen = !sidebarOpen;
            
            if (sidebarOpen) {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            } else {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
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
            
            if (!profileTrigger.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                sidebarOpen = false;
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize();
    </script>
</body>
</html>