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

<<<<<<< HEAD
// Users & Roles (hanya superadmin)
=======
// ===============================
// Users & Roles (khusus Super Admin)
>>>>>>> 675e2fda4dad5cb621b732948a4b5b3096e168cf
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
// Layanan
// ===============================
// Publik boleh lihat
Route::apiResource('layanans', LayananController::class);
