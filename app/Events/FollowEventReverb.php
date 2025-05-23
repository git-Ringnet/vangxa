<?php

namespace App\Events;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FollowEventReverb implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Follower $follower The follower relationship
     * @param int|null $status The follow status (1 for follow, 0 for unfollow)
     */
    public function __construct(
        private readonly Follower $follower,
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
            new PrivateChannel('user.' . $this->follower->following_id)
        ];
    }
    
    /**
     * The data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        // Load the related users to include in the broadcast data
        $followerUser = $this->follower->follower()->first();
        $followingUser = $this->follower->following()->first();

        return [
            'status' => $this->status,
            'follower_id' => $this->follower->follower_id,
            'following_id' => $this->follower->following_id,
            'follower_name' => $followerUser ? $followerUser->name : null,
            'following_name' => $followingUser ? $followingUser->name : null,
            'created_at' => $this->follower->created_at,
            'action' => $this->status ? 'followed' : 'unfollowed',
            'message' => $this->status ?
                ($followerUser ? $followerUser->name : 'Someone') . ' đã bắt đầu theo dõi bạn' :
                ($followerUser ? $followerUser->name : 'Someone') . ' đã hủy theo dõi bạn',
            'link' => '/profile/' . $this->follower->follower_id,
            'type' => 'follow'
        ];
    }
}
