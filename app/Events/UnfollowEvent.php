<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnfollowEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param object $followerData The follower relationship data saved before detaching
     * @param int|null $status The follow status (always 0 for unfollow)
     */
    public function __construct(
        private readonly object $followerData,
        public ?int $status = 0,
    ) {
        $this->status = $status;
    }

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
            new Channel('followers'),
            // Private channel cho user được follow
            new PrivateChannel('user.' . $this->followerData->following_id)
        ];
    }
    
    /**
     * The data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        // Lấy dữ liệu từ followerData object đã được lưu trước khi detach
        $followerUser = $this->followerData->follower;
        $followingUser = $this->followerData->following;

        return [
            'status' => $this->status, // Luôn là 0 cho unfollow
            'follower_id' => $this->followerData->follower_id,
            'following_id' => $this->followerData->following_id,
            'follower_name' => $followerUser ? $followerUser->name : null,
            'following_name' => $followingUser ? $followingUser->name : null,
            'created_at' => $this->followerData->created_at,
            'action' => 'unfollowed',
            'message' => ($followerUser ? $followerUser->name : 'Someone') . ' đã hủy theo dõi bạn',
            'link' => '/profile/' . $this->followerData->follower_id,
            'type' => 'follow'
        ];
    }
} 