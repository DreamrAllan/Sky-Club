<?php

namespace App\Listeners;

use App\Events\SparingCreated;
use App\Notifications\NewSparingNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationForNewSparing implements ShouldQueue
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
    public function handle(SparingCreated $event): void
    {
        Notification::send($event->user, new NewSparingNotification($event->sparing));
    }
}
