<?php

namespace App\Console\Commands;

use App\Events\TestReverbEvent;
use App\Models\Post;
use Illuminate\Console\Command;

class DispatchTestEvent extends Command
{
    protected $signature = 'post:update-status {status}';

    protected $description = 'Update the status of an post.';

    public function handle(): void
    {
        $post = Post::first();
        $post->status = $this->argument('status');
        $post->save();

        TestReverbEvent::dispatch($post, $this->argument('status'));
    }
}