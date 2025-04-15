<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'images')
            ->where('type', 3) // Type 3 for community
            ->latest()
            ->paginate(12);

        return view('pages.community.index', compact('posts'));
    }

    public function create()
    {
        return view('pages.community.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'description.required' => 'Vui lòng nhập nội dung bài viết',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
        ]);

        try {
            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = Auth::id() ?? 1;
            $post->type = 3; // Type 3 for community
            $post->status = 1; // Active
            $post->save();

            return redirect()->route('community.index')->with('success', 'Bài viết đã được đăng thành công!');
        } catch (\Exception $e) {
            Log::error('Error creating community post', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi đăng bài. Vui lòng thử lại sau.');
        }
    }

    public function show(String $id)
    {
        $post = Post::with('user', 'images', 'reviews.user')
            ->where('type', 3)
            ->findOrFail($id);

        $comments = $post
            ->comments()
            ->with(['children.user', 'user'])
            ->defaultOrder()
            ->get()
            ->toTree();

        return view('pages.community.show', compact('post', 'comments'));
    }

    public function edit($id)
    {
        $post = Post::with('images')
            ->where('type', 3)
            ->where('user_id', Auth::id() ?? 1)
            ->findOrFail($id);

        return view('pages.community.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('type', 3)
            ->where('user_id', Auth::id() ?? 1)
            ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'description.required' => 'Vui lòng nhập nội dung bài viết',
        ]);

        try {
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();

            return redirect()->route('community.index')
                ->with('success', 'Bài viết đã được cập nhật thành công!');
        } catch (\Exception $e) {
            Log::error('Error updating community post', [
                'error' => $e->getMessage(),
                'post_id' => $id,
                'user_id' => Auth::id() ?? 1
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật bài viết. Vui lòng thử lại sau.');
        }
    }

    public function destroy($id)
    {
        $post = Post::where('type', 3)
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        try {
            // Delete associated images from storage
            foreach ($post->images as $image) {
                $path = str_replace('storage/', '', $image->image_path);
                if (file_exists(storage_path('app/public/' . $path))) {
                    unlink(storage_path('app/public/' . $path));
                }
            }

            $post->delete();

            return redirect()->route('community.index')
                ->with('success', 'Bài viết đã được xóa thành công!');
        } catch (\Exception $e) {
            Log::error('Error deleting community post', [
                'error' => $e->getMessage(),
                'post_id' => $id,
                'user_id' => Auth::id()
            ]);

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa bài viết. Vui lòng thử lại sau.');
        }
    }
}
