<?php

namespace App\Listeners;

use App\Chat;
use App\Events\ChatLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChatLogNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ChatLog $event
     * @return void
     */
    public function handle(ChatLog $event)
    {
        $chat = new Chat();
        $data = [
            'openid' => $event->openid,
            'type' => $event->type,
            'content' => $event->content
        ];
        $chat->insert($data);
    }
}
