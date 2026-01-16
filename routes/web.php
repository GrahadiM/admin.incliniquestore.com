<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () { return redirect()->route('login'); });
Route::get('/test', function () { abort(404); });

Route::middleware(['auth', 'active.user', 'role:admin|super-admin'])->group(function () {
    // Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/activate', [ProfileController::class, 'activate'])->name('profile.activate');

    // ADMIN ONLY
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    });

    // SUPER ADMIN ONLY
    Route::middleware(['role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');

        // Manage Users
        Route::resource('users', \App\Http\Controllers\SuperAdmin\UserController::class);

        // Manage Branch Stores
        Route::resource('branches', \App\Http\Controllers\SuperAdmin\BranchController::class);

        // Manage Member Levels
        Route::resource('member-levels', \App\Http\Controllers\SuperAdmin\MemberLevelController::class);

        // Manage Vouchers
        Route::resource('vouchers', \App\Http\Controllers\SuperAdmin\VoucherController::class);

        // Manage Categories
        Route::resource('categories', \App\Http\Controllers\SuperAdmin\CategoryController::class);

        // Manage Products
        Route::resource('products', \App\Http\Controllers\SuperAdmin\ProductController::class);
    });
});

require __DIR__.'/auth.php';
