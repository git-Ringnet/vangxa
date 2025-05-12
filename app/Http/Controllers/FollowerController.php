<?php

namespace App\Http\Controllers;

use App\Events\FollowEventReverb;
use App\Events\TestReverbEvent;
use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    /**
     * Theo dõi một người dùng
     */
    public function follow($id)
    {
        $userToFollow = User::findOrFail($id);
        $currentUser = Auth::user();
        // Ngăn người dùng tự theo dõi chính mình
        if ($currentUser->id === $userToFollow->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không thể tự theo dõi chính mình'
            ]);
        }

        // Nếu đã theo dõi rồi, không làm gì cả
        if ($currentUser->following()->where('following_id', $userToFollow->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã theo dõi người dùng này rồi'
            ]);
        }

        // Thêm vào danh sách theo dõi
        $currentUser->following()->attach($userToFollow->id);

        // Trả về số lượng người theo dõi cập nhật
        $followersCount = $userToFollow->followers()->count();

        return response()->json([
            'success' => true,
            'message' => 'Đã theo dõi thành công',
            'isFollowing' => true,
            'followersCount' => $followersCount
        ]);
    }

    /**
     * Hủy theo dõi một người dùng
     */
    public function unfollow($id)
    {
        $userToUnfollow = User::findOrFail($id);
        $currentUser = Auth::user();

        // Kiểm tra xem có đang theo dõi không
        if (!$currentUser->following()->where('following_id', $userToUnfollow->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chưa theo dõi người dùng này'
            ]);
        }

        // Xóa khỏi danh sách theo dõi
        $currentUser->following()->detach($userToUnfollow->id);

        // Trả về số lượng người theo dõi cập nhật
        $followersCount = $userToUnfollow->followers()->count();

        return response()->json([
            'success' => true,
            'message' => 'Đã hủy theo dõi thành công',
            'isFollowing' => false,
            'followersCount' => $followersCount
        ]);
    }

    /**
     * Toggle theo dõi/hủy theo dõi
     */
    public function toggle($id)
    {
        $targetUser = User::findOrFail($id);
        $currentUser = Auth::user();

        // Ngăn người dùng tự theo dõi chính mình
        if ($currentUser->id === $targetUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không thể tự theo dõi chính mình'
            ]);
        }

        // Kiểm tra xem đã theo dõi chưa
        $isFollowing = $currentUser->following()->where('following_id', $targetUser->id)->exists();

        // Lưu trữ thông tin follower trước khi thay đổi trạng thái
        $followerRecord = null;
        $followerData = null;

        if ($isFollowing) {
            // Lấy thông tin follower trước khi xóa
            $followerRecord = Follower::where('follower_id', $currentUser->id)
                ->where('following_id', $targetUser->id)
                ->first();
                
            // Lưu dữ liệu cần thiết cho unfollow trước khi detach
            if ($followerRecord) {
                $followerData = (object)[
                    'id' => $followerRecord->id,
                    'follower_id' => $currentUser->id,
                    'following_id' => $targetUser->id,
                    'follower' => $currentUser,
                    'following' => $targetUser,
                    'created_at' => $followerRecord->created_at,
                    'updated_at' => now(),
                ];
            }

            // Hủy theo dõi
            $currentUser->following()->detach($targetUser->id);
            $message = 'Đã hủy theo dõi thành công';
            $newFollowState = false;
        } else {
            // Theo dõi
            $currentUser->following()->attach($targetUser->id);
            $message = 'Đã theo dõi thành công';
            $newFollowState = true;

            // Lấy thông tin follower sau khi tạo
            $followerRecord = Follower::where('follower_id', $currentUser->id)
                ->where('following_id', $targetUser->id)
                ->first();
        }

        // Trả về số lượng người theo dõi cập nhật
        $followersCount = $targetUser->followers()->count();


        // Dispatch event với thông tin follower và trạng thái mới
        if ($newFollowState) {
            // Khi follow: followerRecord đã được lấy sau khi attach
            if ($followerRecord) {
                \Illuminate\Support\Facades\Log::info('Dispatching follow event', [
                    'status' => $newFollowState,
                    'follower_id' => $currentUser->id,
                    'following_id' => $targetUser->id
                ]);
                FollowEventReverb::dispatch($followerRecord, $newFollowState);
            }
        } else {
            // Khi unfollow: sử dụng followerRecord đã lưu trước khi detach
            if ($followerData) {
                \Illuminate\Support\Facades\Log::info('Dispatching unfollow event', [
                    'status' => $newFollowState,
                    'follower_id' => $currentUser->id,
                    'following_id' => $targetUser->id
                ]);
                
                // Sử dụng class mới cho unfollow event
                event(new \App\Events\UnfollowEvent($followerData, $newFollowState));
            }
        }


        return response()->json([
            'success' => true,
            'message' => $message,
            'isFollowing' => $newFollowState,
            'followersCount' => $followersCount
        ]);
    }

    /**
     * Hiển thị danh sách người theo dõi
     */
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->paginate(20);

        return view('users.followers', compact('user', 'followers'));
    }

    /**
     * Hiển thị danh sách đang theo dõi
     */
    public function following($id)
    {
        $user = User::findOrFail($id);
        $following = $user->following()->paginate(20);

        return view('users.following', compact('user', 'following'));
    }
}
