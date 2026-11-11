<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AffiliateProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/u/{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');

Route::get('/p/{affiliateProduct}', [AffiliateProductController::class, 'redirect'])->name('products.redirect');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::resource('products', AffiliateProductController::class)
        ->except(['show']);

    Route::middleware('master')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
        Route::post('/users/{user}/unban', [AdminUserController::class, 'unban'])->name('users.unban');
    });
});

require __DIR__.'/auth.php';
