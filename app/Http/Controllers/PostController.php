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
    public function index(Request $request)
    {
        $query = Post::with('user')->latest();

        // Lọc theo type nếu có
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $posts = $query->paginate(10);

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
            'user_id' => Auth::id() ?? 1,
            'status' => '1',
            'type' => $request->type,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Tạo tên file duy nhất
                $filename = time() . '_' . $image->getClientOriginalName();

                // Lưu ảnh vào thư mục public/image/posts
                $image->move(public_path('image/posts'), $filename);

                // Lưu đường dẫn vào database
                $post->images()->create([
                    'image_path' => 'image/posts/' . $filename
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
            // Xóa file ảnh từ thư mục public
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
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
                        $path = preg_replace('/^.*image\//', 'image/', $path);

                        // Xóa cả ảnh trong thư mục posts và uploads
                        if (strpos($path, 'image/posts/') === 0 || strpos($path, 'image/uploads/') === 0) {
                            $fullPath = public_path($path);
                            if (file_exists($fullPath)) {
                                unlink($fullPath);
                            }
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

            // Lưu file vào thư mục public/image/uploads
            $file->move(public_path('image/uploads'), $filename);

            // Trả về URL đầy đủ của ảnh
            return response()->json([
                'location' => asset('image/uploads/' . $filename)
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
                    $path = preg_replace('/^.*image\//', 'image/', $path);

                    // Tạo đường dẫn mới với định dạng chuẩn
                    $newPath = asset($path);

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
            'description' => $request->description,
            'status' => 1,
            'type' => $request->type,
        ]);

        // Xử lý ảnh đính kèm
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();

                // Lưu ảnh vào thư mục public/image/posts
                $image->move(public_path('image/posts'), $filename);

                // Lưu đường dẫn vào database
                $post->images()->create([
                    'image_path' => 'image/posts/' . $filename
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
                    $path = preg_replace('/^.*image\//', 'image/', $path);
                    $normalizedOldImages[] = $path;
                }
            }

            $normalizedNewImages = [];
            foreach ($newImages as $newImage) {
                $path = parse_url($newImage, PHP_URL_PATH);
                if ($path) {
                    // Loại bỏ tất cả các tiền tố có thể có
                    $path = preg_replace('/^.*image\//', 'image/', $path);
                    $normalizedNewImages[] = $path;
                }
            }

            // Xóa những ảnh cũ không còn được sử dụng
            foreach ($normalizedOldImages as $index => $normalizedOldImage) {
                if (!in_array($normalizedOldImage, $normalizedNewImages)) {
                    // Chỉ xóa nếu file nằm trong thư mục uploads
                    if (strpos($normalizedOldImage, 'image/uploads/') === 0) {
                        // Log để debug
                        Log::info('Deleting unused image: ' . $normalizedOldImage);
                        $fullPath = public_path($normalizedOldImage);
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }
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

        // Xóa file ảnh từ thư mục public
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        // Xóa bản ghi ảnh
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function getPosts(Request $request)
    {
        try {
            $perPage = 5;
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;

            $posts = Post::with(['user', 'group'])
                ->where('type', '3')
                ->orderBy('created_at', 'desc')
                ->skip($offset)
                ->take($perPage)
                ->get();

            $total = Post::count();
            $hasMore = ($offset + $posts->count()) < $total;

            return response()->json([
                'posts' => $posts->map(function ($post) {
                    return [
                        'id' => $post->id,
                        'description' => $post->description,
                        'created_at' => $post->created_at->diffForHumans(),
                        'user' => $post->user ? [
                            'id' => $post->user->id,
                            'name' => $post->user->name,
                        ] : null,
                        'group' => $post->group ? [
                            'id' => $post->group->id,
                            'name' => $post->group->name
                        ] : null
                    ];
                }),
                'hasMore' => $hasMore,
                'nextPage' => $hasMore ? $page + 1 : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
