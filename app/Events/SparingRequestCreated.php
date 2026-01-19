<?php

namespace App\Events;

use App\Models\Sparing;
use App\Models\SparingRequest;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SparingRequestCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $sparing;
    public $sparing_request;
    public $userRequest;
    /**
     * Create a new event instance.
     */
    public function __construct(Sparing $sparing, SparingRequest $sparing_request)
    {
        $this->sparing = $sparing;
        $this->sparing_request = $sparing_request;
        // $this->userRequest = Auth::user();
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
