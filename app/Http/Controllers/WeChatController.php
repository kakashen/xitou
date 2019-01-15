<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Log;

class WeChatController extends Controller
{
  public function serve()
  {
    Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

    $app = app('wechat.official_account');
    $app->server->push(function ($message) {
      $count = DB::table('qiu_shi_bai_kes')->count();

      $data = DB::table('qiu_shi_bai_kes')->find(rand(1, $count));
      $content = $data->content;
      return str_replace("<br>", "\n", $content);
    });

    $response = $app->server->serve();
    return $response;
  }
}
