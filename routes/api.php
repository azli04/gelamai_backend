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
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\FaqKategoriController;
use App\Http\Controllers\Api\PertanyaanController;

// ===============================
// Auth
// ===============================
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

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
Route::apiResource('layanans', LayananController::class);

// ===============================
// FAQ
// ===============================
// Public
Route::get('faq', [FaqController::class, 'index']);
Route::get('faq/search', [FaqController::class, 'search']);
Route::get('faq/kategori/{id}', [FaqController::class, 'byKategori']);

// Admin
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::get('admin/faq', [FaqController::class, 'adminIndex']);
    Route::delete('admin/faq/{id}', [FaqController::class, 'destroy']);

    // FAQ kategori
    Route::get('admin/faq-kategori', [FaqKategoriController::class, 'index']);
    Route::post('admin/faq-kategori', [FaqKategoriController::class, 'store']);
    Route::put('admin/faq-kategori/{id}', [FaqKategoriController::class, 'update']);
    Route::delete('admin/faq-kategori/{id}', [FaqKategoriController::class, 'destroy']);
});

// ===============================
// Pertanyaan
// ===============================
// Public
Route::post('/pertanyaan', [PertanyaanController::class, 'store']);
Route::get('/pertanyaan/{id}', [PertanyaanController::class, 'show']);

// Admin
Route::middleware(['auth:sanctum','role:Super Admin,Admin Web'])->group(function () {
    Route::get('/admin/pertanyaan', [PertanyaanController::class, 'adminIndex']);
    Route::get('/admin/pertanyaan/pending', [PertanyaanController::class, 'pending']);
    Route::post('/admin/pertanyaan/{id}/jawab', [PertanyaanController::class, 'jawab']);
    Route::post('/admin/pertanyaan/{id}/tolak', [PertanyaanController::class, 'tolak']);
    Route::delete('/admin/pertanyaan/{id}', [PertanyaanController::class, 'destroy']);
});
