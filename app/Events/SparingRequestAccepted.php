<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SparingRequestAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $sparing_req;
    public $created_by;
    public $user;
    /**
     * Create a new event instance.
     */
    public function __construct($sparing_req)
    {
        $this->sparing_req = $sparing_req;
        // $this->created_by = User::find($sparing_req->sparing->created_by);
        $this->user = User::find($sparing_req->user->id);
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
