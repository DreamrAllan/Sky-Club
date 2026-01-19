<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewBookingUserNotification extends Notification
{
    use Queueable;
    protected $booking;
    protected $total;
    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, $total)
    {
        $this->booking = $booking;
        $this->total = $total;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'total' => $this->total,
            'payment_date' => $this->booking->created_at,
            'message' => 'Pembayaran anda telah berhasil, silahkan menunggu konfirmasi admin.',
            'type' => 'Pembayaran'
        ];
    }
}
