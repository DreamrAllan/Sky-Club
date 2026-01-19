<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBookingStatus implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $booking = Booking::find($this->id);
        if ($booking && $booking->status == 'pending') {
            $booking->status = 'canceled';
            $booking->save();
        }
    }
}
