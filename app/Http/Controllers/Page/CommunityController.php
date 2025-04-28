<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\UserInteraction;

class CommunityController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('pages.community.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'group_id' => 'required|exists:groups,id',
        ], [
            'description.required' => 'Vui lòng nhập nội dung bài viết',
            'images.*.image' => 'File phải là ảnh',
            'images.*.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif',
            'images.*.max' => 'Ảnh không được lớn hơn 2MB',
            'group_id.required' => 'Vui lòng chọn nhóm',
        ]);

        try {
            $post = new Post();
            $post->description = $request->description;
            $post->user_id = Auth::id() ?? 1;
            $post->type = 3; // Type 3 for community
            $post->status = 1; // Active
            $post->group_id = $request->group_id;
            $post->save();

            // Xử lý upload ảnh
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Tạo tên file duy nhất
                    $filename = time() . '_' . $image->getClientOriginalName();

                    // Lưu ảnh vào thư mục public/image/posts
                    $image->move(public_path('community/posts'), $filename);

                    // Lưu đường dẫn vào database
                    $post->images()->create([
                        'image_path' => 'community/posts/' . $filename
                    ]);
                }
            }

            // Nếu bài viết có group_id, thì tăng post_count
            if ($post->group_id) {
                $post->group->increment('post_count');
            }

              // Ghi nhận tương tác khi đăng bài
            if (Auth::check()) {
                UserInteraction::create([
                    'user_id' => Auth::id(),
                    'interaction_type' => 'post',
                    'points' => 1,
                    'post_id' => $post->id
                ]);

                // Kiểm tra thăng hạng sau khi đăng bài
                $tierUpgrade = UserInteraction::checkTierUpgrade(Auth::id());
            }
            if ($request->page == 'nhom') {
                return redirect()
                    ->route('groupss.show', $post->group_id)
                    ->with('success', 'Bài viết đã được đăng thành công!');
            } else {
                return redirect()
                    ->route('groupss.index')
                    ->with('success', 'Bài viết đã được đăng thành công!');
            }
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
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'description.required' => 'Vui lòng nhập nội dung bài viết',
            'images.*.image' => 'File phải là ảnh',
            'images.*.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif',
            'images.*.max' => 'Ảnh không được lớn hơn 2MB',
        ]);

        try {
            $post->description = $request->description;
            $post->save();

            // Xử lý upload ảnh mới
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Tạo tên file duy nhất
                    $filename = time() . '_' . $image->getClientOriginalName();

                    // Lưu ảnh vào thư mục public/image/posts
                    $image->move(public_path('community/posts'), $filename);

                    // Lưu đường dẫn vào database
                    $post->images()->create([
                        'image_path' => 'community/posts/' . $filename
                    ]);
                }
            }

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
            // Delete associated images from storage and database
            foreach ($post->images as $image) {
                // Xóa file ảnh từ thư mục public
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                // Delete the image record from database
                $image->delete();
            }

            // Delete all post_images records
            $post->images()->delete();

            // Nếu bài viết có group_id, thì giảm post_count
            if ($post->group_id) {
                $post->group->decrement('post_count');
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
