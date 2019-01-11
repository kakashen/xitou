<?php

namespace App\Http\Controllers;

use EasyWeChat\Factory;

class WeChatController extends Controller
{
  public function serve()
  {
    $config = [
      'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID'),
      'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET'),
      'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN'),
      'response_type' => 'array',
    ];

    $app = Factory::officialAccount($config);

    $response = $app->server->serve();

    return $response;
  }
}
