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
<<<<<<< HEAD
use App\Http\Controllers\Api\FaqKategoriController;
use App\Http\Controllers\Api\ProfilController;
=======
use App\Http\Controllers\Api\AdminPertanyaanController;
use App\Http\Controllers\Api\AdminFungsiController;

/*
|--------------------------------------------------------------------------
| API Routes (final, sinkron dengan controller yang ada)
|--------------------------------------------------------------------------
*/
>>>>>>> 628a5af71c44ffc5631f1b29a002baa03bcf40ce

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
<<<<<<< HEAD

// CRUD & Publish hanya Super Admin & Admin Web
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    Route::apiResource('artikel', ArtikelController::class)->except(['index', 'show']);

    // 🔹 Publish artikel
    Route::post('/artikel/{id}/publish', [ArtikelController::class, 'publish'])
        ->name('artikel.publish');
});
=======
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])
    ->group(function () {
        Route::apiResource('artikel', ArtikelController::class)->except(['index', 'show']);
    });
>>>>>>> 628a5af71c44ffc5631f1b29a002baa03bcf40ce

// ===============================
// BERITA & EVENT
// ===============================
<<<<<<< HEAD

// Publik boleh lihat
=======
>>>>>>> 628a5af71c44ffc5631f1b29a002baa03bcf40ce
Route::apiResource('berita', BeritaEventController::class)->only(['index', 'show']);
Route::post('/upload-image', [BeritaEventController::class, 'uploadImage']);
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])
    ->group(function () {
        Route::apiResource('berita', BeritaEventController::class)->except(['index', 'show']);
    });

<<<<<<< HEAD
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
// FAQ
// ===============================
// Public: lihat FAQ & kirim pertanyaan
Route::get('faq', [FaqController::class, 'index']);
Route::post('faq', [FaqController::class, 'store']);

// Public: search FAQ
Route::get('faq/search', [FaqController::class, 'search']);

// Public: filter by kategori
Route::get('faq/kategori/{id}', [FaqController::class, 'byKategori']);

// Admin: kelola pertanyaan & kategori
Route::middleware(['auth:sanctum', 'role:Super Admin,Admin Web'])->group(function () {
    // FAQ pertanyaan
    Route::get('admin/faq', [FaqController::class, 'adminIndex']);
    Route::get('admin/faq/pending', [FaqController::class, 'pending']);
    Route::put('admin/faq/{id}/jawab', [FaqController::class, 'jawab']);
    Route::put('admin/faq/{id}/tolak', [FaqController::class, 'tolak']);
    Route::delete('admin/faq/{id}', [FaqController::class, 'destroy']);
    Route::delete('admin/faq/public', [FaqController::class, 'deletePublic']);

    // FAQ kategori
    Route::get('admin/faq-kategori', [FaqKategoriController::class, 'index']);
    Route::post('admin/faq-kategori', [FaqKategoriController::class, 'store']);
    Route::put('admin/faq-kategori/{id}', [FaqKategoriController::class, 'update']);
    Route::delete('admin/faq-kategori/{id}', [FaqKategoriController::class, 'destroy']);
=======
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
>>>>>>> 628a5af71c44ffc5631f1b29a002baa03bcf40ce
});
