<?php

namespace App\Events;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Post $post Bài viết được like
     * @param User $liker Người like
     */
    public function __construct(
        private readonly Post $post,
        private readonly User $liker
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcasting to both public channel and private channel
        return [
            // Public channel để debug và theo dõi
            new Channel('likes'),
            // Private channel cho user nhận thông báo (chủ bài viết)
            new PrivateChannel('user.' . $this->post->user_id)
        ];
    }
    
    /**
     * The data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title ?? 'Bài viết',
            'liker_id' => $this->liker->id,
            'liker_name' => $this->liker->name,
            'created_at' => now(),
            'message' => "{$this->liker->name} đã thích bài viết của bạn",
            'link' => "/posts/{$this->post->id}", // Link đến bài viết
            'type' => 'like'
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'like.created';
    }
} 