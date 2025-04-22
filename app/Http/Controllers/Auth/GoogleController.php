<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Log;
use Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Tìm user theo email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Nếu user chưa tồn tại, tạo mới
                $user = User::create([
                    'name'       => $googleUser->getName(),
                    'email'      => $googleUser->getEmail(),
                    'google_id'  => $googleUser->getId(),
                    'password'   => bcrypt(Str::random(10)),
                    'provider'   => 'google',
                    'email_verified_at' => now(), // Xác minh luôn nếu tin tưởng Google
                ]);
            } else {
                // Nếu đã có user, cập nhật thông tin
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'provider'  => 'google',
                ]);

                // Nếu chưa xác minh email, đánh dấu là đã xác minh
                if (!$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }
            }

            // Đăng nhập user
            Auth::login($user);

            // Chuyển hướng sau đăng nhập
            return redirect()->intended(route('dashboard'));

        } catch (\Exception $e) {
            // Ghi log lỗi để dễ debug khi có vấn đề
            Log::error('Google login error: ' . $e->getMessage());

            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại. Vui lòng thử lại.');
        }
    }

}
