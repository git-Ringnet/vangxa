<?php

namespace App\Http\Controllers;

use App\Events\LikeEvent;
use App\Events\UnlikeEvent;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
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
                'message' => 'Bạn đã thích bài viết này rồi'
            ]);
        }

        // Tạo like mới
        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ]);

        // Lấy người dùng hiện tại
        $currentUser = User::find(Auth::id());

        // Dispatch event để tạo thông báo
        if ($post->user_id != Auth::id()) {
            event(new LikeEvent($post, $currentUser));
        }

        // Lấy lại số lượng like mới nhất
        $post->load('likes');
        
        return response()->json([
            'success' => true,
            'message' => 'Đã thích bài viết',
            'likes_count' => $post->likes->count(),
            'is_liked' => true,
            'post_id' => $post->id
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
                'message' => 'Bạn chưa thích bài viết này'
            ]);
        }

        // Lấy người dùng hiện tại trước khi xóa like
        $currentUser = User::find(Auth::id());

        // Dispatch event để tạo thông báo unlike
        if ($post->user_id != Auth::id()) {
            event(new UnlikeEvent($post, $currentUser));
        }

        // Xóa like
        $like->delete();

        // Lấy lại số lượng like mới nhất
        $post->load('likes');
        
        return response()->json([
            'success' => true,
            'message' => 'Đã bỏ thích bài viết',
            'likes_count' => $post->likes->count(),
            'is_liked' => false,
            'post_id' => $post->id
        ]);
    }
} 