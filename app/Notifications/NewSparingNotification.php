<?php

namespace App\Notifications;

use App\Models\Sparing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewSparingNotification extends Notification
{
    use Queueable;
    protected $sparing;

    /**
     * Create a new notification instance.
     */
    public function __construct(Sparing $sparing)
    {
        $this->sparing = $sparing;
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
            'booking_id' => $this->sparing->id,
            'created_by' => $this->sparing->createdBy->name,
            'team' => $this->sparing->createdBy->team,
            'created_at' => $this->sparing->created_at,
            'schedule' => $this->sparing->listBooking->formatted_date,
            'session' => $this->sparing->listBooking->formatted_session,
            'field' => $this->sparing->listBooking->field->name,
            'message' => 'Berhasil membuat sparing',
            'type' => 'Sparing',
        ];
    }
}
