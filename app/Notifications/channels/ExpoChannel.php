<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Http;

class ExpoDatabaseChannel
{

    public function send($notifiable, $notification)
    {


        $data = $notification->toExpoApp($notifiable);

        // retrive all expo tokens from sanctum records (personal access tokens table)
        $Tos = $notifiable->routeNotificationFor('ExpoApp');

        // remove empty tokens (nulls and '') from the collection
        $Tos = $Tos->filter(function ($value) {
            return (!is_null($value) && $value !== '');
        });


        if (!$Tos->isEmpty()) {
            $response = Http::withHeaders([
                'host' => 'exp.host',
                'accept' => 'application/json',
                'accept-encoding' => 'gzip, deflate',
                'content-type' => 'application/json'
            ])->post('https://exp.host/--/api/v2/push/send', [
                "to" => $Tos,
                "title" => $data->title,
                "body" => $data->body,
                'data' => $data,
            ]);
        }
    }
}
