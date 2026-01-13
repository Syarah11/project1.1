<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\fe\DashboardController;
use App\Http\Controllers\fe\BlogController;
use App\Http\Controllers\fe\KategoriController;
use App\Http\Controllers\fe\IklanController;
use App\Http\Controllers\fe\EJurnalController;
use App\Http\Controllers\fe\AdminController;
use App\Http\Controllers\fe\AuthController;


//Route::get('/super-admin', [SuperAdminController::class, 'index'])->name('super.admin');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/blog/tambah', [BlogController::class, 'create'])->name('blog.tambah');
Route::get('/blog/list', [BlogController::class, 'index'])->name('blog.list');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
Route::get('/iklan', [IklanController::class, 'index'])->name('iklan');
Route::get('/ejurnal', [EJurnalController::class, 'index'])->name('ejurnal');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
