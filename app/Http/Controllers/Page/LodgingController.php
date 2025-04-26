<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Trustlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LodgingController extends Controller
{
    public function index()
    {
        $posts = Post::where('type', 1)->with('images')->orderBy('created_at', 'desc')->limit(30)->get();
        $userTrustlist = Trustlist::where('user_id', Auth::id())
            ->pluck('post_id')
            ->toArray();

        foreach ($posts as $post) {
            $post->isSaved = in_array($post->id, $userTrustlist);
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
                $post->isSaved = Trustlist::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->exists();
            } else {
                $post->isSaved = false;
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
        $offset = $request->input('offset', 30);
        $totalPosts = Post::where('type', 1)->count();
        
        Log::info('Load more request', [
            'offset' => $offset,
            'totalPosts' => $totalPosts
        ]);
        
        // Tính số lượng bài viết còn lại
        $remainingPosts = $totalPosts - $offset;
        // Nếu còn ít hơn 30 bài, chỉ lấy số lượng còn lại
        $takeCount = min(30, $remainingPosts);
        
        Log::info('Calculated values', [
            'remainingPosts' => $remainingPosts,
            'takeCount' => $takeCount
        ]);
        
        $posts = Post::with('images')
            ->where('type', 1) // Type 1 for accommodations
            ->skip($offset)
            ->take($takeCount)
            ->get();
            
        // Kiểm tra trạng thái yêu thích cho mỗi bài viết
        if (Auth::check()) {
            $userTrustlist = Trustlist::where('user_id', Auth::id())
                ->pluck('post_id')
                ->toArray();
                
            foreach ($posts as $post) {
                $post->isSaved = in_array($post->id, $userTrustlist);
            }
        } else {
            foreach ($posts as $post) {
                $post->isSaved = false;
            }
        }

        // Kiểm tra xem còn bài viết nào nữa không
        $hasMore = ($offset + $takeCount) < $totalPosts;
        
        Log::info('Response data', [
            'postsCount' => count($posts),
            'hasMore' => $hasMore,
            'nextOffset' => $offset + $takeCount
        ]);

        return response()->json([
            'html' => view('pages.listings.posts', compact('posts'))->render(),
            'hasMore' => $hasMore,
            'total' => $totalPosts,
            'nextOffset' => $offset + $takeCount
        ]);
    }
}
