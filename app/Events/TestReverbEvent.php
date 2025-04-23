<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;


class TestReverbEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly Post $post,
        public ?int $status = 0,
    ) {
        $this->status = $status ?? $post->status;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('posts.' . $this->post->id);
    }

    public function broadcastWith(): array
    {
        return [
            'status' => $this->status,
            'post' => $this->post
        ];
    }
}