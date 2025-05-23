<?php

use App\Events\TestReverbEvent;
use App\Http\Controllers\NotificationController;
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
use Illuminate\Support\Facades\Auth;

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
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\VendorStoryController;

Route::get('/test-scheme', function () {
    return request()->getScheme(); // Nó nên trả về 'https'
});
Route::get('/test-header', function () {
    return request()->headers->all();
});

// Main routes
Route::get('/', [MainHomeController::class, 'index'])->name('home');
Route::get('/lodging', [LodgingController::class, 'index'])->name('lodging');
Route::get('/lodging/search', [LodgingController::class, 'search'])->name('lodging.search');
Route::get('/lodging/load-more', [LodgingController::class, 'loadMore'])->name('lodging.load-more');
Route::get('/lodging/detail/{id}', [LodgingController::class, 'detail'])->name('lodging.detail');

Route::get('/dining', [DiningController::class, 'index'])->name('dining');
Route::get('/dining/search', [DiningController::class, 'search'])->name('dining.search');
Route::get('/dining/detail/{id}', [DiningController::class, 'detail'])->name('dining.detail-dining');
Route::get('/dining/load-more', [DiningController::class, 'loadMore'])->name('dining.load-more');

// Auth routes
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Post routes
Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
});
Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
Route::delete('/posts/images/{id}', [PostController::class, 'destroyImage'])->name('posts.images.destroy');
Route::delete('/posts/sections/{id}', [PostController::class, 'destroySection'])->name('posts.sections.destroy');
Route::delete('/posts/section-images/{id}', [PostController::class, 'destroySectionImage'])->name('posts.section-images.destroy');

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

// TikTok Authentication Routes
Route::get('/auth/tiktok', [App\Http\Controllers\Auth\TiktokController::class, 'redirectToTiktok'])->name('tiktok.login');
Route::get('/auth/tiktok/callback', [App\Http\Controllers\Auth\TiktokController::class, 'handleTiktokCallback'])->name('tiktok.callback');

Route::prefix('admin')->group(function () {
    Route::get('roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    Route::post('roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::put('roles/{id}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('roles/{id}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
    Route::post('permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');


    Route::delete('permissions/{id}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');

    Route::resource('users', UserController::class);
    Route::get('/analytics/trustlist-rate', [\App\Http\Controllers\Admin\AnalyticsController::class, 'trustlistRate'])->name('admin.analytics.trustlist_rate');
    Route::get('/analytics/vendor-profile-views', [\App\Http\Controllers\Admin\AnalyticsController::class, 'vendorProfileViews'])->name('admin.analytics.vendor_profile_views');
    Route::get('/analytics/posts-with-engagements', [\App\Http\Controllers\Admin\AnalyticsController::class, 'postsWithEngagements'])->name('admin.analytics.posts_with_engagements');
    Route::get('/analytics/community-posts-with-reactions', [\App\Http\Controllers\Admin\AnalyticsController::class, 'communityPostsWithReactions'])->name('admin.analytics.community_posts_with_reactions');
})->middleware(['auth', 'role:Admin']);

// API routes
Route::get('/api/users/search', [UserController::class, 'search'])->name('api.users.search');
Route::get('/api/check-post-type/{id}', [PostController::class, 'checkPostType'])->name('api.check-post-type');
Route::post('/post/{id}/update-owner', [PostController::class, 'updateOwner'])->name('post.update-owner')->middleware('auth');
Route::post('/post/{id}/add-owner', [PostController::class, 'addOwner'])->name('post.add-owner')->middleware('auth');
Route::delete('/post/{postId}/remove-owner/{userId}', [PostController::class, 'removeOwner'])->name('post.remove-owner')->middleware('auth');

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

    // Cập nhật routes profile
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
    Route::get('/profile/{id}', [UserController::class, 'showUserProfile'])->name('profile.show');
    Route::post('/update-avatar', [UserController::class, 'updateAvatar'])->name('user.update-avatar');

    // Routes cho tính năng Follow
    Route::post('/follow/{id}', [FollowerController::class, 'follow'])->name('user.follow');
    Route::post('/unfollow/{id}', [FollowerController::class, 'unfollow'])->name('user.unfollow');
    Route::post('/follow-toggle/{id}', [FollowerController::class, 'toggle'])->name('user.follow.toggle');
    Route::get('/user/{id}/followers', [FollowerController::class, 'followers'])->name('user.followers');
    Route::get('/user/{id}/following', [FollowerController::class, 'following'])->name('user.following');

    Route::post('/register-popup', [UserController::class, 'updateInfo'])->name('register-popup');

    // Routes cho notifications
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::post('/notifications/mark-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/count', function () {
        $count = Auth::user()->unreadNotifications->count();
        return response()->json(['count' => $count]);
    });
    // Route trang thông báo đầy đủ
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

// Community routes
Route::resource('communities', CommunityController::class);

// Group Membership Routes
Route::resource('groupss', GroupController::class);
Route::middleware(['auth'])->group(function () {
    Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
});
Route::post('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
Route::post('/groups/{group}/add-member', [GroupController::class, 'addMember'])->name('groups.add-member');
Route::get('/groups/{id}/members', [GroupController::class, 'members'])->name('groups.members');
Route::delete('/groups/{group}/members/{user}', [GroupController::class, 'removeMember'])->name('groups.remove-member');
Route::get('/groups/{id}/edit', [GroupController::class, 'edit'])->name('groups.edit');
Route::put('/groups/{id}', [GroupController::class, 'update'])->name('groups.update');

// Comment routes
Route::resource('comments', CommentController::class);

Route::get('/loadmore-posts', [PostController::class, 'getPosts'])->name('posts.getPosts');

// Like routes
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');
    Route::post('/like/{post}', [LikeController::class, 'store'])->name('like.store');
    Route::post('/unlike/{post}', [LikeController::class, 'destroy'])->name('unlike.store');
});

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
Route::post('/interactions', [LeaderboardController::class, 'recordInteraction'])->middleware('auth');
Route::get('/leaderboard/filter', [LeaderboardController::class, 'getFilteredLeaderboard'])->name('leaderboard.filter');
Route::get('/check-tier-upgrade', [LeaderboardController::class, 'checkTierUpgrade'])->name('check.tier.upgrade');

// Analytics routes
Route::get('/analytics/user-activity', [\App\Http\Controllers\Admin\AnalyticsController::class, 'userActivity'])->name('analytics.user-activity');
Route::get('/analytics/trustlist-rate', [\App\Http\Controllers\Admin\AnalyticsController::class, 'trustlistRate'])->name('analytics.trustlist-rate');
Route::get('/analytics/story-post-rate', [\App\Http\Controllers\Admin\AnalyticsController::class, 'storyPostRate'])->name('analytics.story-post-rate');
Route::get('/analytics/vendor-profile-views', [\App\Http\Controllers\Admin\AnalyticsController::class, 'vendorProfileViews'])->name('analytics.vendor-profile-views');
Route::get('/analytics/community-post-rate', [\App\Http\Controllers\Admin\AnalyticsController::class, 'communityPostRate'])->name('analytics.community-post-rate');
Route::get('/analytics/posts-with-engagements', [\App\Http\Controllers\Admin\AnalyticsController::class, 'postsWithEngagements'])->name('analytics.posts-with-engagements');
Route::get('/analytics/community-posts-with-reactions', [\App\Http\Controllers\Admin\AnalyticsController::class, 'communityPostsWithReactions'])->name('analytics.community-posts-with-reactions');
Route::get('/analytics/posts-with-tagged-vendors', [\App\Http\Controllers\Admin\AnalyticsController::class, 'postsWithTaggedVendors'])->name('analytics.posts-with-tagged-vendors');
Route::post('/analytics/record-activity', [\App\Http\Controllers\Admin\AnalyticsController::class, 'recordActivity'])->name('analytics.record-activity');

// Vendor Stories routes
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::resource('stories', VendorStoryController::class);
});

// Public vendor stories route
Route::get('/vendor/{id}/stories', [VendorStoryController::class, 'vendorStories'])->name('vendor.public.stories');

require __DIR__ . '/auth.php';
