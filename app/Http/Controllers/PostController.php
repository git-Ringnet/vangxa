<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')->latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'address' => $request->address,
            'description' => $request->description,
            'user_id' => 1
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Lưu ảnh vào thư mục posts
                $filename = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('posts', $filename, 'public');
                $post->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('posts.index')
            ->with('success', 'Bài đăng đã được tạo thành công!');
    }

    public function destroy(Post $post)
    {
        // Xóa tất cả ảnh liên quan
        foreach ($post->images as $image) {
            // Xóa file ảnh từ storage
            Storage::disk('public')->delete($image->image_path);
        }

        // Xóa các ảnh trong nội dung mô tả
        if ($post->description) {
            // Tìm tất cả các thẻ img trong nội dung
            preg_match_all('/<img[^>]+src="([^">]+)"/', $post->description, $matches);
            
            if (!empty($matches[1])) {
                foreach ($matches[1] as $imageUrl) {
                    // Lấy đường dẫn tương đối từ URL
                    $path = parse_url($imageUrl, PHP_URL_PATH);
                    
                    if ($path) {
                        // Loại bỏ tất cả các tiền tố có thể có
                        $path = preg_replace('/^.*storage\//', '', $path);
                        $path = preg_replace('/^.*uploads\//', 'uploads/', $path);
                        
                        // Chỉ xóa nếu file nằm trong thư mục uploads
                        if (strpos($path, 'uploads/') === 0) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                }
            }
        }

        // Xóa bài đăng (cascade sẽ tự động xóa các bản ghi ảnh liên quan)
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Bài đăng đã được xóa thành công!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Lưu file vào storage/app/public/uploads
            $path = $file->storeAs('uploads', $filename, 'public');

            // Trả về URL đầy đủ của ảnh
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Chuẩn bị nội dung mô tả với đường dẫn ảnh đúng định dạng
        $description = $post->description;
        
        // Tìm tất cả các thẻ img trong nội dung
        preg_match_all('/<img[^>]+src="([^">]+)"/', $description, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                // Lấy đường dẫn tương đối từ URL
                $path = parse_url($imageUrl, PHP_URL_PATH);
                
                if ($path) {
                    // Loại bỏ tất cả các tiền tố có thể có
                    $path = preg_replace('/^.*storage\//', '', $path);
                    $path = preg_replace('/^.*uploads\//', 'uploads/', $path);
                    
                    // Tạo đường dẫn mới với định dạng chuẩn
                    $newPath = asset('storage/' . $path);
                    
                    // Thay thế đường dẫn cũ bằng đường dẫn mới
                    $description = str_replace($imageUrl, $newPath, $description);
                }
            }
        }
        
        // Cập nhật nội dung mô tả với đường dẫn ảnh đã chuẩn hóa
        $post->description = $description;
        
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Lưu nội dung mô tả cũ để so sánh
        $oldDescription = $post->description;

        // Cập nhật thông tin cơ bản
        $post->update([
            'title' => $request->title,
            'address' => $request->address,
            'description' => $request->description
        ]);

        // Xử lý ảnh đính kèm
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('posts', $filename, 'public');
                $post->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        // Xử lý ảnh trong nội dung mô tả
        if ($oldDescription !== $request->description) {
            // Tìm tất cả ảnh cũ trong nội dung
            preg_match_all('/<img[^>]+src="([^">]+)"/', $oldDescription, $oldMatches);
            $oldImages = $oldMatches[1] ?? [];

            // Tìm tất cả ảnh mới trong nội dung
            preg_match_all('/<img[^>]+src="([^">]+)"/', $request->description, $newMatches);
            $newImages = $newMatches[1] ?? [];

            // Chuẩn hóa đường dẫn ảnh để so sánh
            $normalizedOldImages = [];
            foreach ($oldImages as $oldImage) {
                $path = parse_url($oldImage, PHP_URL_PATH);
                if ($path) {
                    // Loại bỏ tất cả các tiền tố có thể có
                    $path = preg_replace('/^.*storage\//', '', $path);
                    $path = preg_replace('/^.*uploads\//', 'uploads/', $path);
                    $normalizedOldImages[] = $path;
                }
            }

            $normalizedNewImages = [];
            foreach ($newImages as $newImage) {
                $path = parse_url($newImage, PHP_URL_PATH);
                if ($path) {
                    // Loại bỏ tất cả các tiền tố có thể có
                    $path = preg_replace('/^.*storage\//', '', $path);
                    $path = preg_replace('/^.*uploads\//', 'uploads/', $path);
                    $normalizedNewImages[] = $path;
                }
            }

            // Xóa những ảnh cũ không còn được sử dụng
            foreach ($normalizedOldImages as $index => $normalizedOldImage) {
                if (!in_array($normalizedOldImage, $normalizedNewImages)) {
                    // Chỉ xóa nếu file nằm trong thư mục uploads
                    if (strpos($normalizedOldImage, 'uploads/') === 0) {
                        // Log để debug
                        Log::info('Deleting unused image: ' . $normalizedOldImage);
                        Storage::disk('public')->delete($normalizedOldImage);
                    }
                }
            }
        }

        return redirect()->route('posts.index')
            ->with('success', 'Bài đăng đã được cập nhật thành công!');
    }

    public function destroyImage($id)
    {
        $image = PostImage::findOrFail($id);

        // Xóa file ảnh từ storage
        Storage::disk('public')->delete($image->image_path);

        // Xóa bản ghi ảnh
        $image->delete();

        return response()->json(['success' => true]);
    }
}
