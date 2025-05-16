<?php

namespace App\Events;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Comment $comment Bình luận mới
     * @param Post $post Bài viết được bình luận
     * @param User $user Người bình luận
     */
    public function __construct(
        private readonly Comment $comment,
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
            new Channel('comments'),
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
            'comment_id' => $this->comment->id,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title ?? 'Bài viết',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'created_at' => now(),
            'message' => "{$this->user->name} đã bình luận bài viết của bạn",
            'link' => "/posts/{$this->post->id}#comment-{$this->comment->id}", // Link đến bài viết với anchor tới comment
            'type' => 'comment'
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'comment.created';
    }
} 