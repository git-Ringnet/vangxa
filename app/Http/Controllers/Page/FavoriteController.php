<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Hiển thị danh sách yêu thích của người dùng
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $query = Post::whereHas('favorites', function($q) {
            $q->where('user_id', Auth::id());
        });

        if ($type) {
            $query->where('type', $type);
        }

        $posts = $query->with(['images', 'favorites'])->get();
        
        // Kiểm tra trạng thái yêu thích cho mỗi bài viết
        foreach ($posts as $post) {
            $post->isFavorited = true; // Đã yêu thích
            $post->favorites_count = $post->favorites()->count();
        }

        return view('pages.favorites.favorite', compact('posts', 'type'));
    }

    /**
     * Thêm hoặc xóa bài viết khỏi danh sách yêu thích
     */
    public function toggleFavorite(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Vui lòng đăng nhập để thêm vào yêu thích',
                    'favorited' => false,
                    'favoritesCount' => 0
                ]);
            }
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm vào yêu thích');
        }

        $post = Post::findOrFail($id);
        
        // Kiểm tra type của post
        if ($post->type != 1 && $post->type != 2) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Loại bài viết không hợp lệ',
                    'favorited' => false,
                    'favoritesCount' => 0
                ]);
            }
            return redirect()->back()->with('error', 'Loại bài viết không hợp lệ');
        }
        
        $favorite = Favorite::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        $isFavorited = false;
        $message = '';

        if ($favorite) {
            $favorite->delete();
            $message = 'Đã bỏ yêu thích';
            $isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
            $message = 'Đã thêm vào yêu thích';
            $isFavorited = true;
        }

        // Lấy số lượng yêu thích mới
        $favoritesCount = Favorite::where('post_id', $post->id)->count();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => $message,
                'favorited' => $isFavorited,
                'favoritesCount' => $favoritesCount
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
} 