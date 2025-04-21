<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Nếu người dùng đã xác minh email trước đó, chuyển hướng đến dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        }

        // Nếu người dùng chưa xác minh email, đánh dấu email là đã xác minh
        if ($request->user()->markEmailAsVerified()) {
            /** @var \Illuminate\Contracts\Auth\MustVerifyEmail $user */
            $user = $request->user();

            // Gửi sự kiện khi email được xác minh thành công
            event(new Verified($user));
        }

        // Chuyển hướng sau khi xác minh email
        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
    }
}
