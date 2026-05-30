<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\InsidenSiberController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\JadwalPemeliharaanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TiketKomentarController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Form laporan (akses utama)
Route::get('/', [PublicController::class, 'formLapor'])->name('lapor');

// Redirect /lapor ke halaman form (agar tidak error jika pengguna ketik /lapor)
Route::redirect('/lapor', '/');

// Submit laporan (POST)
Route::post('/lapor', [PublicController::class, 'submitLaporan'])->name('lapor.submit');

// Pantau tiket berdasarkan kode unik
Route::get('/pantau/{kode_unik}', [PublicController::class, 'pantau'])->name('pantau');

// Submit feedback dari pelapor
Route::post('/feedback/{tiket}', [PublicController::class, 'submitFeedback'])->name('feedback.submit');

// Komentar dari pelapor (publik)
Route::post('/pantau/{kode_unik}/komentar', [TiketKomentarController::class, 'storePublic'])
    ->name('pantau.komentar.store');

/*
|--------------------------------------------------------------------------
| Dashboard Default (untuk kompatibilitas Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes (dengan middleware auth & role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin,kepala_it,teknisi'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Tiket
        Route::resource('tikets', TiketController::class)->except(['show']);
        Route::get('tikets/{tiket}/show', [TiketController::class, 'show'])->name('tikets.show');
        Route::patch('tikets/{tiket}/status', [TiketController::class, 'updateStatus'])->name('tikets.update-status');

        // Komentar dari admin/teknisi (di dalam grup admin, path relatif)
        Route::post('tikets/{tiket}/komentar', [TiketKomentarController::class, 'storeAdmin'])
            ->name('tikets.komentar.store');

        // Inventaris
        Route::resource('inventaris', InventarisController::class)->except(['show']);
        Route::get('inventaris/{inventari}/show', [InventarisController::class, 'show'])->name('inventaris.show');

        // Pekerjaan / Kanban
        Route::get('/pekerjaan/kanban', [PekerjaanController::class, 'kanban'])->name('pekerjaan.kanban');
        Route::post('/pekerjaan', [PekerjaanController::class, 'store'])->name('pekerjaan.store');
        Route::patch('/pekerjaan/{pekerjaan}/status', [PekerjaanController::class, 'updateStatus'])->name('pekerjaan.update-status');

        // Jadwal Pemeliharaan
        Route::resource('jadwal-pemeliharaan', JadwalPemeliharaanController::class)
            ->except(['show'])
            ->names([
                'index'   => 'jadwal-pemeliharaan.index',
                'create'  => 'jadwal-pemeliharaan.create',
                'store'   => 'jadwal-pemeliharaan.store',
                'edit'    => 'jadwal-pemeliharaan.edit',
                'update'  => 'jadwal-pemeliharaan.update',
                'destroy' => 'jadwal-pemeliharaan.destroy',
            ]);

        // Dokumen
        Route::resource('dokumen', DokumenController::class)
            ->except(['show'])
            ->parameters(['dokumen' => 'dokumen'])
            ->names([
                'index'   => 'dokumen.index',
                'create'  => 'dokumen.create',
                'store'   => 'dokumen.store',
                'edit'    => 'dokumen.edit',
                'update'  => 'dokumen.update',
                'destroy' => 'dokumen.destroy',
            ]);
        Route::get('dokumen/{dokumen}/show', [DokumenController::class, 'show'])->name('dokumen.show');
        Route::get('dokumen/{dokumen}/download', [DokumenController::class, 'download'])->name('dokumen.download');

        // Log Aktivitas
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
        Route::get('/log-aktivitas/{logAktivitas}', [LogAktivitasController::class, 'show'])->name('log-aktivitas.show');

        // Insiden Siber
        Route::resource('insiden-siber', InsidenSiberController::class)
            ->except(['show'])
            ->parameters(['insiden-siber' => 'insidenSiber'])
            ->names([
                'index'   => 'insiden-siber.index',
                'create'  => 'insiden-siber.create',
                'store'   => 'insiden-siber.store',
                'edit'    => 'insiden-siber.edit',
                'update'  => 'insiden-siber.update',
                'destroy' => 'insiden-siber.destroy',
            ]);
        Route::get('insiden-siber/{insidenSiber}/show', [InsidenSiberController::class, 'show'])
            ->name('insiden-siber.show');

        // Tandai semua notifikasi telah dibaca
        Route::post('/notifications/mark-all-read', function () {
            Auth::user()->unreadNotifications->markAsRead();
            return back();
        })->name('notifications.mark-all-read');
    });

/*
|--------------------------------------------------------------------------
| Auth Routes (dari Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';