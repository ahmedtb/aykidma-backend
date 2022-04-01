<?php

namespace App\Notifications\user;

use App\Models\ServiceProvider;
use Illuminate\Bus\Queueable;
use App\Notifications\ExpoChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProviderAcountActivated extends Notification
{
    use Queueable;


    public $provider;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', ExpoChannel::class];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'provider activated',
            'body' => 'congratulation, your provider account is active now',
            'redirectTo' => ''
        ];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toExpoApp($notifiable)
    {
        return [
            'title' => 'provider activated',
            'body' => 'congratulation, your provider account is active now',
            'redirectTo' => ''
        ];
    }
}
