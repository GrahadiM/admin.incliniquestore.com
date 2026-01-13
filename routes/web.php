<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('login'); });
Route::get('/test', function () { abort(404); });

Route::middleware(['auth', 'active.user', 'role:admin|super-admin'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/activate', [ProfileController::class, 'activate'])->name('profile.activate');

    // ADMIN ONLY
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', fn () => view('admin.dashboard'));
    });

    // SUPER ADMIN ONLY
    Route::middleware(['role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('/dashboard', fn () => view('super-admin.dashboard'));

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
