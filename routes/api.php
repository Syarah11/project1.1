<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\IklanController;
use App\Http\Controllers\Api\EjurnalController;
use App\Http\Controllers\Api\KategorisTagsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODE 2: PRODUCTION (Sanctum AKTIF + Roles)
|--------------------------------------------------------------------------
| - GET endpoints: PUBLIC (tanpa API Key, pembaca bebas akses)
| - POST/PUT/DELETE: PROTECTED dengan API Key + Sanctum Token + Role Check
|
| ROLES:
| - super_admin: Full akses semua
| - admin: CRUD semua konten
| - user: Create/Edit/Delete berita miliknya sendiri saja
|--------------------------------------------------------------------------
*/

// ========================================
// 📖 PUBLIC ENDPOINTS - TANPA API KEY & TANPA LOGIN
// Pengunjung awam bisa baca tanpa login
// ========================================


// Beritas - Public Read
Route::get('/beritas', [BeritaController::class, 'index']);
Route::get('/beritas/{id}', [BeritaController::class, 'show']);
Route::get('/beritas/slug/{slug}', [BeritaController::class, 'showBySlug']);

// Kategoris - Public Read
Route::get('/kategoris', [KategoriController::class, 'index']);
Route::get('/kategoris/{id}', [KategoriController::class, 'show']);
Route::get('/kategoris/slug/{slug}', [KategoriController::class, 'showBySlug']);

// Tags - Public Read
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{id}', [TagController::class, 'show']);
Route::get('/tags/slug/{slug}', [TagController::class, 'showBySlug']);

// Kategoris & Tags - Public Read
Route::get('/kategoris-tags', [KategorisTagsController::class, 'index']);

// Ejurnals - Public Read
Route::get('/ejurnals', [EjurnalController::class, 'index']);
Route::get('/ejurnals/{id}', [EjurnalController::class, 'show']);

// Iklans - Public Read
Route::get('/iklans', [IklanController::class, 'index']);
Route::get('/iklans/{id}', [IklanController::class, 'show']);

// ========================================
// 🔐 PROTECTED ENDPOINTSc
// WAJIB: API Key + Sanctum Token + Role Check
// ========================================

Route::middleware('api.key')->group(function () {   
    // ========================================
    // AUTH ENDPOINTS (Public dalam api.key group)
    // ========================================
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // ========================================
    // AUTHENTICATED ROUTES
    // Semua route di bawah butuh login (Sanctum token)
    // ========================================
    Route::middleware('auth:sanctum')->group(function () {
        
        // Auth user info & logout
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        
        // ========================================
        // BERITAS - CRUD
        // ✅ Super Admin, Admin, User SEMUA BISA CREATE
        // ✅ Update/Delete: Ownership check di controller
        // ========================================
        
        // ✅ SEMUA ROLE bisa create berita (super_admin, admin, user)
        Route::post('/beritas', [BeritaController::class, 'store'])
            ->middleware('role:super_admin,admin,user');
            
        // ✅ SEMUA ROLE bisa update
        // Controller akan cek: user hanya bisa edit miliknya sendiri
        Route::put('/beritas/{id}', [BeritaController::class, 'update'])
            ->middleware('role:super_admin,admin,user');
            
        // ✅ SEMUA ROLE bisa delete
        // Controller akan cek: user hanya bisa delete miliknya sendiri
        Route::delete('/beritas/{id}', [BeritaController::class, 'destroy'])
            ->middleware('role:super_admin,admin,user');
        
        // ========================================
        // KATEGORIS - CRUD
        // Hanya Super Admin & Admin
        // ========================================
        Route::post('/kategoris', [KategoriController::class, 'store'])
            ->middleware('role:super_admin,admin');
            
        Route::put('/kategoris/{id}', [KategoriController::class, 'update'])
            ->middleware('role:super_admin,admin');
            
        Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])
            ->middleware('role:super_admin,admin');
        
        // ========================================
        // TAGS - CRUD
        // Hanya Super Admin & Admin
        // ========================================
        Route::post('/tags', [TagController::class, 'store'])
            ->middleware('role:super_admin,admin');
            
        Route::put('/tags/{id}', [TagController::class, 'update'])
            ->middleware('role:super_admin,admin');
            
        Route::delete('/tags/{id}', [TagController::class, 'destroy'])
            ->middleware('role:super_admin,admin');
        
        // ========================================
        // IKLANS - CRUD
        // Hanya Super Admin & Admin
        // ========================================
        Route::post('/iklans', [IklanController::class, 'store'])
            ->middleware('role:super_admin,admin');
            
        Route::put('/iklans/{id}', [IklanController::class, 'update'])
            ->middleware('role:super_admin,admin');
            
        Route::delete('/iklans/{id}', [IklanController::class, 'destroy'])
            ->middleware('role:super_admin,admin');
        
        // ========================================
        // EJURNALS - CRUD
        // Hanya Super Admin & Admin
        // ========================================
        Route::post('/ejurnals', [EjurnalController::class, 'store'])
            ->middleware('role:super_admin,admin');
            
        Route::put('/ejurnals/{id}', [EjurnalController::class, 'update'])
            ->middleware('role:super_admin,admin');
            
        Route::delete('/ejurnals/{id}', [EjurnalController::class, 'destroy'])
            ->middleware('role:super_admin,admin');
            
        Route::delete('/ejurnals/gambar/{id}', [EjurnalController::class, 'deleteGambar'])
            ->middleware('role:super_admin,admin');
    });
});