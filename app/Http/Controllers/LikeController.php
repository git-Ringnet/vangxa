<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Kiểm tra xem người dùng đã like chưa
        $existingLike = Like::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            return response()->json([
                'success' => false,
                'message' => 'You have already liked this post'
            ]);
        }

        // Tạo like mới
        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ]);

        // Lấy lại số lượng like mới nhất
        $post->load('likes');
        
        return response()->json([
            'success' => true,
            'count' => $post->likes->count(),
            'is_liked' => true
        ]);
    }

    public function destroy(Request $request, Post $post)
    {
        // Tìm like của người dùng
        $like = Like::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->first();

        if (!$like) {
            return response()->json([
                'success' => false,
                'message' => 'You have not liked this post'
            ]);
        }

        // Xóa like
        $like->delete();

        // Lấy lại số lượng like mới nhất
        $post->load('likes');
        
        return response()->json([
            'success' => true,
            'count' => $post->likes->count(),
            'is_liked' => false
        ]);
    }
} 