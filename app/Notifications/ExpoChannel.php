<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;


class ExpoChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toExpoApp($notifiable);

        $Tos = $notifiable->routeNotificationFor('ExpoApp')->pluck('expo_token');       
        // dd($Tos);
        $response = Http::withHeaders([
            'host' => 'exp.host',
            'accept' => 'application/json',
            'accept-encoding' => 'gzip, deflate',
            'content-type' => 'application/json'
        ])->post('https://exp.host/--/api/v2/push/send', [
            "to" => $Tos,
            "title" => "طلب وجبة",
            "body" => $message
        ]);
    }
}
