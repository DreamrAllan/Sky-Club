<?php

namespace App\Events;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaymentUplouded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking;
    public $total;
    /**
     * Create a new event instance.
     */
    public function __construct(Booking $booking, $total)
    {
        $this->booking = $booking;
        $this->total = $total;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
