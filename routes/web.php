<?php

use App\Events\TestReverbEvent;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\HomeController;
use App\Http\Controllers\Page\LodgingController;
use Livewire\Volt\Volt;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VangXaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController as MainHomeController;

use App\Http\Controllers\Page\DiningController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Page\CommunityController;
use App\Http\Controllers\Page\FavoriteController;


// Main routes
Route::get('/', [MainHomeController::class, 'index'])->name('home');
Route::get('/lodging', [LodgingController::class, 'index'])->name('lodging');

Route::get('/detail/{id}', [LodgingController::class, 'detail'])->name('detail');
Route::get('/load-more', [LodgingController::class, 'loadMore'])->name('load-more');

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


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Settings routes
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Route::post('/send-verification-code', [VerificationController::class, 'sendVerificationCode'])->name('send.verification.code');
    // Route::post('/verify-code', [VerificationController::class, 'verifyCode'])->name('verify.code');
});

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/auth/tiktok', [TiktokController::class, 'redirectToTiktok'])->name('tiktok.login');
Route::get('/auth/tiktok/callback', [TiktokController::class, 'handleTiktokCallback'])->name('tiktok.callback');

Route::prefix('admin')->group(function () {
    Route::get('roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    Route::post('roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::put('roles/{id}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('roles/{id}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
    Route::post('permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::delete('permissions/{id}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');

    Route::resource('users', UserController::class);
})->middleware(['auth', 'role:Admin']);

// Dining routes
Route::get('/dining', [DiningController::class, 'index'])->name('dining');
Route::get('/dining/detail/{id}', [DiningController::class, 'detail'])->name('dining.detail-dining');
Route::get('/dining/load-more', [DiningController::class, 'loadMore'])->name('dining.load-more');

// Favorites routes
Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/{id}', [FavoriteController::class, 'toggleFavorite'])->name('favorites.favorite');
});


// Community routes
Route::resource('community', CommunityController::class);

// Comment routes
Route::resource('comments', CommentController::class);


Route::get('/test-reverb', function () {
    event(new TestReverbEvent('Hello, Reverb!'));
    return 'Conmeno!';
});

Route::get('/test-reverb-page', function () {
    return view('test-reverb');
});

require __DIR__ . '/auth.php';
