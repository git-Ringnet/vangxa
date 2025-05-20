<?php

namespace App\Http\Controllers;

use App\Models\VendorStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorStoryController extends Controller
{
    /**
     * Display a listing of the vendor's stories.
     */
    public function index()
    {
        $stories = Auth::user()->stories()->orderBy('created_at', 'desc')->get();
        return view('vendor.stories.index', compact('stories'));
    }

    /**
     * Show the form for creating a new story.
     */
    public function create()
    {
        return view('vendor.stories.create');
    }

    /**
     * Store a newly created story in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'content.required' => 'Vui lòng nhập nội dung câu chuyện',
            'image.image' => 'File phải là ảnh',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif',
            'image.max' => 'Ảnh không được lớn hơn 5MB',
        ]);

        $story = new VendorStory([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('vendor-stories', 'public');
            $story->image_path = $path;
        }

        $story->save();

        return redirect()->route('vendor.stories.index')
            ->with('success', 'Câu chuyện đã được tạo thành công!');
    }

    /**
     * Display the specified story.
     */
    public function show(VendorStory $story)
    {
        // Kiểm tra xem câu chuyện có thuộc về vendor hiện tại không
        if ($story->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem câu chuyện này.');
        }

        return view('vendor.stories.show', compact('story'));
    }

    /**
     * Show the form for editing the specified story.
     */
    public function edit(VendorStory $story)
    {
        // Kiểm tra xem câu chuyện có thuộc về vendor hiện tại không
        if ($story->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa câu chuyện này.');
        }

        return view('vendor.stories.edit', compact('story'));
    }

    /**
     * Update the specified story in storage.
     */
    public function update(Request $request, VendorStory $story)
    {
        // Kiểm tra xem câu chuyện có thuộc về vendor hiện tại không
        if ($story->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa câu chuyện này.');
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'remove_image' => 'nullable|in:0,1',
        ], [
            'content.required' => 'Vui lòng nhập nội dung câu chuyện',
            'image.image' => 'File phải là ảnh',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif',
            'image.max' => 'Ảnh không được lớn hơn 5MB',
        ]);

        $story->title = $request->title;
        $story->content = $request->content;

        // Xử lý xóa ảnh hiện tại nếu có yêu cầu
        if ($request->input('remove_image') == '1' && $story->image_path) {
            Storage::disk('public')->delete($story->image_path);
            $story->image_path = null;
        }

        // Xử lý upload ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($story->image_path) {
                Storage::disk('public')->delete($story->image_path);
            }

            // Lưu ảnh mới
            $image = $request->file('image');
            $path = $image->store('vendor-stories', 'public');
            $story->image_path = $path;
        }

        $story->save();

        return redirect()->route('vendor.stories.index')
            ->with('success', 'Câu chuyện đã được cập nhật thành công!');
    }

    /**
     * Remove the specified story from storage.
     */
    public function destroy(VendorStory $story)
    {
        // Kiểm tra xem câu chuyện có thuộc về vendor hiện tại không
        if ($story->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xóa câu chuyện này.');
        }

        // Xóa ảnh nếu có
        if ($story->image_path) {
            Storage::disk('public')->delete($story->image_path);
        }

        $story->delete();

        return redirect()->route('vendor.stories.index')
            ->with('success', 'Câu chuyện đã được xóa thành công!');
    }
    
    /**
     * Show stories for a specific vendor on their profile
     */
    public function vendorStories($vendorId)
    {
        $vendor = \App\Models\User::findOrFail($vendorId);
        $stories = $vendor->stories()->orderBy('created_at', 'desc')->get();
        
        return view('vendor.stories.vendor-stories', compact('vendor', 'stories'));
    }
} 