<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Image;
use Illuminate\Support\Facades\DB;
use Log;

class WeChatController extends Controller
{
  public function serve()
  {
    Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

    $app = app('wechat.official_account');
    $app->server->push(function ($message) {


      switch ($message['MsgType']) {
        case 'event':
          return '收到事件消息';
          break;
        case 'text':
            if ($message['Content'] == '二手房') {
                $data = DB::table('second_houses')->orderBy('post_date', 'desc')
                    ->limit(10)->get(['id', 'phone', 'sum', 'community', 'area', 'region','post_date']);

                $response = [];
                foreach ($data as $datum) {
                    $content = implode('-', [$datum->phone, $datum->sum, $datum->community,
                        $datum->area, $datum->region, date('Y-m-d H:i:s', $datum->post_date)]);
                    $response[] = $content;
                }
                return implode("\r\n\r\n\r\n", $response);
            }

          if ($message['Content'] == '图片') {
            $count = DB::table('img_lists')->count();
            $data = DB::table('img_lists')->find(rand(1, $count));
            $mediaId = $data->media_id;
            return new Image($mediaId);
          }

          $count = DB::table('qiu_shi_bai_kes')->count();
          $data = DB::table('qiu_shi_bai_kes')->find(rand(1, $count));
          $content = $data->content;
          return str_replace("<br>", "\n", $content);
          break;
        case 'image':
          return '收到图片消息';
          break;
        case 'voice':
          return '收到语音消息';
          break;
        case 'video':
          return '收到视频消息';
          break;
        case 'location':
          return '收到坐标消息';
          break;
        case 'link':
          return '收到链接消息';
          break;
        case 'file':
          return '收到文件消息';
        default:
          return '收到其它消息';
          break;
      }
    });

    $response = $app->server->serve();
    return $response;
  }
}
