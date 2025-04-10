<?php

use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\HomeController;
use Livewire\Volt\Volt;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VangXaController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Page\DiningController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ReviewController;


// Main routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
Route::get('/load-more', [HomeController::class, 'loadMore'])->name('load-more');

// Auth routes
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Post routes
Route::resource('posts', PostController::class);
Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
Route::delete('/posts/images/{id}', [PostController::class, 'destroyImage'])->name('posts.images.destroy');

// Review routes
Route::resource('reviews', ReviewController::class);

// Admin routes
Route::resource('vangxa', VangXaController::class);

// Settings routes
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::post('/send-verification-code', [VerificationController::class, 'sendVerificationCode'])->name('send.verification.code');
    Route::post('/verify-code', [VerificationController::class, 'verifyCode'])->name('verify.code');
});

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::prefix('admin')->group(function () {
    Route::get('roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    Route::post('roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::put('roles/{id}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('roles/{id}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
    Route::post('permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::delete('permissions/{id}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');

    Route::resource('users', UserController::class);
})->middleware(['auth', 'role:Admin']);

Route::get('/detail-dining', function () {
    return view('pages/dining/detail-dining');
})->name('detail-dining');

Route::get('/dining', [DiningController::class, 'index'])->name('dining');
Route::get('/dining/detail/{id}', [DiningController::class, 'detail'])->name('dining.detail-dining');
Route::get('/dining/load-more', [DiningController::class, 'loadMore'])->name('dining.load-more');

require __DIR__ . '/auth.php';
