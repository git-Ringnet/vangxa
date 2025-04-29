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

        // Convert link TikTok thành iframe
        $description = $this->convertTikTokLinksToIframe($request->description);

        $post = Post::create([
            'title' => $request->title,
            'address' => $request->address,
            'description' => $description,
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

    private function convertTikTokLinksToIframe($content)
    {
        $pattern = '/https?:\/\/(www\.)?tiktok\.com\/@[^\/]+\/video\/(\d+)/i';

        return preg_replace_callback($pattern, function ($matches) {
            $videoId = $matches[2];

            return '<iframe src="https://www.tiktok.com/embed/' . $videoId . '" width="325" height="600" frameborder="0" allowfullscreen></iframe>';
        }, $content);
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

        foreach ($post->images as $image) {
            // Xóa bản ghi ảnh
            $image->delete();
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

        // Xử lý nhúng TikTok trong mô tả mới
        $processedDescription = $this->convertTikTokLinksToIframe($request->description);

        // Cập nhật thông tin cơ bản
        $post->update([
            'title' => $request->title,
            'address' => $request->address,
            'description' => $processedDescription,
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
            preg_match_all('/<img[^>]+src="([^">]+)"/', $processedDescription, $newMatches);
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

            $posts = Post::with(['user', 'group', 'likes', 'comments'])
                ->where('type', '3')
                ->orderBy('created_at', 'desc')
                ->skip($offset)
                ->take($perPage)
                ->get();

            $total = Post::count();
            $hasMore = ($offset + $posts->count()) < $total;

            return response()->json([
                'posts' => $posts->map(function ($post) {
                    $isLiked = $post->likes->contains(auth()->id());
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
                        ] : null,
                        'likes' => [
                            'count' => $post->likes->count(),
                            'is_liked' => $isLiked
                        ],
                        'comments' => [
                            'count' => $post->comments->count(),
                        ]
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

    /**
     * Cập nhật chủ sở hữu/vendor cho bài đăng
     */
    public function updateOwner(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Kiểm tra quyền: chỉ admin hoặc người tạo bài đăng mới có quyền cập nhật
        if (!Auth::user()->hasRole('Admin') && Auth::id() != $post->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này'
            ], 403);
        }

        // Xử lý danh sách chủ sở hữu mới
        if ($request->filled('owners_list')) {
            try {
                $ownersList = json_decode($request->owners_list, true);

                // Xóa tất cả quan hệ cũ
                $post->owners()->detach();

                // Thêm các chủ sở hữu mới
                foreach ($ownersList as $owner) {
                    $post->owners()->attach($owner['id'], ['role' => $owner['role']]);
                }

                // Cập nhật owner_id chính (hệ thống cũ)
                if (!empty($ownersList)) {
                    // Ưu tiên chủ sở hữu chính, nếu không có thì lấy người đầu tiên
                    $primaryOwner = collect($ownersList)->firstWhere('role', 'Chủ sở hữu chính');
                    if (!$primaryOwner) {
                        $primaryOwner = $ownersList[0];
                    }

                    $post->update(['owner_id' => $primaryOwner['id']]);
                    $message = 'Đã cập nhật danh sách chủ sở hữu thành công';
                } else {
                    $post->update(['owner_id' => null]);
                    $message = 'Đã xóa tất cả chủ sở hữu';
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi xử lý dữ liệu: ' . $e->getMessage()
                ], 400);
            }
        }
        // Xử lý theo cách cũ nếu không có danh sách
        else if ($request->filled('owner_id')) {
            // Cập nhật trường owner_id (phương pháp cũ)
            $post->update(['owner_id' => $request->owner_id]);

            // Xóa tất cả owner cũ và thêm owner mới với vai trò chủ sở hữu chính
            $post->owners()->detach();
            $post->owners()->attach($request->owner_id, ['role' => 'Chủ sở hữu chính']);

            $message = 'Đã cập nhật chủ sở hữu thành công';
        } else {
            // Xóa owner_id (phương pháp cũ)
            $post->update(['owner_id' => null]);

            // Xóa tất cả owner trong bảng trung gian
            $post->owners()->detach();

            $message = 'Đã xóa thông tin chủ sở hữu';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'owner' => $post->owner ? [
                    'id' => $post->owner->id,
                    'name' => $post->owner->name,
                    'avatar' => $post->owner->avatar
                ] : null,
                'owners' => $post->owners->map(function ($owner) {
                    return [
                        'id' => $owner->id,
                        'name' => $owner->name,
                        'avatar' => $owner->avatar,
                        'role' => $owner->pivot->role
                    ];
                })
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Thêm chủ sở hữu mới cho bài đăng
     */
    public function addOwner(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Kiểm tra quyền: chỉ admin hoặc người tạo bài đăng mới có quyền cập nhật
        if (!Auth::user()->hasRole('Admin') && Auth::id() != $post->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này'
            ], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:100'
        ]);

        // Kiểm tra xem user đã là owner chưa
        $existingOwner = $post->owners()->where('user_id', $request->user_id)->first();

        if ($existingOwner) {
            // Cập nhật vai trò nếu đã tồn tại
            $post->owners()->updateExistingPivot($request->user_id, ['role' => $request->role]);
            $message = 'Đã cập nhật vai trò của chủ sở hữu';
        } else {
            // Thêm owner mới
            $post->owners()->attach($request->user_id, ['role' => $request->role]);
            $message = 'Đã thêm chủ sở hữu mới thành công';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'owners' => $post->owners()->with('roles')->get()->map(function ($owner) {
                    return [
                        'id' => $owner->id,
                        'name' => $owner->name,
                        'avatar' => $owner->avatar,
                        'role' => $owner->pivot->role
                    ];
                })
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Xóa chủ sở hữu khỏi bài đăng
     */
    public function removeOwner(Request $request, $postId, $userId)
    {
        $post = Post::findOrFail($postId);

        // Kiểm tra quyền: chỉ admin hoặc người tạo bài đăng mới có quyền cập nhật
        if (!Auth::user()->hasRole('Admin') && Auth::id() != $post->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này'
            ], 403);
        }

        // Xóa owner khỏi bài đăng
        $post->owners()->detach($userId);

        // Nếu đây là owner chính (trong trường owner_id), cũng xóa nó
        if ($post->owner_id == $userId) {
            $post->update(['owner_id' => null]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa chủ sở hữu khỏi bài đăng',
                'owners' => $post->owners()->with('roles')->get()->map(function ($owner) {
                    return [
                        'id' => $owner->id,
                        'name' => $owner->name,
                        'avatar' => $owner->avatar,
                        'role' => $owner->pivot->role
                    ];
                })
            ]);
        }

        return redirect()->back()->with('success', 'Đã xóa chủ sở hữu khỏi bài đăng');
    }
}
