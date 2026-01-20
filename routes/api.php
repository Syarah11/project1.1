<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\IklanController;
use App\Http\Controllers\Api\EjurnalController;
use Illuminate\Support\Facades\Route;

// ========================================
// PUBLIC ROUTES (Tanpa Auth)
// ========================================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public - Hanya bisa lihat (GET)
Route::get('/beritas', [BeritaController::class, 'index']);
Route::get('/beritas/{id}', [BeritaController::class, 'show']);

Route::get('/kategoris', [KategoriController::class, 'index']);
Route::get('/kategoris/{id}', [KategoriController::class, 'show']);

Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{id}', [TagController::class, 'show']);

// ========================================
// PROTECTED ROUTES (Butuh Token)
// ========================================
//Route::middleware('auth:sanctum')->group(function () {
//Route::group(function () { tanpa token
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Beritas - CUD (Create, Update, Delete)
    Route::post('/beritas', [BeritaController::class, 'store']);
    Route::put('/beritas/{id}', [BeritaController::class, 'update']);
    Route::delete('/beritas/{id}', [BeritaController::class, 'destroy']);

    // Kategoris - CUD
    Route::post('/kategoris', [KategoriController::class, 'store']);
    Route::put('/kategoris/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy']);

    // Tags - CUD
    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{id}', [TagController::class, 'update']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);

    // Iklans - Full CRUD (Semua operasi butuh login)
    Route::apiResource('iklans', IklanController::class);

    // E-Jurnals - Full CRUD (Semua operasi butuh login)
    Route::apiResource('ejurnals', EjurnalController::class);
    
    // Delete gambar ejurnal
    Route::delete('/ejurnals/gambar/{id}', [EjurnalController::class, 'deleteGambar']);
//});