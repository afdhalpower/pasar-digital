<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $oldStatus,
        public string $newStatus,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusLabel = match ($this->newStatus) {
            'processing' => 'sedang diproses',
            'completed' => 'selesai',
            'cancelled' => 'dibatalkan',
            'refunded' => 'direfund',
            default => $this->newStatus,
        };

        return (new MailMessage)
            ->subject("Status Pesanan #{$this->order->order_number}: {$statusLabel}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Status pesanan **#{$this->order->order_number}** telah berubah menjadi **{$statusLabel}**.")
            ->action('Lihat Pesanan', url("/dashboard/orders/{$this->order->id}"))
            ->line("Terima kasih telah berbelanja di PublikDigital!");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'type' => 'order_status_changed',
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Status pesanan #{$this->order->order_number} berubah menjadi {$this->newStatus}.",
        ];
    }
}
