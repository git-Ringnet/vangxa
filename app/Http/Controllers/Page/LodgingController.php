<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LodgingController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')
            ->where('type', 1) // Type 1 for accommodations
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

        return view('pages.listings.lodging', compact('posts'));
    }

    public function detail($id)
    {
        try {
            $post = Post::with('images')
                ->where('type', 1) // Type 1 for accommodations
                ->findOrFail($id);
                
            // Kiểm tra trạng thái yêu thích
            if (Auth::check()) {
                $post->isFavorited = Favorite::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->exists();
            } else {
                $post->isFavorited = false;
            }

            Log::info('Accommodation detail loaded', ['post_id' => $id, 'post' => $post]);

            return view('pages.listings.detail', compact('post'));
        } catch (\Exception $e) {
            Log::error('Error loading accommodation detail', [
                'post_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('lodging')->with('error', 'Không tìm thấy bài viết');
        }
    }

    public function loadMore(Request $request)
    {
        $offset = $request->input('offset', 18);
        $posts = Post::with('images')
            ->where('type', 1) // Type 1 for accommodations
            ->skip($offset)
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

        $hasMore = Post::where('type', 1)->count() > ($offset + 18);

        return response()->json([
            'html' => view('pages.listings.partials.posts', compact('posts'))->render(),
            'hasMore' => $hasMore
        ]);
    }
}
