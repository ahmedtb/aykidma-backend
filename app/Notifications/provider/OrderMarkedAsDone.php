<?php

namespace App\Notifications\Provider;

use App\Models\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use App\Notifications\ExpoChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderMarkedAsDone extends Notification
{
    use Queueable;

    public $user;
    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order)
    {
        $this->user = $user;
        $this->order = $order;
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
            'title' => 'your order is marked as done by ' . $this->user->name,
            'body' => 'order number ' . $this->order->id . ' order date ' . $this->order->created_at,
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
            'title' => 'your order is marked as done by ' . $this->user->name,
            'body' => 'order number ' . $this->order->id . ' order date ' . $this->order->created_at,
            'redirectTo' => ''
        ];
    }
}
