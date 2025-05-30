<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // Channels: database + mail (optional)
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    // Mail version (optional)
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject("New Order #{$this->order->id}")
                    ->line("You have a new order for “{$this->order->product->name}”.")
                    ->action('View Order', url("/seller/orders/{$this->order->id}"));
    }

    // In-app version
    public function toDatabase($notifiable): array
    {
        return [
            'order_id'   => $this->order->id,
            'product'    => $this->order->product->name,
            'quantity'   => $this->order->quantity,
            'customer'   => $this->order->customer->user->name,
        ];
    }
}
