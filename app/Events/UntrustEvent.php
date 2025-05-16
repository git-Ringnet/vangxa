<?php

namespace App\Events;

use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UntrustEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Post $post Bài viết bị xóa khỏi trustlist
     * @param User $user Người xóa khỏi trustlist
     */
    public function __construct(
        private readonly Post $post,
        private readonly User $user
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
            new Channel('untrust'),
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
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'created_at' => now(),
            'message' => "{$this->user->name} đã xóa bài viết của bạn khỏi danh sách tin cậy",
            'link' => "/posts/{$this->post->id}", // Link đến bài viết
            'type' => 'untrust'
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'untrust.created';
    }
} 