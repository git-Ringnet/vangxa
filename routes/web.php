<?php

use App\Http\Controllers\AdminController as ControllersAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\HomeController;
use Livewire\Volt\Volt;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VangXaController;
use App\Models\adminController;

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

// Admin routes
Route::resource('vangxa', VangXaController::class);

// Settings routes
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Other routes
Route::get('/detail-dining', function () {
    return view('pages/dining/detail-dining');
})->name('detail-dining');

Route::get('/dining', function () {
    return view('pages/dining/dining');
})->name('dining');

require __DIR__ . '/auth.php';
