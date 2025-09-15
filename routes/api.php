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
use Illuminate\Support\Facades\Storage;


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

// Users & Roles (hanya superadmin)
// ===============================
Route::middleware(['auth:sanctum', 'superadmin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
});

// ===============================
// Aplikasi
// ===============================
// Semua user boleh lihat
Route::get('aplikasi', [AplikasiController::class, 'index']);
Route::get('aplikasi/{id}', [AplikasiController::class, 'show']);

// Hanya Super Admin & Admin Web boleh CRUD
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('aplikasi', AplikasiController::class)->except(['index', 'show']);
});

// ===============================
// Artikel
// ===============================
// Publik boleh lihat
Route::apiResource('artikel', ArtikelController::class)->only(['index', 'show']);

// Hanya Super Admin & Admin Web boleh CRUD
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('artikel', ArtikelController::class)->except(['index', 'show']);
});

// ===============================
// Berita & Event
// ===============================
// Publik boleh lihat
Route::apiResource('berita', BeritaEventController::class)->only(['index', 'show']);

// Hanya Super Admin & Admin Web boleh CRUD
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('berita', BeritaEventController::class)->except(['index', 'show']);
});


// ===============================
// Layanan
// ===============================
// Publik boleh lihat
Route::apiResource('layanans', LayananController::class);

