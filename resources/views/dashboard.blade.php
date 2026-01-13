<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard - Portal Blog')

@section('content')
<div class="dashboard">
    <h1 style="font-size: 32px; margin-bottom: 20px; color: #333;">Dashboard</h1>
    
    <div class="stats-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="color: #666; font-size: 14px; margin-bottom: 10px;">Total Blog</h3>
            <p style="font-size: 36px; font-weight: bold; color: #333;">150</p>
        </div>
        
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="color: #666; font-size: 14px; margin-bottom: 10px;">Total Kategori</h3>
            <p style="font-size: 36px; font-weight: bold; color: #333;">12</p>
        </div>
        
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="color: #666; font-size: 14px; margin-bottom: 10px;">Total Admin</h3>
            <p style="font-size: 36px; font-weight: bold; color: #333;">5</p>
        </div>
        
    </div>
</div>
@endsection