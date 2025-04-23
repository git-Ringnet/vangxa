<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Add authorization for test-channel
Broadcast::channel('posts.{postId}', function ($user, $postId) {
    return true;
});
