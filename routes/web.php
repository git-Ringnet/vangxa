<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Livewire\Volt\Volt;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


Route::get('/detail', function () {
    return view('detail');
})->name('detail');
Route::get('/detail-dining', function () {
    return view('detail-dining');
})->name('detail-dining');

Route::get('/dining', function () {
    return view('dining');
})->name('dining');

require __DIR__.'/auth.php';
