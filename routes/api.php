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
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\RiwayatDisposisiController;
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

// ===============================
// FAQ & Pertanyaan
// ===============================

// Publik
Route::get('faq', [FaqController::class, 'index']);           // lihat FAQ publish
Route::get('faq/search', [FaqController::class, 'search']);   // search FAQ
Route::post('pertanyaan', [PertanyaanController::class, 'store']); // kirim pertanyaan baru

// ===============================
// Admin Web & Super Admin
// ===============================
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::get('admin/pertanyaan', [PertanyaanController::class, 'index']); // semua pertanyaan + filter
    Route::put('admin/pertanyaan/{id}/jawab-web', [PertanyaanController::class, 'jawabWeb']); // jawab langsung
    Route::put('admin/pertanyaan/{id}/disposisi', [PertanyaanController::class, 'disposisi']); // disposisi ke admin fungsi
    Route::put('admin/pertanyaan/{id}/edit-jawaban', [PertanyaanController::class, 'editJawaban']); // edit jawaban
    Route::put('admin/pertanyaan/{id}/publish', [PertanyaanController::class, 'publish']); // publish ke FAQ
    Route::delete('admin/pertanyaan/{id}', [PertanyaanController::class, 'destroy']); // hapus pertanyaan
});

// ===============================
// Admin Fungsi & Super Admin
// ===============================
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Fungsi'])->group(function () {
    Route::get('admin/pertanyaan/fungsi', [PertanyaanController::class, 'fungsiIndex']); // pertanyaan disposisi ke fungsi
    Route::put('admin/pertanyaan/{id}/jawab-fungsi', [PertanyaanController::class, 'jawabFungsi']); // jawab fungsi
});
