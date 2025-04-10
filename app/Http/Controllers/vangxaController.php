<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class vangxaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy thống kê cho dashboard
        $totalPosts = Post::count() ?? 0;
        $totalImages = PostImage::count() ?? 0;
        $recentPosts = Post::where('created_at', '>=', now()->subDays(7))->count() ?? 0;

        // Lấy danh sách bài viết gần đây
        $latestPosts = Post::with('images')->latest()->take(5)->get();

        return view('admin.index', compact(
            'totalPosts',
            'totalImages',
            'recentPosts',
            'latestPosts'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
