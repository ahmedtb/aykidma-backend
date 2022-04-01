<?php

namespace App\Notifications\user;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderResumed extends Notification
{
    use Queueable;

    public $order;
    public $byUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $byUser)
    {
        $this->order = $order;
        $this->byUser = $byUser;

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
            'title' => 'your order is accepted', 
            'body' => 'order: ' . $this->order->id, 'user',
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
        return $this->toDatabase($notifiable);
    }
}
