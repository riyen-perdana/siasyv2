<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Fe/index');
});

Route::get('/login-petugas', function () {
    return Inertia::render('Auth/LoginPetugas');
})->name('login-petugas');

Route::get('/lupa-password', function () {
    return Inertia::render('Auth/LupaPassword');
})->name('lupa-password');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('apps')->group(function () {
    Route::get('/perizinan-aplikasi', [\App\Http\Controllers\Apps\PermissionController::class, 'index'])->name('apps.permission.index');
    Route::post('/perizinan-aplikasi', [\App\Http\Controllers\Apps\PermissionController::class, 'store'])->name('apps.permission.store');

    Route::get('/perizinan-aplikasi-v2', [\App\Http\Controllers\Apps\PermissionsController::class, 'index'])->name('apps.permissionv2.index');
    Route::get('/otorisasi-aplikasi', [\App\Http\Controllers\Apps\RolesController::class, 'index'] )->name('apps.roles.index');
});

require __DIR__.'/auth.php';
