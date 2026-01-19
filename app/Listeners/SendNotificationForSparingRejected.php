<?php

namespace App\Listeners;

use App\Events\SparingRequestRejected;
use App\Notifications\RejectSparingNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationForSparingRejected implements ShouldQueue
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
    public function handle(SparingRequestRejected $event): void
    {
        Notification::send($event->user, new RejectSparingNotification($event->sparing_req));
    }
}
