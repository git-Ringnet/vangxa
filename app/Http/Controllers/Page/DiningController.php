<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Trustlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DiningController extends Controller
{
    public function index()
    {
        $posts = Post::where('type', 2)->with('images')->orderBy('created_at', 'desc')->limit(30)->get();
        $userTrustlist = Trustlist::where('user_id', Auth::id())
            ->pluck('post_id')
            ->toArray();

        foreach ($posts as $post) {
            $post->isSaved = in_array($post->id, $userTrustlist);
        }

        return view('pages.dining.dining', compact('posts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $posts = Post::where('type', 2)
            ->where('title', 'like', "%{$query}%")
            ->with('images')
            ->get();

        return response()->json([
            'html' => view('pages.dining.posts', compact('posts'))->render()
        ]);
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
                $isFavorited = Trustlist::where('user_id', Auth::id())
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
        $offset = $request->input('offset', 30);
        $totalPosts = Post::where('type', 2)->count();
        
        Log::info('Load more request - Dining', [
            'offset' => $offset,
            'totalPosts' => $totalPosts
        ]);
        
        // Tính số lượng bài viết còn lại
        $remainingPosts = $totalPosts - $offset;
        // Nếu còn ít hơn 30 bài, chỉ lấy số lượng còn lại
        $takeCount = min(30, $remainingPosts);
        
        Log::info('Calculated values - Dining', [
            'remainingPosts' => $remainingPosts,
            'takeCount' => $takeCount
        ]);
        
        $posts = Post::with('images')
            ->where('type', 2) // Type 2 for dining
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
        
        Log::info('Response data - Dining', [
            'postsCount' => count($posts),
            'hasMore' => $hasMore,
            'nextOffset' => $offset + $takeCount
        ]);

        return response()->json([
            'html' => view('pages.dining.posts', compact('posts'))->render(),
            'hasMore' => $hasMore,
            'total' => $totalPosts,
            'nextOffset' => $offset + $takeCount
        ]);
    }
}
