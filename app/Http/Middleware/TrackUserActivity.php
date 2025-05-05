<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Cập nhật thời gian hoạt động cuối cùng của người dùng
            Auth::user()->update([
                'last_activity_at' => Carbon::now(),
            ]);
        }

        return $next($request);
    }
}
