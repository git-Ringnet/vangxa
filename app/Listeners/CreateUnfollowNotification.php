<?php

namespace App\Listeners;

use App\Events\UnfollowEvent;
use App\Models\User;
use App\Notifications\Notifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CreateUnfollowNotification implements ShouldQueue
{
    /**
     * Xử lý sự kiện hủy theo dõi.
     */
    public function handle(UnfollowEvent $event): void
    {
        // Lấy dữ liệu từ broadcastWith
        $data = $event->broadcastWith();
        
        Log::info('Handling unfollow notification', $data);
        
        // Lấy người được unfollow
        $unfollowedUser = User::find($data['following_id']);
        
        // Chỉ gửi thông báo cho người được unfollow
        if ($unfollowedUser) {
            $unfollowedUser->notify(new Notifications([
                'message' => "{$data['follower_name']} đã hủy theo dõi bạn",
                'link' => "/profile/{$data['follower_id']}", // Link đến profile người hủy theo dõi
                'type' => 'follow'
            ]));
            
            Log::info('Unfollow notification sent', [
                'user_id' => $unfollowedUser->id,
                'message' => "{$data['follower_name']} đã hủy theo dõi bạn"
            ]);
        }
    }
} 