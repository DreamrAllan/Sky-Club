<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Models\ListBooking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateListBooking implements ShouldQueue
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
    public function handle(BookingCreated $event): void
    {
        ListBooking::create([
            'date' => $event->schedule['date'],
            'session' => $event->schedule['session'],
            'id_booking' => $event->newBooking->id,
            'id_field' => 1
        ]);
    }
}
