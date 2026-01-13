<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\EjurnalController;
use App\Http\Controllers\Api\IklanController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::prefix('v1')->group(function () {
    
    // Auth Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Public Berita Routes
    Route::get('/beritas/published', [BeritaController::class, 'published']);
    Route::get('/beritas/popular', [BeritaController::class, 'popular']);
    Route::get('/beritas/slug/{slug}', [BeritaController::class, 'showBySlug']);
    Route::get('/beritas', [BeritaController::class, 'index']);
    Route::get('/beritas/{id}', [BeritaController::class, 'show']);

    // Public Kategori Routes
    Route::get('/kategoris', [KategoriController::class, 'index']);
    Route::get('/kategoris/{id}', [KategoriController::class, 'show']);
    Route::get('/kategoris/{id}/beritas', [KategoriController::class, 'withBeritas']);

    // Public Tag Routes
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tags/{id}', [TagController::class, 'show']);
    Route::get('/tags/{id}/beritas', [TagController::class, 'withBeritas']);

    // Public Ejurnal Routes
    Route::get('/ejurnals', [EjurnalController::class, 'index']);
    Route::get('/ejurnals/{id}', [EjurnalController::class, 'show']);

    // Public Iklan Routes
    Route::get('/iklans/active', [IklanController::class, 'active']);
    Route::get('/iklans', [IklanController::class, 'index']);
    Route::get('/iklans/{id}', [IklanController::class, 'show']);
});

// Protected Routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    
    // Auth Protected Routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Kategori CRUD
    Route::post('/kategoris', [KategoriController::class, 'store']);
    Route::put('/kategoris/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy']);

    // Tag CRUD
    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{id}', [TagController::class, 'update']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);

    // Berita CRUD
    Route::post('/beritas', [BeritaController::class, 'store']);
    Route::put('/beritas/{id}', [BeritaController::class, 'update']);
    Route::delete('/beritas/{id}', [BeritaController::class, 'destroy']);

    // Ejurnal CRUD
    Route::post('/ejurnals', [EjurnalController::class, 'store']);
    Route::put('/ejurnals/{id}', [EjurnalController::class, 'update']);
    Route::delete('/ejurnals/{id}', [EjurnalController::class, 'destroy']);
    Route::delete('/ejurnals/gambars/{id}', [EjurnalController::class, 'deleteGambar']);

    // Iklan CRUD
    Route::post('/iklans', [IklanController::class, 'store']);
    Route::put('/iklans/{id}', [IklanController::class, 'update']);
    Route::delete('/iklans/{id}', [IklanController::class, 'destroy']);

    // User Management (Admin Only)
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });
});