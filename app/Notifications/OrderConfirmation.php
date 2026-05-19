<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmation extends Notification implements ShouldQueue
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
        $totalTransfer = number_format($this->order->total_transfer, 0, ',', '.');

        return (new MailMessage)
            ->subject("Konfirmasi Pesanan #{$this->order->order_number}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Pesanan Anda dengan nomor **#{$this->order->order_number}** telah berhasil dibuat.")
            ->line("Total yang harus ditransfer: **Rp {$totalTransfer}**")
            ->line("Silakan lakukan pembayaran ke rekening BCA 1234567890 a.n. PT PublikDigital Indonesia.")
            ->line("Jangan lupa sertakan kode unik **{$this->order->unique_code}** pada saat transfer.")
            ->action('Lihat Pesanan', url("/dashboard/orders/{$this->order->id}"))
            ->line("Terima kasih telah berbelanja di PublikDigital!");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'type' => 'order_confirmation',
            'message' => "Pesanan #{$this->order->order_number} berhasil dibuat.",
        ];
    }
}
