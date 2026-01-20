<!-- resources/views/admin/index.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola Admin - Portal Blog')

@section('content')
<div class="kelola-admin-container" style="padding: 20px; font-family: Arial, sans-serif;">
    
    <!-- Title -->
    <h1 style="font-size: 24px; margin-bottom: 25px; color: #333; font-weight: normal;">Kelola Admin</h1>
    
    <div style="display: grid; grid-template-columns: 250px 1fr; gap: 20px;">
        
        <!-- Left Column: Forms -->
        <div class="left-column">
            
            <!-- Tambah Admin Form -->
            <div style="margin-bottom: 20px;">
                <h2 style="font-size: 14px; margin-bottom: 12px; color: #333; font-weight: normal;">Tambah Admin</h2>
                <div class="form-box" style="width: 100%; 
                                              height: 150px; 
                                              background-color: #d0d0d0; 
                                              border-radius: 8px;
                                              padding: 15px;
                                              display: flex;
                                              flex-direction: column;
                                              justify-content: space-between;">
                    <div style="flex: 1;"></div>
                    <button class="simpan-btn" 
                            style="width: 100%;
                                   padding: 8px;
                                   background-color: white;
                                   border: 1px solid #999;
                                   border-radius: 5px;
                                   font-size: 13px;
                                   cursor: pointer;
                                   transition: background-color 0.3s;">
                        Simpan
                    </button>
                </div>
            </div>
            
            <!-- Manajemen Admin Form -->
            <div>
                <h2 style="font-size: 14px; margin-bottom: 12px; color: #333; font-weight: normal;">Manajemen Admin</h2>
                <div class="form-box" style="width: 100%; 
                                              height: 150px; 
                                              background-color: #d0d0d0; 
                                              border-radius: 8px;
                                              padding: 15px;">
                </div>
            </div>
            
        </div>
        
        <!-- Right Column: Table -->
        <div class="right-column">
            <div class="table-box" style="width: 100%; 
                                          height: 340px; 
                                          background-color: #d0d0d0; 
                                          border-radius: 8px;
                                          display: flex;
                                          align-items: center;
                                          justify-content: center;
                                          padding: 20px;">
                <span style="font-size: 18px; color: #666;">Tabel</span>
            </div>
        </div>
        
    </div>
    
</div>

<style>
    .simpan-btn:hover {
        background-color: #f0f0f0 !important;
    }
</style>
@endsection