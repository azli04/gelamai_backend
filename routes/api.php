<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\AplikasiController;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\BeritaEventController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\FaqKategoriController;

// ===============================
// Auth Routes
// ===============================
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

// ===============================
// Default user endpoint (profil user login)
// ===============================
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ===============================
// Users & Roles (khusus Super Admin)
// ===============================
Route::middleware(['auth:sanctum', 'superadmin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
});

// ===============================
// Aplikasi
// ===============================

// Public access
Route::get('aplikasi', [AplikasiController::class, 'index']);
Route::get('aplikasi/{id}', [AplikasiController::class, 'show']);

// CRUD hanya untuk Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('aplikasi', AplikasiController::class)->except(['index', 'show']);
});

// ===============================
// Artikel
// ===============================

// Public access
Route::get('artikel', [ArtikelController::class, 'index']);
Route::get('artikel/{id}', [ArtikelController::class, 'show']);

// CRUD hanya untuk Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('artikel', ArtikelController::class)->except(['index', 'show']);
});

// ===============================
// Berita & Event
// ===============================

// Public access
Route::get('berita', [BeritaEventController::class, 'index']);
Route::get('berita/{id}', [BeritaEventController::class, 'show']);

// CRUD hanya untuk Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('berita', BeritaEventController::class)->except(['index', 'show']);
});

// ===============================
// FAQ
// ===============================

// ---------- Public FAQ ----------
// Lihat semua FAQ (hanya yg status = dijawab)
Route::get('faq', [FaqController::class, 'index']);

// Kirim pertanyaan baru
Route::post('faq', [FaqController::class, 'store']);

// Cari FAQ berdasarkan keyword
Route::get('faq/search', [FaqController::class, 'search']);

// Filter FAQ berdasarkan kategori
Route::get('faq/kategori/{id}', [FaqController::class, 'byKategori']);

// ---------- Admin FAQ ----------
// hanya Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {

    // Pertanyaan
    Route::get('admin/faq', [FaqController::class, 'adminIndex']); // semua pertanyaan
    Route::get('admin/faq/pending', [FaqController::class, 'pending']); // hanya pending
    Route::put('admin/faq/{id}/jawab', [FaqController::class, 'jawab']); // jawab pertanyaan
    Route::put('admin/faq/{id}/tolak', [FaqController::class, 'tolak']); // tolak pertanyaan
    Route::delete('admin/faq/{id}', [FaqController::class, 'destroy']); // hapus pertanyaan
    Route::delete('admin/faq/public', [FaqController::class, 'deletePublic']); // hapus semua pertanyaan user

    // Kategori FAQ
    Route::get('admin/faq-kategori', [FaqKategoriController::class, 'index']);
    Route::post('admin/faq-kategori', [FaqKategoriController::class, 'store']);
    Route::put('admin/faq-kategori/{id}', [FaqKategoriController::class, 'update']);
    Route::delete('admin/faq-kategori/{id}', [FaqKategoriController::class, 'destroy']);
});
