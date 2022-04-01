<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification
{
    use Queueable;

    public $title, $body, $type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $body, $type)
    {
        //
        $this->title = $title;
        $this->body = $body;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ExpoDatabaseChannel::class];
    }



    public function toExpoApp($notifiable)
    {

        return [
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'user_id' => $notifiable->id,
        ];
    }

    public function toExpoAppAndDatabase($notifiable)
    {

        return [
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'user_id' => $notifiable->id,
        ];
    }

    public function toUser($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'user_id' => $notifiable->id,
        ];
    }

    public function toProvider($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'service_provider_id' => $notifiable->id,
        ];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'user_id' => $notifiable->id,
            'sent' => true
        ];
    }
}
