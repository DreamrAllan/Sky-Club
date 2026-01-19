<?php

namespace App\Notifications;

use App\Models\Sparing;
use App\Models\SparingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptSparingNotification extends Notification
{
    use Queueable;
    protected $request_sparing;

    /**
     * Create a new notification instance.
     */
    public function __construct(SparingRequest $request_sparing)
    {
        $this->request_sparing = $request_sparing;
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
            'created_by' => $this->request_sparing->sparing->createdBy->name,
            'team' => $this->request_sparing->sparing->createdBy->team,
            'created_at' => $this->request_sparing->sparing->created_at,
            'schedule' => $this->request_sparing->sparing->listBooking->formatted_date,
            'session' => $this->request_sparing->sparing->listBooking->formatted_session,
            'field' => $this->request_sparing->sparing->listBooking->field->name,
            'message' => 'Permintaan sparing kamu telah disetujui',
            'type' => 'Persetujuan Sparing',
        ];
    }
}
