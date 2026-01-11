<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('login'); });
Route::get('/test', function () { abort(404); });

Route::middleware(['auth', 'active.user', 'role.admin:admin|super-admin'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/activate', [ProfileController::class, 'activate'])->name('profile.activate');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', fn () => view('admin.dashboard'));
    });

    Route::middleware(['role:super-admin'])->group(function () {
        Route::get('/super-admin', fn () => view('superadmin.dashboard'));
    });
});

require __DIR__.'/auth.php';
