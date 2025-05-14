<?php

namespace App\Listeners;

use App\Events\LikeEvent;
use App\Models\User;
use App\Models\Post;
use App\Notifications\Notifications;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateLikeNotification implements ShouldQueue
{
    /**
     * Xử lý sự kiện.
     */
    public function handle(LikeEvent $event): void
    {
        // Lấy dữ liệu từ broadcastWith
        $data = $event->broadcastWith();
        
        // Tìm bài viết
        $post = Post::find($data['post_id']);
        
        if ($post) {
            // Lấy chủ bài viết (người nhận thông báo)
            $postOwner = User::find($post->user_id);
            
            // Không gửi thông báo nếu người like chính là chủ bài viết
            if ($postOwner && $postOwner->id !== $data['liker_id']) {
                $postOwner->notify(new Notifications([
                    'message' => $data['message'],
                    'link' => $data['link'],
                    'type' => 'like'
                ]));
            }
        }
    }
} 