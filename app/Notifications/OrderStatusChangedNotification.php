<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject("Order #{$this->order->id} Status Updated")
                    ->line("Your order for “{$this->order->product->name}” is now “{$this->order->status}.”")
                    ->action('View Order', url("/customer/orders/{$this->order->id}"));
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'status'   => $this->order->status,
            'product'  => $this->order->product->name,
        ];
    }
}
