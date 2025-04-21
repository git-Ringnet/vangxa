<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
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

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(rand(100000, 999999)),
                    'provider' => 'google',
                    'email_verified_at'=> now(),
                    'is_verified'=> 1,
                    'remember_token' => Str::random(60)
                ]);
                $user->markEmailAsVerified();
            } else {
                $user->update([
                    'google_id' => $googleUser->id,
                    'provider' => 'google',
                    'email_verified_at'=> now(),
                    'is_verified'=> 1,
                    'remember_token' => Str::random(60)
                ]);
                $user->markEmailAsVerified();
            }

            Auth::login($user);

            return redirect()->intended('/');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong with Google login.');
        }
    }
}
