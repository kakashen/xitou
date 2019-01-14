<?php
/**
 * Created by PhpStorm.
 * User: liufang
 * Date: 2019/1/11
 * Time: 16:10
 */

use EasyWeChat\Factory;

$config = [
  'app_id' => 'wx09b737d8939e9698',
  'secret' => '9786277ef66c542fb79eb588fdfcf110',
  'token' => 'nitaishuaile',
  'response_type' => 'array',
];

$app = Factory::officialAccount($config);

$response = $app->server->serve();

echo 123;