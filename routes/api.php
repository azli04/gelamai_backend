<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\AplikasiController;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\LayananController;
use App\Http\Controllers\Api\BeritaEventController;
use App\Http\Controllers\Api\PertanyaanController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\AdminPertanyaanController;
use App\Http\Controllers\Api\AdminFungsiController;

// ===============================
// Auth
// ===============================
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

// Default user endpoint
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ===============================
// Users & Roles (hanya superadmin)
// ===============================
Route::middleware(['auth:sanctum', 'superadmin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
});

// ===============================
// Aplikasi
// ===============================
Route::get('aplikasi', [AplikasiController::class, 'index']);
Route::get('aplikasi/{id}', [AplikasiController::class, 'show']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('aplikasi', AplikasiController::class)->except(['index', 'show']);
});

// ===============================
// Artikel
// ===============================
Route::apiResource('artikel', ArtikelController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('artikel', ArtikelController::class)->except(['index', 'show']);
});

// ===============================
// Berita & Event
// ===============================
Route::apiResource('berita', BeritaEventController::class)->only(['index', 'show']);
Route::post('/upload-image', [BeritaEventController::class, 'uploadImage']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('berita', BeritaEventController::class)->except(['index', 'show']);
});

// ===============================
// Layanan
// ===============================
Route::apiResource('layanans', LayananController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('layanans', LayananController::class)->except(['index', 'show']);
});
// ===============================
// Profil
// ===============================
// Publik boleh lihat
Route::apiResource('profil', ProfilController::class)->only(['index', 'show']);

// CRUD hanya Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('profil', ProfilController::class)->except(['index', 'show']);
});

// ========================
// ROUTE UNTUK PUBLIK
// ========================
Route::post('/pertanyaan', [PertanyaanController::class, 'store']); 
// publik bisa kirim pertanyaan

Route::get('/faq', [FaqController::class, 'index']);  
// publik bisa lihat FAQ
// contoh: /faq?search=izin+edar (search filter)

// ========================
// ROUTE UNTUK ADMIN / SUPER ADMIN
// ========================
Route::middleware(['auth:sanctum', RoleMiddleware::class.':Admin Web,Super Admin'])->group(function () {
    
    // manajemen pertanyaan
    Route::get('/admin/pertanyaan', [AdminPertanyaanController::class, 'index']); 
    Route::get('/admin/pertanyaan/{id}', [AdminPertanyaanController::class, 'show']);
    Route::post('/admin/pertanyaan/{id}/disposisi', [AdminPertanyaanController::class, 'disposisi']);
    Route::post('/admin/pertanyaan/{id}/jawab', [AdminPertanyaanController::class, 'jawab']);
    Route::delete('/admin/pertanyaan/{id}', [AdminPertanyaanController::class, 'destroy']);

    // manajemen fungsi (opsional, kalau dipakai)
    Route::get('/admin/fungsi', [AdminFungsiController::class, 'index']);
    Route::post('/admin/fungsi', [AdminFungsiController::class, 'store']);
    Route::put('/admin/fungsi/{id}', [AdminFungsiController::class, 'update']);
    Route::delete('/admin/fungsi/{id}', [AdminFungsiController::class, 'destroy']);

    // publish pertanyaan ke FAQ
    Route::post('/admin/faq', [FaqController::class, 'store']);
    Route::put('/admin/faq/{id}', [FaqController::class, 'update']);
    Route::delete('/admin/faq/{id}', [FaqController::class, 'destroy']);
});
