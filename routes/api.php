<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\IklanController;
use App\Http\Controllers\Api\EjurnalController;
use Illuminate\Support\Facades\Route;

// ========================================
// PUBLIC ROUTES
// ========================================
Route::post('/api-login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public - Lihat berita, kategori, tags (index & show saja)
Route::apiResource('beritas', BeritaController::class)->only(['index', 'show']);
Route::apiResource('kategoris', KategoriController::class)->only(['index', 'show']);
Route::apiResource('tags', TagController::class)->only(['index', 'show']);

// ========================================
// PROTECTED ROUTES
// ========================================
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Beritas - store, update, destroy saja (index & show sudah di public)
    Route::apiResource('beritas', BeritaController::class)->except(['index', 'show']);

    // Kategoris - store, update, destroy saja
    Route::apiResource('kategoris', KategoriController::class)->except(['index', 'show']);

    // Tags - store, update, destroy saja
    Route::apiResource('tags', TagController::class)->except(['index', 'show']);

    // Iklans - Full CRUD (harus login semua)
    Route::apiResource('iklans', IklanController::class);

    // E-Jurnals - Full CRUD (harus login semua)
    Route::apiResource('ejurnals', EjurnalController::class);
});