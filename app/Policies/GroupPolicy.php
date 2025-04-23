<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    public function update(User $user, Group $group)
    {
        return $user->id === $group->user_id || $group->isAdmin($user);
    }

    public function delete(User $user, Group $group)
    {
        return $user->id === $group->user_id;
    }

    public function manageMembers(User $user, Group $group)
    {
        return $user->id === $group->user_id || $group->isAdmin($user);
    }

    public function createPost(User $user, Group $group)
    {
        return $group->isMember($user);
    }

    public function moderatePost(User $user, Group $group)
    {
        return $group->isModerator($user) || $group->isAdmin($user);
    }
} 