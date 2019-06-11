<?php

namespace App\Events;

use App\Chat;
use App\ChatInfo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $info;
    /**
     * Create a new event instance.
     *
     * @param ChatInfo $info
     */
    public function __construct(ChatInfo $info)
    {
        $this->info = $info;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

