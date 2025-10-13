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
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\ChartLayananController;
use App\Http\Controllers\Api\ContactInfoController;
use App\Http\Controllers\Api\PertanyaanController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\PengaduanController;



// ===============================
// AUTH
// ===============================
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

// user login info
Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());

// ===============================
// USERS & ROLES (Super Admin Only)
// ===============================
Route::middleware(['auth:sanctum', 'superadmin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
});

// ===============================
// APLIKASI
// ===============================
Route::get('aplikasi', [AplikasiController::class, 'index']);
Route::get('aplikasi/{id}', [AplikasiController::class, 'show']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])
    ->group(function () {
        Route::apiResource('aplikasi', AplikasiController::class)->except(['index', 'show']);
    });

// ===============================
// ARTIKEL
// ===============================
Route::apiResource('artikel', ArtikelController::class)->only(['index', 'show']);

// CRUD & Publish hanya Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('artikel', ArtikelController::class)->except(['index', 'show']);

    // 🔹 Publish artikel
    Route::post('/artikel/{id}/publish', [ArtikelController::class, 'publish'])
        ->name('artikel.publish');
});

// ===============================
// BERITA & EVENT
// ===============================

// Publik boleh lihat
Route::apiResource('berita', BeritaEventController::class)->only(['index', 'show']);
Route::post('/upload-image', [BeritaEventController::class, 'uploadImage']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])
    ->group(function () {
        Route::apiResource('berita', BeritaEventController::class)->except(['index', 'show']);
    });

// CRUD & Publish hanya Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('berita', BeritaEventController::class)->except(['index', 'show']);

    // 🔹 Publish berita/event
    Route::post('/berita/{id}/publish', [BeritaEventController::class, 'publish'])
        ->name('berita.publish');
});

// ===============================
// Layanan
// ===============================
// Publik boleh lihat
Route::apiResource('layanans', LayananController::class)->only(['index', 'show']);

// CRUD hanya Super Admin & Admin Web
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

// ===============================
// Chart Layanan
// ===============================
// Publik boleh lihat
Route::apiResource('chart-layanan', ChartLayananController::class)->only(['index', 'show']);

// CRUD hanya Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('chart-layanan', ChartLayananController::class)->except(['index', 'show']);
});


    // ===============================
    // Contact Info
    // ===============================
    // Publik boleh lihat
    Route::get('contact-info', [ContactInfoController::class, 'index']);

    // UPDATE hanya Super Admin & Admin Web
    Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
        Route::put('contact-info', [ContactInfoController::class, 'update']);
    });

    // ===============================
// PERTANYAAN (Questions)
// ===============================

// Public - Submit pertanyaan (tanpa login)
Route::post('pertanyaan', [PertanyaanController::class, 'store']);

// Admin only - Manage pertanyaan
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Pengaduan'])->group(function () {
    Route::get('pertanyaan', [PertanyaanController::class, 'index']);
    Route::get('pertanyaan/{id}', [PertanyaanController::class, 'show']);
    Route::patch('pertanyaan/{id}/status', [PertanyaanController::class, 'updateStatus']);
    Route::delete('pertanyaan/{id}', [PertanyaanController::class, 'destroy']);
});

// ===============================
// FAQ (Frequently Asked Questions)
// ===============================

// Public - Lihat FAQ
Route::get('faq', [FaqController::class, 'index']);
Route::get('faq/{id}', [FaqController::class, 'show']);
Route::get('faq-topics', [FaqController::class, 'getTopics']);

// Admin only - Manage FAQ
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Pengaduan'])->group(function () {
    Route::get('admin/faq', [FaqController::class, 'adminIndex']);
    Route::post('faq', [FaqController::class, 'store']);
    Route::put('faq/{id}', [FaqController::class, 'update']);
    Route::delete('faq/{id}', [FaqController::class, 'destroy']);
    Route::patch('faq/{id}/toggle-active', [FaqController::class, 'toggleActive']);
});

// 🔹 Public Route - Form Pengaduan (tidak perlu login)
Route::post('pengaduan', [PengaduanController::class, 'store']);

// 🔹 Admin Routes - Protected (harus login sebagai admin)
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Pengaduan'])->group(function () {
    Route::get('pengaduan', [PengaduanController::class, 'index']);
    Route::get('pengaduan/{id}', [PengaduanController::class, 'show']);
    Route::patch('pengaduan/{id}/status', [PengaduanController::class, 'updateStatus']);
    Route::delete('pengaduan/{id}', [PengaduanController::class, 'destroy']);
});