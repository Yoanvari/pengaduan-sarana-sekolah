<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== HALAMAN UTAMA ====================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==================== AUTH ROUTES ====================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== SISWA ROUTES ====================
Route::prefix('siswa')->middleware('auth.siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/aspirasi/create', [SiswaController::class, 'createAspirasi'])->name('siswa.aspirasi.create');
    Route::post('/aspirasi/store', [SiswaController::class, 'storeAspirasi'])->name('siswa.aspirasi.store');
});

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware('auth.admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/aspirasi/{id}/edit', [AdminController::class, 'editAspirasi'])->name('admin.aspirasi.edit');
    Route::put('/aspirasi/{id}/update', [AdminController::class, 'updateAspirasi'])->name('admin.aspirasi.update');
});
