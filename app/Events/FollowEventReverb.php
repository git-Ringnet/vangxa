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

class FollowEventReverb  implements ShouldBroadcast
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
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn(): Channel
    {
        // Broadcasting to a public channel named 'followers'
        return new Channel('followers');

        // Alternatively, you could use a private channel for the specific user
        // return new PrivateChannel('App.Models.User.' . $this->follower->following_id);
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
                ($followerUser ? $followerUser->name : 'Someone') . ' followed ' . ($followingUser ? $followingUser->name : 'you') :
                ($followerUser ? $followerUser->name : 'Someone') . ' unfollowed ' . ($followingUser ? $followingUser->name : 'you')
        ];
    }
}
