<?php

namespace App\Notifications;

use App\Models\UserNotification;
use Illuminate\Notifications\Notification;


class DatabaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);
        UserNotification::create($data);
    }
}
