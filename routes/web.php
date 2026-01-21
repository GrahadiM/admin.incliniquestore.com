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

        // CRUD Resources
        Route::resources([
            'users' => \App\Http\Controllers\SuperAdmin\UserController::class,
            'branches' => \App\Http\Controllers\SuperAdmin\BranchController::class,
            'member-levels' => \App\Http\Controllers\SuperAdmin\MemberLevelController::class,
            'vouchers' => \App\Http\Controllers\SuperAdmin\VoucherController::class,
            'categories' => \App\Http\Controllers\SuperAdmin\CategoryController::class,
            'products' => \App\Http\Controllers\SuperAdmin\ProductController::class,
            'news' => \App\Http\Controllers\SuperAdmin\NewsController::class,
        ]);

        Route::get('news-preview/{slug}', [\App\Http\Controllers\SuperAdmin\NewsController::class, 'preview'])->name('news.preview');
        Route::get('news-analytics', [\App\Http\Controllers\SuperAdmin\NewsController::class, 'analytics'])->name('news.analytics');
    });
});

// API / AJAX views
Route::get('/news/{news}/views/realtime', fn(\App\Models\News $news) => response()->json(['views' => $news->views]))->name('news.views.realtime');


require __DIR__.'/auth.php';
