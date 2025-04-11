<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiningController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')
            ->where('type', 2) // Type 2 for dining
            ->take(18)
            ->get();

        return view('pages.dining.dining', compact('posts'));
    }

    public function detail($id)
    {
        try {
            $post = Post::with('images')
                ->where('type', 2) // Type 2 for dining
                ->findOrFail($id);

            Log::info('Dining detail loaded', ['post_id' => $id, 'post' => $post]);

            return view('pages.dining.detail-dining', compact('post'));
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