<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderRefunded extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $total = number_format($this->order->total_transfer, 0, ',', '.');

        return (new MailMessage)
            ->subject("Refund Pesanan #{$this->order->order_number}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Pesanan **#{$this->order->order_number}** telah di-refund.")
            ->line("Sejumlah **Rp {$total}** akan dikembalikan sesuai metode pembayaran yang digunakan.")
            ->action('Lihat Pesanan', url("/dashboard/orders/{$this->order->id}"))
            ->line("Terima kasih telah berbelanja di PublikDigital!");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'type' => 'order_refunded',
            'message' => "Pesanan #{$this->order->order_number} telah di-refund.",
        ];
    }
}
