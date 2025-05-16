<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Trustlist;
use App\Models\UserInteraction;
use App\Events\TrustlistEvent;
use App\Events\UntrustEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrustlistController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');
        $query = Post::whereHas('trustlist', function ($q) {
            $q->where('user_id', Auth::id());
        });

        if ($type) {
            $query->where('type', $type);
        }

        $posts = $query->with(['images', 'trustlist'])->get();

        foreach ($posts as $post) {
            $post->saves_count = $post->trustlist()->count();
            $post->isSaved = true;
        }

        return view('pages.trustlist.index', compact('posts', 'type'));
    }

    public function toggle(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để thêm vào danh sách tin cậy',
                    'saved' => false
                ], 401);
            }

            $post = Post::with('user')->findOrFail($id);
            $user = Auth::user();
            $isSaved = false;

            $trustlist = Trustlist::where('user_id', $user->id)
                ->where('post_id', $post->id)
                ->first();

            if ($trustlist) {
                // Xóa khỏi danh sách tin cậy
                $trustlist->delete();
                $message = 'Đã xóa khỏi danh sách tin cậy';
                
                // Phát sự kiện UntrustEvent
                event(new UntrustEvent($post, $user));
            } else {
                // Thêm vào danh sách tin cậy
                Trustlist::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id
                ]);
                $isSaved = true;
                $message = 'Đã thêm vào danh sách tin cậy';
                
                // Phát sự kiện TrustlistEvent
                event(new TrustlistEvent($post, $user));
            }

            // Lấy số lượng lưu hiện tại
            $savesCount = Trustlist::where('post_id', $post->id)->count();

            // Tạo hoặc cập nhật tương tác người dùng đơn giản
            UserInteraction::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'interaction_type' => 'trustlist'
                ],
                [
                    'user_id' => $user->id,
                    'interaction_type' => 'trustlist',
                    'points' => 1
                ]
            );

            return response()->json([
                'success' => true,
                'message' => $message,
                'saved' => $isSaved,
                'saves_count' => $savesCount
            ]);
        } catch (\Exception $e) {
            Log::error('Trustlist error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau.',
                'saved' => false
            ], 500);
        }
    }
}
