<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $images[] = $path;
            }
            $data['images'] = json_encode($images);
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('images')) {
            // Delete old images
            if ($post->images) {
                $oldImages = json_decode($post->images, true);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            // Store new images
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $images[] = $path;
            }
            $data['images'] = json_encode($images);
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete images
        if ($post->images) {
            $images = json_decode($post->images, true);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được xóa thành công.');
    }
} 