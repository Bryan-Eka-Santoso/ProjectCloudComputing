<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\KeluargaAuthController;
use App\Http\Controllers\Auth\PinLoginController;
use App\Http\Controllers\Keluarga\AksesController;
use App\Http\Controllers\Keluarga\DashboardController as KeluargaDashboardController;
use App\Http\Controllers\Keluarga\LansiaController;
use App\Http\Controllers\Keluarga\PengaturanWaktuController;
use App\Http\Controllers\Keluarga\ReminderController;
use App\Http\Controllers\Keluarga\RiwayatKesehatanController;
use App\Http\Controllers\Keluarga\StatistikController;
use App\Http\Controllers\Keluarga\UnlockGameController;
use App\Http\Controllers\Lansia\DashboardController as LansiaDashboardController;
use App\Http\Controllers\Lansia\GamePlayController;
use App\Http\Controllers\Lansia\GoalController;
use App\Http\Controllers\Lansia\SosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman depan
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect()->route('pin-login.create'))->name('home');

/*
|--------------------------------------------------------------------------
| Auth: Lansia (PIN, guard "lansia")
|--------------------------------------------------------------------------
*/

Route::middleware('guest:lansia')->group(function () {
    Route::get('/masuk-lansia', [PinLoginController::class, 'create'])->name('pin-login.create');
    Route::post('/masuk-lansia', [PinLoginController::class, 'store'])->name('pin-login.store');
});
Route::post('/keluar-lansia', [PinLoginController::class, 'destroy'])
    ->middleware('auth:lansia')
    ->name('pin-login.destroy');

/*
|--------------------------------------------------------------------------
| Auth: Keluarga & Admin (email/password, guard "web")
|--------------------------------------------------------------------------
*/

Route::middleware('guest:web')->group(function () {
    Route::get('/login', [KeluargaAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [KeluargaAuthController::class, 'login'])->name('login.store');
    Route::get('/daftar', [KeluargaAuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [KeluargaAuthController::class, 'register'])->name('register.store');
});
Route::post('/logout', [KeluargaAuthController::class, 'logout'])
    ->middleware('auth:web')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Area Lansia
|--------------------------------------------------------------------------
*/

Route::middleware('auth:lansia')->prefix('lansia')->name('lansia.')->group(function () {
    Route::get('/dashboard', [LansiaDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/goal/{goal}', [GoalController::class, 'toggle'])->name('goal.toggle');
    Route::post('/sos', [SosController::class, 'store'])->name('sos.store');

    Route::middleware('play.limit')->group(function () {
        Route::get('/main/{game:slug}', [GamePlayController::class, 'show'])->name('game.show');
        Route::post('/main/{game:slug}', [GamePlayController::class, 'store'])->name('game.store');
    });
});

/*
|--------------------------------------------------------------------------
| Area Keluarga
|--------------------------------------------------------------------------
*/

Route::middleware('auth:web')->prefix('keluarga')->name('keluarga.')->group(function () {
    Route::get('/dashboard', [KeluargaDashboardController::class, 'index'])->name('dashboard');

    Route::get('/lansia/baru', [LansiaController::class, 'create'])->name('lansia.create');
    Route::post('/lansia', [LansiaController::class, 'store'])->name('lansia.store');
    Route::get('/lansia/{lansia}', [LansiaController::class, 'show'])->name('lansia.show');
    Route::get('/lansia/{lansia}/statistik', [StatistikController::class, 'show'])->name('lansia.statistik');

    Route::post('/lansia/{lansia}/reminder', [ReminderController::class, 'store'])->name('lansia.reminder.store');

    // Aksi sensitif: hanya primary caregiver.
    Route::middleware('primary.caregiver')->group(function () {
        Route::get('/lansia/{lansia}/kesehatan', [RiwayatKesehatanController::class, 'edit'])->name('lansia.kesehatan.edit');
        Route::put('/lansia/{lansia}/kesehatan', [RiwayatKesehatanController::class, 'update'])->name('lansia.kesehatan.update');

        Route::put('/lansia/{lansia}/waktu', [PengaturanWaktuController::class, 'update'])->name('lansia.waktu.update');

        Route::post('/lansia/{lansia}/unlock/{game:slug}', [UnlockGameController::class, 'store'])->name('lansia.unlock.store');

        Route::post('/lansia/{lansia}/akses', [AksesController::class, 'store'])->name('lansia.akses.store');
        Route::delete('/lansia/{lansia}/akses/{keluarga}', [AksesController::class, 'destroy'])->name('lansia.akses.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Area Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:web', 'can:akses-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/games', [AdminGameController::class, 'index'])->name('games.index');
    Route::get('/games/baru', [AdminGameController::class, 'create'])->name('games.create');
    Route::post('/games', [AdminGameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [AdminGameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [AdminGameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [AdminGameController::class, 'destroy'])->name('games.destroy');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
});
