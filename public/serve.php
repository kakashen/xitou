<?php
/**
 * Created by PhpStorm.
 * User: liufang
 * Date: 2019/1/11
 * Time: 16:10
 */

use EasyWeChat\Factory;

$config = [
  'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID'),
  'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET'),
  'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN'),
  'response_type' => 'array',
];

$app = Factory::officialAccount($config);

$response = $app->server->serve();

return $response;