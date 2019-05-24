<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Log;

class WeChatController extends Controller
{
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            $openid = $message['FromUserName'] ?? null;
            if ($openid) {
                try {
                    DB::table('we_chat_users')->updateOrInsert([
                        'openid' => $openid,
                    ]);
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }

            switch ($message['MsgType']) {
                case 'event':
                    if ($message['Event'] === 'subscribe') {
                        return '欢迎私聊获取武功秘籍(NDD)~~~ \r\n 回复 动漫 , 获取珍藏动漫图片';
                    }
                    return '欢迎关注';
                    break;
                case 'text':
                    return $this->sendText($message['Content']);
                    break;
                case 'image':
                    return $this->sendImage();
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

    /**
     * @param string
     * @return mixed
     */
    private function sendImage()
    {
        $count = DB::table('qiu_shi_bai_kes')->count();
        $data = DB::table('qiu_shi_bai_kes')->find(rand(1, $count));
        $content = $data->content;
        return str_replace("<br>", "\n", $content);
    }

    private function sendText(string $message)
    {
        if ($message == '二手房') {
            try {
                $list = new \House58List();
                $list->run();
                $detail = new \House58Detail();
                $detail->run(2);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }

            $data = DB::table('second_houses')->orderBy('post_date', 'desc')
                ->limit(10)->get(['id', 'phone', 'sum', 'community', 'area', 'region', 'post_date']);

            $response = [];
            foreach ($data as $datum) {
                $content = implode('-', [$datum->phone, $datum->sum, $datum->community,
                    $datum->area, $datum->region, date('Y-m-d H:i:s', $datum->post_date)]);
                $response[] = $content;
            }
            return implode("\r\n\r\n\r\n", $response);
        }

        if ($message == '你懂得') {
            $data = DB::table('img_lists')->select(['media_id'])->where('type', 3)->inRandomOrder()->first();
            return new Image($data->media_id);
        }

        if ($message) {
            $image_list_ids = Cache::get('image_list_ids');
            if (!$image_list_ids) {
                $image_list_ids = DB::table('img_lists')->where('type', 2)->get(['media_id'])->toArray();
                Cache::add('image_list_ids', $image_list_ids, 1440);
            }
            $media_id = $image_list_ids[mt_rand(0, count($image_list_ids))];

            return new Image($media_id->media_id);
        }

        if ($message == '图片') {
            $image_list_ids = Cache::get('image_list_ids');
            if (!$image_list_ids) {
                $image_list_ids = DB::table('img_lists')->where('type', 0)->get(['media_id'])->toArray();
                Cache::add('image_list_ids', $image_list_ids, 1440);
            }
            $media_id = $image_list_ids[mt_rand(0, count($image_list_ids))];

            return new Image($media_id->media_id);
        }

        $count = DB::table('qiu_shi_bai_kes')->count();
        $data = DB::table('qiu_shi_bai_kes')->find(rand(1, $count));
        $content = $data->content;
        return str_replace("<br>", "\n", $content);
    }
}
