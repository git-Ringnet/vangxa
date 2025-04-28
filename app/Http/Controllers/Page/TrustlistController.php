<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Trustlist;
use App\Models\UserInteraction;
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
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thêm vào danh sách tin cậy',
                'saved' => false
            ], 401);
        }

        $post = Post::findOrFail($id);
        $trustlist = Trustlist::where('user_id', Auth::id())
            ->where('post_id', $id)
            ->first();

        if ($trustlist) {
            $trustlist->delete();
            $message = 'Đã xóa khỏi danh sách tin cậy';
            $saved = false;
        } else {
            Trustlist::create([
                'user_id' => Auth::id(),
                'post_id' => $id
            ]);

            // Ghi nhận tương tác thêm vào trustlist
            UserInteraction::create([
                'user_id' => Auth::id(),
                'interaction_type' => 'trustlist',
                'points' => 1,
                'post_id' => $id
            ]);

            // Kiểm tra thăng hạng sau khi thêm vào trustlist
            $tierUpgrade = UserInteraction::checkTierUpgrade(Auth::id());

            $message = 'Đã thêm vào danh sách tin cậy';
            $saved = true;
        }

        $savesCount = Trustlist::where('post_id', $post->id)->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'saved' => $saved,
            'savesCount' => $savesCount,
            'tier_upgrade' => $tierUpgrade ?? null
        ]);
    }
}
