<?php

use App\Events\TestReverbEvent;
use App\Http\Controllers\Page\TrustlistController;
use App\Http\Controllers\RolePermissionController;
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
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ShareController;

Route::get('/test-scheme', function () {
    return request()->getScheme(); // Nó nên trả về 'https'
});
Route::get('/test-header', function () {
    return request()->headers->all();
});

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
// Route::middleware(['auth'])->group(function () {
//     Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
//     Route::post('/favorites/{id}', [FavoriteController::class, 'toggleFavorite'])->name('favorites.favorite');
// });

// Trustlist routes
Route::middleware(['auth'])->group(function () {
    Route::get('/trustlist', [TrustlistController::class, 'index'])->name('trustlist');
    Route::post('/trustlist/{id}', [TrustlistController::class, 'toggle'])->name('trustlist.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/{id}', [FavoriteController::class, 'toggleFavorite'])->name('favorites.favorite');

    Route::get('/profile', [UserController::class, 'show'])->name('profile');

    Route::post('/register-popup', [UserController::class, 'updateInfo'])->name('register-popup');
});

// Community routes
Route::resource('communities', CommunityController::class);

// Group Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('groupss', GroupController::class);

    // Group Membership Routes
    Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
    Route::post('/groups/{group}/add-member', [GroupController::class, 'addMember'])->name('groups.add-member');
    Route::get('/groups/{id}/members', [GroupController::class, 'members'])->name('groups.members');
    Route::delete('/groups/{group}/members/{user}', [GroupController::class, 'removeMember'])->name('groups.remove-member');
    Route::get('/groups/{id}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{id}', [GroupController::class, 'update'])->name('groups.update');
});

// Comment routes
Route::resource('comments', CommentController::class);

Route::get('/posts', [PostController::class, 'getPosts'])->name('posts.getPosts');

// Like routes
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');
});

require __DIR__ . '/auth.php';
