<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        .menu-item {
            transition: all 0.2s ease;
        }

        .menu-item:hover {
            background-color: #f3f4f6;
            padding-left: 1.5rem;
        }

        .menu-item.active {
            color: #ef4444;
            font-weight: 600;
            border-left: 3px solid #ef4444;
            padding-left: 1.5rem;
            background: linear-gradient(90deg, rgba(239, 68, 68, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        }

        .menu-item.active i {
            color: #ef4444;
        }

        .submenu-item {
            transition: all 0.2s ease;
            padding-left: 2rem;
        }

        .submenu-item:hover {
            background-color: #f3f4f6;
            padding-left: 2.5rem;
        }

        .btn-logout {
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4) !important;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
        }

        .sidebar {
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: width 0.3s ease;
            width: 16rem;
        }

        .sidebar.collapsed {
            width: 5rem;
        }

        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .submenu-item,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .logout-text {
            display: none;
        }

        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .sidebar.collapsed .menu-item:hover {
            padding-left: 1.5rem;
        }

        .sidebar.collapsed .avatar {
            margin: 0 auto;
        }

        .toggle-btn {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .toggle-btn:hover {
            background-color: #f3f4f6;
            transform: scale(1.1);
        }

        .sidebar.collapsed .chevron-icon {
            display: none;
        }

        .content-page {
            animation: fadeInUp 0.4s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-white flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="avatar rounded-full flex items-center justify-center text-white font-bold">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div class="user-info">
                            <h2 class="font-bold text-gray-800">Portal Blog</h2>
                            <p class="text-xs text-gray-500">Super Admin</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="toggle-btn p-2 rounded-lg">
                        <i id="toggleIcon" class="fas fa-bars text-purple-600 text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex-1 py-4">
                <ul class="space-y-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="#dashboard" class="menu-item active flex items-center px-6 py-2.5 text-sm">
                            <i class="fas fa-home w-5 text-lg"></i>
                            <span class="ml-3 menu-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- Blog -->
                    <li>
                        <button onclick="toggleSubmenu('blogSubmenu')" class="menu-item flex items-center justify-between w-full px-6 py-2.5 text-sm text-gray-700 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-newspaper w-5 text-lg"></i>
                                <span class="ml-3 menu-text">Blog</span>
                            </div>
                            <i id="blogIcon" class="fas fa-chevron-right text-xs transition-transform chevron-icon"></i>
                        </button>
                        <ul id="blogSubmenu" class="hidden space-y-1 mt-1">
                            <li>
                                <a href="#tambah-blog" class="submenu-item flex items-center py-2 text-xs text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-file-circle-plus w-4 text-sm"></i>
                                    <span class="ml-2">Tambah Blog</span>
                                </a>
                            </li>
                            <li>
                                <a href="#list-blog" class="submenu-item flex items-center py-2 text-xs text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-list-ul w-4 text-sm"></i>
                                    <span class="ml-2">List Blog</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Kategori -->
                    <li>
                        <a href="#kategori" class="menu-item flex items-center px-6 py-2.5 text-sm text-gray-700 hover:text-gray-900">
                            <i class="fas fa-tags w-5 text-lg"></i>
                            <span class="ml-3 menu-text">Kategori</span>
                        </a>
                    </li>

                    <!-- Iklan -->
                    <li>
                        <a href="#iklan" class="menu-item flex items-center px-6 py-2.5 text-sm text-gray-700 hover:text-gray-900">
                            <i class="fas fa-rectangle-ad w-5 text-lg"></i>
                            <span class="ml-3 menu-text">Iklan</span>
                        </a>
                    </li>

                    <!-- E-Jurnal -->
                    <li>
                        <a href="#ejurnal" class="menu-item flex items-center px-6 py-2.5 text-sm text-gray-700 hover:text-gray-900">
                            <i class="fas fa-book-bookmark w-5 text-lg"></i>
                            <span class="ml-3 menu-text">E-Jurnal</span>
                        </a>
                    </li>

                    <!-- Admin -->
                    <li>
                        <a href="#admin" class="menu-item flex items-center px-6 py-2.5 text-sm text-gray-700 hover:text-gray-900">
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

        <!-- Main Content Area -->
        <main class="flex-1 p-8 bg-gray-100">
            <!-- Dashboard Content -->
            <div id="dashboard-content" class="content-page">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <i class="fas fa-home text-purple-600"></i>
                        Dashboard
                    </h1>
                    <p class="text-gray-600 mb-6">Selamat datang di Portal Blog Admin Dashboard</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm">Total Blog</p>
                                    <h3 class="text-3xl font-bold mt-2">248</h3>
                                </div>
                                <i class="fas fa-newspaper text-5xl opacity-30"></i>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm">Kategori</p>
                                    <h3 class="text-3xl font-bold mt-2">12</h3>
                                </div>
                                <i class="fas fa-tags text-5xl opacity-30"></i>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm">E-Jurnal</p>
                                    <h3 class="text-3xl font-bold mt-2">87</h3>
                                </div>
                                <i class="fas fa-book-bookmark text-5xl opacity-30"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tambah Blog Content -->
            <div id="tambah-blog-content" class="content-page hidden">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <i class="fas fa-file-circle-plus text-green-600"></i>
                        Tambah Blog
                    </h1>
                    <p class="text-gray-600">Form untuk menambahkan blog baru akan ditampilkan di sini.</p>
                </div>
            </div>

            <!-- List Blog Content -->
            <div id="list-blog-content" class="content-page hidden">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <i class="fas fa-list-ul text-blue-600"></i>
                        List Blog
                    </h1>
                    <p class="text-gray-600">Daftar semua blog akan ditampilkan di sini.</p>
                </div>
            </div>

            <!-- Kategori Content -->
            <div id="kategori-content" class="content-page hidden">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <i class="fas fa-tags text-yellow-600"></i>
                        Kelola Kategori
                    </h1>
                    <p class="text-gray-600">Halaman manajemen kategori dan tag akan ditampilkan di sini.</p>
                </div>
            </div>

            <!-- Iklan Content -->
            <div id="iklan-content" class="content-page hidden">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <i class="fas fa-rectangle-ad text-red-600"></i>
                        Kelola Iklan
                    </h1>
                    <p class="text-gray-600">Halaman manajemen iklan akan ditampilkan di sini.</p>
                </div>
            </div>

            <!-- E-Jurnal Content -->
            <div id="ejurnal-content" class="content-page hidden">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <i class="fas fa-book-bookmark text-indigo-600"></i>
                        Kelola E-Jurnal
                    </h1>
                    <p class="text-gray-600">Halaman manajemen e-jurnal akan ditampilkan di sini.</p>
                </div>
            </div>

            <!-- Admin Content -->
            <div id="admin-content" class="content-page hidden">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <i class="fas fa-user-gear text-purple-600"></i>
                        Kelola Admin
                    </h1>
                    <p class="text-gray-600">Halaman manajemen admin akan ditampilkan di sini.</p>
                </div>
            </div>
        </main>
    </div>

    <script>
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

        // Toggle Sidebar Collapse
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggleIcon');
            const blogSubmenu = document.getElementById('blogSubmenu');
            
            sidebar.classList.toggle('collapsed');
            
            // Change icon
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-times');
                // Close submenu when collapsed
                blogSubmenu.classList.add('hidden');
                document.getElementById('blogIcon').classList.remove('rotate-90');
            } else {
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
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
                submenu.classList.add('hidden');
                icon.classList.remove('rotate-90');
            }
        }

        // Active Menu
        document.querySelectorAll('.menu-item, .submenu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Get the href or data attribute
                const href = this.getAttribute('href');
                
                if (href && href !== '#') {
                    e.preventDefault();
                    
                    // Extract page id from href
                    const pageId = href.replace('#', '');
                    
                    // Show the corresponding page
                    showPage(pageId);
                    
                    // Remove active class from all menu items
                    document.querySelectorAll('.menu-item').forEach(el => {
                        if (!el.classList.contains('justify-between')) {
                            el.classList.remove('active');
                        }
                    });
                    
                    // Add active class to clicked item
                    if (!this.classList.contains('justify-between')) {
                        this.classList.add('active');
                    }
                }
            });
        });

        // Load page based on URL hash on page load
        window.addEventListener('load', function() {
            const hash = window.location.hash.replace('#', '');
            if (hash) {
                showPage(hash);
                
                // Set active menu based on hash
                const menuLink = document.querySelector(`a[href="#${hash}"]`);
                if (menuLink) {
                    document.querySelectorAll('.menu-item').forEach(el => {
                        if (!el.classList.contains('justify-between')) {
                            el.classList.remove('active');
                        }
                    });
                    menuLink.classList.add('active');
                }
            }
        });

        // Logout
        function logout() {
            // Show loading state
            const logoutBtn = document.querySelector('.btn-logout');
            const originalText = logoutBtn.innerHTML;
            
            logoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span class="logout-text ml-2">Logging out...</span>';
            logoutBtn.disabled = true;
            
            // Simulate logout process
            setTimeout(() => {
                // Show success message
                alert('✓ Logout berhasil!\n\nAnda akan diarahkan ke halaman login.');
                
                // Clear session/localStorage if needed
                localStorage.clear();
                sessionStorage.clear();
                
                // Redirect to login page
                window.location.href = '/login.html'; // Ganti dengan URL login Anda
                
                // If redirect fails, reload current page
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }, 1000);
        }
    </script>
</body>
</html>