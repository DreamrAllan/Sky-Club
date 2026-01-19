<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\SparingRequestCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SparingRequestNotification;

class SendNotificationForSparingRequest implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SparingRequestCreated $event): void
    {
        $created_by = User::find($event->sparing->created_by);
        Notification::send($created_by, new SparingRequestNotification($event->sparing_request));
        // Notification::send($event->userRequest,  new SparingRequestNotification($event->sparing_request));
    }
}
