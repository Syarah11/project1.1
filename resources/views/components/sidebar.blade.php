<!-- resources/views/components/sidebar.blade.php -->
<div class="sidebar" style="width: 200px; height: 100vh; background-color: #f0f0f0; padding: 15px; font-family: Arial, sans-serif; display: flex; flex-direction: column;">
    
    <!-- User Profile Section -->
    <div class="user-profile" style="margin-bottom: 25px;">
        <div class="user-item" style="margin-bottom: 12px;">
            <div style="display: flex; align-items: center;">
                <div class="avatar" style="width: 35px; height: 35px; border-radius: 50%; background-color: #b8b8b8; margin-right: 10px;"></div>
                <span style="font-size: 14px; color: #333;">Portal Blog</span>
            </div>
        </div>
        
        <div class="user-item" style="margin-bottom: 20px; padding-left: 45px;">
            <a href="{{ route('super.admin') }}" style="text-decoration: none;">
                <span style="font-size: 14px; color: #333;">Super Admin</span>
            </a>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="nav-menu" style="flex: 1;">
        <ul style="list-style: none; padding: 0; margin: 0;">
            
            <!-- Dashboard -->
            <li style="margin-bottom: 12px;">
                <a href="{{ route('dashboard') }}" 
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   style="color: {{ request()->routeIs('dashboard') ? '#d44444' : '#333' }}; 
                          text-decoration: none; 
                          font-size: 14px;
                          display: block;
                          padding: 5px 0;
                          font-weight: {{ request()->routeIs('dashboard') ? 'bold' : 'normal' }};">
                    Dashboard
                </a>
            </li>

            <!-- Blog Section -->
            <li style="margin-bottom: 12px;">
                <div style="font-size: 14px; color: #333; font-weight: normal; margin-bottom: 6px;">Blog</div>
                <ul style="list-style: none; padding-left: 20px; margin: 0;">
                    <li style="margin-bottom: 6px;">
                        <a href="{{ route('blog.tambah') }}" 
                           style="color: #333; text-decoration: none; font-size: 14px; display: block;">
                            Tambah Blog
                        </a>
                    </li>
                    <li style="margin-bottom: 6px;">
                        <a href="{{ route('blog.list') }}" 
                           style="color: #333; text-decoration: none; font-size: 14px; display: block;">
                            List Blog
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Kategori -->
            <li style="margin-bottom: 12px;">
                <a href="{{ route('kategori') }}" 
                   style="color: #333; text-decoration: none; font-size: 14px; display: block; padding: 5px 0;">
                    Kategori
                </a>
            </li>

            <!-- Iklan -->
            <li style="margin-bottom: 12px;">
                <a href="{{ route('iklan') }}" 
                   style="color: #333; text-decoration: none; font-size: 14px; display: block; padding: 5px 0;">
                    Iklan
                </a>
            </li>

            <!-- E-Jurnal -->
            <li style="margin-bottom: 12px;">
                <a href="{{ route('ejurnal') }}" 
                   style="color: #333; text-decoration: none; font-size: 14px; display: block; padding: 5px 0;">
                    E-Jurnal
                </a>
            </li>

            <!-- Admin -->
            <li style="margin-bottom: 12px;">
                <a href="{{ route('admin') }}" 
                   style="color: #333; text-decoration: none; font-size: 14px; display: block; padding: 5px 0;">
                    Admin
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout Button -->
    <div class="logout-section" style="margin-top: auto; padding-top: 20px;">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    style="width: 100%; 
                           padding: 10px 15px; 
                           background-color: #e0e0e0; 
                           border: 1px solid #aaa; 
                           border-radius: 6px; 
                           font-size: 14px; 
                           color: #333; 
                           cursor: pointer;
                           transition: background-color 0.3s;">
                Logout
            </button>
        </form>
    </div>

</div>

<style>
    .sidebar a:hover {
        color: #d44444 !important;
    }
    
    .user-item a:hover span {
        color: #d44444 !important;
    }
    
    .logout-section button:hover {
        background-color: #d0d0d0;
    }
</style>