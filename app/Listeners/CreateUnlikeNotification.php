<?php

namespace App\Listeners;

use App\Events\UnlikeEvent;
use App\Models\Post;
use App\Models\User;
use App\Notifications\Notifications;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUnlikeNotification implements ShouldQueue
{
    /**
     * Xử lý sự kiện.
     */
    public function handle(UnlikeEvent $event): void
    {
        // Lấy dữ liệu từ broadcastWith
        $data = $event->broadcastWith();
        
        // Tìm bài viết
        $post = Post::find($data['post_id']);
        
        if ($post) {
            // Lấy chủ bài viết (người nhận thông báo)
            $postOwner = User::find($post->user_id);
            
            // Không gửi thông báo nếu người bỏ thích chính là chủ bài viết
            if ($postOwner && $postOwner->id !== $data['unliker_id']) {
                $postOwner->notify(new Notifications([
                    'message' => $data['message'],
                    'link' => $data['link'],
                    'type' => 'unlike'
                ]));
            }
        }
    }
} 