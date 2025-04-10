<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')->take(18)->get();
        return view('pages.listings.home', compact('posts'));
    }

    public function detail($id)
    {
        $post = Post::with('images')->findOrFail($id);
        return view('pages.listings.detail', compact('post'));
    }

    public function loadMore(Request $request)
    {
        $offset = $request->query('offset', 18);
        $posts = Post::with('images')
            ->skip($offset)
            ->take(18)
            ->get();

        $totalPosts = Post::count();
        $hasMore = $offset + $posts->count() < $totalPosts;

        \Log::info("loadMore: offset=$offset, posts_count=" . $posts->count());

        $html = view('pages.listings.posts', ['posts' => $posts])->render();

        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore,
            'posts_count' => $posts->count(),
            'total_posts' => $totalPosts
        ]);
    }
}
