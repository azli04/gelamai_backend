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

/*
|--------------------------------------------------------------------------
| API Routes (final, sinkron dengan controller yang ada)
|--------------------------------------------------------------------------
*/

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
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])
    ->group(function () {
        Route::apiResource('artikel', ArtikelController::class)->except(['index', 'show']);
    });

// ===============================
// BERITA & EVENT
// ===============================
Route::apiResource('berita', BeritaEventController::class)->only(['index', 'show']);
Route::post('/upload-image', [BeritaEventController::class, 'uploadImage']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])
    ->group(function () {
        Route::apiResource('berita', BeritaEventController::class)->except(['index', 'show']);
    });

// ===============================
// LAYANAN
// ===============================
Route::apiResource('layanans', LayananController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])
    ->group(function () {
        Route::apiResource('layanans', LayananController::class)->except(['index', 'show']);
    });

// ===============================
// PROFIL
// ===============================
Route::apiResource('profil', ProfilController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])
    ->group(function () {
        Route::apiResource('profil', ProfilController::class)->except(['index', 'show']);
    });

// ===============================
// FAQ & PERTANYAAN (Final & Konsisten)
// ===============================

// Public (tidak perlu auth)
Route::post('/pertanyaan', [PertanyaanController::class, 'store']);
Route::get('/faq', [FaqController::class, 'index']);

// Admin Web & Super Admin
// NOTE: gunakan role alias yang didaftarkan di bootstrap: 'role:Super Admin,Admin Web'
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->prefix('admin')->group(function () {
    Route::get('/pertanyaan', [AdminPertanyaanController::class, 'index']);
    // gunakan method yang memang ada di controller (jawabLangsung)
    Route::post('/pertanyaan/{id}/jawab', [AdminPertanyaanController::class, 'jawabLangsung']);
    Route::post('/pertanyaan/{id}/disposisi', [AdminPertanyaanController::class, 'disposisi']);
    Route::post('/pertanyaan/{id}/review', [AdminPertanyaanController::class, 'reviewJawaban']);
    Route::post('/pertanyaan/{id}/publish', [AdminPertanyaanController::class, 'publishToFaq']);
});

// Admin Fungsi & Super Admin
// NOTE: gunakan nama role yang sesuai: 'Admin Fungsi'
Route::middleware(['auth:sanctum', 'role:Admin Fungsi,Super Admin'])->prefix('admin-fungsi')->group(function () {
    Route::get('/pertanyaan', [AdminFungsiController::class, 'index']); // list disposisi untuk fungsi ini
    Route::post('/pertanyaan/{id}/jawab', [AdminFungsiController::class, 'jawabPertanyaan']);
});
