<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\IklanController;
use App\Http\Controllers\Api\EjurnalController;
use App\Http\Controllers\Api\KategorisTagsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// ========================================
// 📖 PUBLIC ENDPOINTS - TANPA API KEY & TANPA LOGIN
// ========================================

Route::get('/beritas',             [BeritaController::class, 'index']);
Route::get('/beritas/admin',       [BeritaController::class, 'adminIndex']); // ← TAMBAH (harus sebelum {id})
Route::get('/beritas/slug/{slug}', [BeritaController::class, 'showBySlug']);
Route::get('/beritas/{id}',        [BeritaController::class, 'show']);

Route::get('/all_kategori',             [KategoriController::class, 'index']);
Route::get('/kategoris/{id}',        [KategoriController::class, 'show']);
Route::get('/kategoris/slug/{slug}', [KategoriController::class, 'showBySlug']);

Route::get('/tags',             [TagController::class, 'index']);
Route::get('/tags/{id}',        [TagController::class, 'show']);
Route::get('/tags/slug/{slug}', [TagController::class, 'showBySlug']);

Route::get('/kategoris-tags',   [KategorisTagsController::class, 'index']);

Route::get('/ejurnals',         [EjurnalController::class, 'index']);
Route::get('/ejurnals/{id}',    [EjurnalController::class, 'show']);

Route::get('/iklans',           [IklanController::class, 'index']);
Route::get('/iklans/{id}',      [IklanController::class, 'show']);

// ========================================
// 🔐 PROTECTED ENDPOINTS
// ========================================

Route::middleware('api.key')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout',      [AuthController::class, 'logout']);
        Route::get('/me',           [AuthController::class, 'me']);
        Route::put('/profile',      [AuthController::class, 'updateProfile']);

        Route::get('/users',        [UserController::class, 'index'])->middleware('role:super_admin');
        Route::get('/users/{id}',   [UserController::class, 'show'])->middleware('role:super_admin');
        Route::put('/users/{id}',   [UserController::class, 'update'])->middleware('role:super_admin');
        Route::delete('/users/{id}',[UserController::class, 'destroy'])->middleware('role:super_admin');

        Route::post('/beritas',        [BeritaController::class, 'store'])->middleware('role:super_admin,admin,user');
        Route::put('/beritas/{id}',    [BeritaController::class, 'update'])->middleware('role:super_admin,admin,user');
        Route::delete('/beritas/{id}', [BeritaController::class, 'destroy'])->middleware('role:super_admin,admin,user');

        Route::post('/kategoris',        [KategoriController::class, 'store'])->middleware('role:super_admin,admin');
        Route::put('/kategoris/{id}',    [KategoriController::class, 'update'])->middleware('role:super_admin,admin');
        Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->middleware('role:super_admin,admin');

        Route::post('/tags',        [TagController::class, 'store'])->middleware('role:super_admin,admin');
        Route::put('/tags/{id}',    [TagController::class, 'update'])->middleware('role:super_admin,admin');
        Route::delete('/tags/{id}', [TagController::class, 'destroy'])->middleware('role:super_admin,admin');

        Route::post('/iklans',        [IklanController::class, 'store'])->middleware('role:super_admin,admin');
        Route::put('/iklans/{id}',    [IklanController::class, 'update'])->middleware('role:super_admin,admin');
        Route::delete('/iklans/{id}', [IklanController::class, 'destroy'])->middleware('role:super_admin,admin');

        Route::post('/ejurnals',               [EjurnalController::class, 'store'])->middleware('role:super_admin,admin');
        Route::put('/ejurnals/{id}',           [EjurnalController::class, 'update'])->middleware('role:super_admin,admin');
        Route::delete('/ejurnals/{id}',        [EjurnalController::class, 'destroy'])->middleware('role:super_admin,admin');
        Route::delete('/ejurnals/gambar/{id}', [EjurnalController::class, 'deleteGambar'])->middleware('role:super_admin,admin');
    });
});