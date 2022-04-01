<?php

namespace App\Notifications;

use App\Models\ProviderNotification;
use App\Models\User;
use App\Models\ServiceProvider;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;


class ExpoDatabaseChannel
{
    public function forServiceProvider($notifiable, $notification)
    {

        $data = $notification->toProvider($notifiable);

        // retrive all expo tokens from sanctum records (personal access tokens table)
        $Tos = $notifiable->routeNotificationFor('ExpoApp');

        // remove empty tokens (nulls and '') from the collection
        $Tos = $Tos->filter(function ($value) {
            return (!is_null($value) && $value !== '');
        });


        $providerNotification = ProviderNotification::create($data);
        if (!$Tos->isEmpty()) {
            $response = Http::withHeaders([
                'host' => 'exp.host',
                'accept' => 'application/json',
                'accept-encoding' => 'gzip, deflate',
                'content-type' => 'application/json'
            ])->post('https://exp.host/--/api/v2/push/send', [
                "to" => $Tos,
                "title" => $providerNotification->title,
                "body" => $providerNotification->body,
                'data' => $providerNotification,
            ]);
        }
    }

    public function forUser($notifiable, $notification)
    {
        $data = $notification->toUser($notifiable);

        // retrive all expo tokens from sanctum records (personal access tokens table)
        $Tos = $notifiable->routeNotificationFor('ExpoApp');

        // remove empty tokens (nulls and '') from the collection
        $Tos = $Tos->filter(function ($value) {
            return (!is_null($value) && $value !== '');
        });

        $userNotification = UserNotification::create($data);
        if (!$Tos->isEmpty()) {
            $response = Http::withHeaders([
                'host' => 'exp.host',
                'accept' => 'application/json',
                'accept-encoding' => 'gzip, deflate',
                'content-type' => 'application/json'
            ])->post('https://exp.host/--/api/v2/push/send', [
                "to" => $Tos,
                "title" => $userNotification->title,
                "body" => $userNotification->body,
                'data' => $userNotification,
            ]);
        }
    }

    public function send($notifiable, Notification $notification)
    {

        if ($notification->type == 'provider') {
            $this->forServiceProvider($notifiable, $notification);
        } else if ($notification->type == 'user') {
            $this->forUser($notifiable, $notification);
        }
    }
}
