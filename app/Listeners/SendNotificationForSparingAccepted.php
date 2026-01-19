<?php

namespace App\Listeners;

use Mockery\Matcher\Not;
use App\Events\SparingRequestAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AcceptSparingNotification;

class SendNotificationForSparingAccepted implements ShouldQueue
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
    public function handle(SparingRequestAccepted $event): void
    {
        Notification::send($event->user, new AcceptSparingNotification($event->sparing_req));
        // Notification::send($event->created_by, new AcceptSparingNotification($event->sparing_req));
    }
}
