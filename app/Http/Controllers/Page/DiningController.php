<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DiningController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')
            ->where('type', 2) // Type 2 for dining
            ->take(18)
            ->get();
            
        // Kiểm tra trạng thái yêu thích cho mỗi bài viết
        if (Auth::check()) {
            $userFavorites = Favorite::where('user_id', Auth::id())
                ->pluck('post_id')
                ->toArray();
                
            foreach ($posts as $post) {
                $post->isFavorited = in_array($post->id, $userFavorites);
            }
        } else {
            foreach ($posts as $post) {
                $post->isFavorited = false;
            }
        }

        return view('pages.dining.dining', compact('posts'));
    }

    public function detail($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new \Exception('ID bài đăng không hợp lệ');
            }
            $post = Post::with(['images', 'reviews.user'])
                ->where('type', 2) // Type 2 for dining
                ->findOrFail($id);

            Log::info('Dining detail loaded', ['post_id' => $id, 'post' => $post]);

            // Kiểm tra xem người dùng đã đăng nhập chưa và đã yêu thích bài viết chưa
            $isFavorited = false;
            if (Auth::check()) {
                $isFavorited = Favorite::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->exists();
            }

            return view('pages.dining.detail-dining', compact('post', 'isFavorited'));
        } catch (\Exception $e) {
            Log::error('Error loading dining detail', [
                'post_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('dining')->with('error', 'Không tìm thấy bài viết');
        }
    }

    public function loadMore(Request $request)
    {
        $offset = $request->input('offset', 18);
        $posts = Post::with('images')
            ->where('type', 2) // Type 2 for dining
            ->skip($offset)
            ->take(18)
            ->get();

        $hasMore = Post::where('type', 2)->count() > ($offset + 18);

        return response()->json([
            'html' => view('pages.dining.posts', compact('posts'))->render(),
            'hasMore' => $hasMore
        ]);
    }
}
