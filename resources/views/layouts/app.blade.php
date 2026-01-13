<!-- resources/views/layouts/app.blade.php -->
<div class="layout-container" style="display: flex;">
    <x-sidebar />
    
    <div class="content-area" style="flex: 1; padding: 30px;">
        @yield('content')
    </div>
</div>