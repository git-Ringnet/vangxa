<?php

namespace App\Providers;

use App\Events\FollowEventReverb;
use App\Events\LikeEvent;
use App\Events\UnlikeEvent;
use App\Events\UnfollowEvent;
use App\Events\TrustlistEvent;
use App\Events\UntrustEvent;
use App\Events\CommentEvent;
use App\Listeners\CreateFollowNotification;
use App\Listeners\CreateLikeNotification;
use App\Listeners\CreateUnlikeNotification;
use App\Listeners\CreateUnfollowNotification;
use App\Listeners\CreateTrustlistNotification;
use App\Listeners\CreateUntrustNotification;
use App\Listeners\CreateCommentNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // FollowEventReverb::class => [
        //     CreateFollowNotification::class,
        // ],
        // UnfollowEvent::class => [
        //     CreateUnfollowNotification::class,
        // ],
        // LikeEvent::class => [
        //     CreateLikeNotification::class,
        // ],
        // UnlikeEvent::class => [
        //     CreateUnlikeNotification::class,
        // ],
        // TrustlistEvent::class => [
        //     CreateTrustlistNotification::class,
        // ],
        // UntrustEvent::class => [
        //     CreateUntrustNotification::class,
        // ],
        // CommentEvent::class => [
        //     CreateCommentNotification::class,
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
} 