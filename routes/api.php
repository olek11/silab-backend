<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ToolController;
use App\Http\Controllers\API\MaterialController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\AdminController;

/*
|--------------------------------------------------------------------------
| 🔓 PUBLIC API Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/tools', [ToolController::class, 'index']);
Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/materials', [MaterialController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| 📊 Statistik Admin (Login + Role)
|--------------------------------------------------------------------------
*/
Route::get('/admin/stats', [AdminController::class, 'stats'])
    ->middleware(['auth:sanctum', 'can:isAdmin']);

/*
|--------------------------------------------------------------------------
| 🔐 Protected API (Login Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // 🔓 User biasa
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/bookings', [BookingController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | 🛂 Admin-only API
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:isAdmin')->group(function () {

        // ✅ CRUD Tools, Rooms, Materials
        Route::apiResource('tools', ToolController::class)->except(['index']);
        Route::apiResource('rooms', RoomController::class)->except(['index']);
        Route::apiResource('materials', MaterialController::class)->except(['index']);

        // ✅ CRUD Pengguna
        Route::get('users', [AdminController::class, 'index']);             // List pengguna
        Route::post('users', [AdminController::class, 'store']);            // Tambah pengguna
        Route::patch('users/{id}', [AdminController::class, 'update']);     // Edit nama/email
        Route::patch('users/{id}/role', [AdminController::class, 'updateRole']); // Ubah role
        Route::delete('users/{id}', [AdminController::class, 'destroy']);   // Hapus pengguna

        // 📥📤 Import / Export
        Route::post('users/import', [AdminController::class, 'import']);    // Import Excel
        Route::get('users/export', [AdminController::class, 'export']);     // Export Excel
    });
});
