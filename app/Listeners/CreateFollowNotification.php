<?php

namespace App\Listeners;

use App\Events\FollowEventReverb;
use App\Models\User;
use App\Notifications\Notifications;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateFollowNotification implements ShouldQueue
{
    /**
     * Xử lý sự kiện.
     */
    public function handle(FollowEventReverb $event): void
    {
        // Lấy dữ liệu từ broadcastWith
        $data = $event->broadcastWith();
        
        // Lấy người được follow/unfollow
        $followedUser = User::find($data['following_id']);
        
        // Chỉ gửi thông báo cho người được follow/unfollow
        if ($followedUser) {
            // Tạo message dựa trên status
            $message = $data['status'] 
                ? "{$data['follower_name']} đã bắt đầu theo dõi bạn" 
                : "{$data['follower_name']} đã hủy theo dõi bạn";
                
            $followedUser->notify(new Notifications([
                'message' => $message,
                'link' => "/profile/{$data['follower_id']}", // Link đến profile người thực hiện hành động
                'type' => 'follow'
            ]));
        }
    }
} 