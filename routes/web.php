<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'formLapor'])->name('lapor');
Route::post('/lapor', [PublicController::class, 'submitLaporan'])->name('lapor.submit');
Route::get('/pantau/{kode_unik}', [PublicController::class, 'pantau'])->name('pantau');

// Dashboard default (tanpa prefix admin) untuk kompatibilitas Breeze
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin Routes (dengan role middleware)
Route::middleware(['auth', 'role:super_admin,kepala_it,teknisi'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Tiket
        Route::resource('tikets', TiketController::class)->except(['show']);
        Route::get('tikets/{tiket}/show', [TiketController::class, 'show'])->name('tikets.show');
        Route::patch('tikets/{tiket}/status', [TiketController::class, 'updateStatus'])->name('tikets.update-status');
        
        // Inventaris
        Route::resource('inventaris', InventarisController::class)->except(['show']);
        Route::get('inventaris/{inventari}/show', [InventarisController::class, 'show'])->name('inventaris.show');
    });

require __DIR__.'/auth.php';