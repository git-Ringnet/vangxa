<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Carbon\Carbon;

class TrackActivityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, function ($event) {
            // Cập nhật thời gian hoạt động cuối cùng khi đăng nhập
            $event->user->update([
                'last_activity_at' => Carbon::now(),
            ]);
        });
    }
}
