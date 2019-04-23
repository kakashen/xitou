<?php

namespace App\Listeners;

use App\Events\HousePublish;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendHousePublishNotification
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
     * @param  HousePublish  $event
     * @return void
     */
    public function handle(HousePublish $event)
    {
        $message = new Text('Hello world!');

        $app = app('wechat.official_account');

        $result = $app->customer_service->message($message)->to($openId)->send();
    }
}
