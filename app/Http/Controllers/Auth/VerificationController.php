<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VerificationController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $user = Auth::user();

        // Tạo mã xác thực ngẫu nhiên 6 chữ số
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Cập nhật thông tin xác thực cho user
        $user->update([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => Carbon::now()->addMinutes(15),
            'is_verified' => false
        ]);

        try {
            // Gửi email chào mừng và mã xác thực
            Mail::send('emails.welcome', [
                'user' => $user,
                'verificationCode' => $verificationCode
            ], function($message) use ($user) {
                $message->to($user->email);
                $message->subject('Chào mừng đến với Vangxa - Xác thực tài khoản');
            });

            return response()->json([
                'message' => 'Mã xác thực đã được gửi đến email của bạn',
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra khi gửi email: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $user = Auth::user();

        // Kiểm tra mã xác thực
        if ($user->verification_code === $request->code &&
            Carbon::now()->lessThan($user->verification_code_expires_at)) {

            $user->update([
                'is_verified' => true,
                'verification_code' => null,
                'verification_code_expires_at' => null
            ]);

            return response()->json([
                'message' => 'Xác thực thành công',
                'status' => 'success'
            ]);
        }

        return response()->json([
            'message' => 'Mã xác thực không hợp lệ hoặc đã hết hạn',
            'status' => 'error'
        ], 422);
    }
}
