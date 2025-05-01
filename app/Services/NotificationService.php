<?php

namespace App\Services;

use App\Notifications\Notifications;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Noitification;

class NotificationService
{
    /**
     * Gửi thông báo cho một hoặc nhiều users.
     *
     * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|\App\Models\User $users
     * @param string $message
     * @param array $additionalData (optional)
     * @return void
     */
    public static function send($users, string $message, array $additionalData = [])
    {
        if (!$users) {
            return;
        }

        if (!$users instanceof \Illuminate\Support\Collection) {
            $users = collect([$users]);
        }

        // Gửi thông báo
        Notification::send($users, new Notifications(array_merge([
            'message' => $message,
        ], $additionalData)));
    }
}
