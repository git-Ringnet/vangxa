<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'food_rating' => 'nullable|integer|min:1|max:5',
            'satisfaction_level' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|min:10|max:1000'
        ], [
            'food_rating.integer' => 'Đánh giá sao không hợp lệ',
            'food_rating.min' => 'Đánh giá sao phải từ 1-5',
            'food_rating.max' => 'Đánh giá sao phải từ 1-5',
            'satisfaction_level.integer' => 'Mức độ hài lòng không hợp lệ',
            'satisfaction_level.min' => 'Mức độ hài lòng phải từ 1-5',
            'satisfaction_level.max' => 'Mức độ hài lòng phải từ 1-5',
            'comment.min' => 'Nhận xét phải có ít nhất 10 ký tự',
            'comment.max' => 'Nhận xét không được vượt quá 1000 ký tự'
        ]);

        // Kiểm tra có ít nhất 1 loại đánh giá
        if (!$request->food_rating && !$request->satisfaction_level && !$request->comment) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['general' => 'Vui lòng chọn ít nhất một loại đánh giá (sao, biểu tượng hoặc nhận xét)']);
        }

        $review = Review::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id() ?? 1,
            'food_rating' => $request->food_rating,
            'satisfaction_level' => $request->satisfaction_level,
            'comment' => $request->comment,
            'status' => 1,
            'type' => $post->type,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
} 