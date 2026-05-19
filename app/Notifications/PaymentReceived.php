<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $total = number_format($this->order->total, 0, ',', '.');

        return (new MailMessage)
            ->subject("Pembayaran Diterima #{$this->order->order_number}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Pembayaran untuk pesanan **#{$this->order->order_number}** sebesar **Rp {$total}** telah kami terima dan diverifikasi.")
            ->line("Pesanan Anda sedang diproses. Anda akan segera dapat mengunduh produk Anda.")
            ->action('Lihat Pesanan', url("/dashboard/orders/{$this->order->id}"))
            ->line("Terima kasih telah berbelanja di PublikDigital!");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'type' => 'payment_received',
            'message' => "Pembayaran untuk pesanan #{$this->order->order_number} telah diterima.",
        ];
    }
}
