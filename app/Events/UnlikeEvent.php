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

class UnlikeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Post $post Bài viết được bỏ thích
     * @param User $unliker Người bỏ thích
     */
    public function __construct(
        private readonly Post $post,
        private readonly User $unliker
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
        // Determine the correct URL based on post type
        $link = match ($this->post->type) {
            1 => "/lodging/detail/{$this->post->id}",
            2 => "/dining/detail/{$this->post->id}",
            3 => "/communities/{$this->post->id}",
            default => "/posts/{$this->post->id}",
        };

        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title ?? 'Bài viết',
            'unliker_id' => $this->unliker->id,
            'unliker_name' => $this->unliker->name,
            'created_at' => now(),
            'message' => "{$this->unliker->name} đã bỏ thích bài viết của bạn",
            'link' => $link, // Updated link based on post type
            'type' => 'unlike',
            'post_type' => $this->post->type // Include post type in the event data
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'like.deleted';
    }
} 