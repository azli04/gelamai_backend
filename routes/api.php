<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\AplikasiController;

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

// default user endpoint
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ===============================
// Semua user login bisa lihat (index & show)
// ===============================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);

    Route::get('roles', [RoleController::class, 'index']);
    Route::get('roles/{id}', [RoleController::class, 'show']);
});

// ===============================
// CRUD penuh hanya untuk superadmin
// ===============================
Route::middleware(['auth:sanctum', 'superadmin'])->group(function () {
    Route::apiResource('users', UserController::class)->except(['index', 'show']);
    Route::apiResource('roles', RoleController::class)->except(['index', 'show']);
});


// ===============================
// Aplikasi routes
// ===============================

Route::middleware(['auth:sanctum'])->group(function () {
    // hanya Super Admin & Admin Web
    Route::middleware(['role:Super Admin,Admin Web'])->group(function () {
        Route::apiResource('aplikasi', AplikasiController::class);
    });
});

// semua user boleh lihat
    Route::get('aplikasi', [AplikasiController::class, 'index']);
    Route::get('aplikasi/{id}', [AplikasiController::class, 'show']);