<?php

namespace App\Http\Controllers;

use App\Model\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use EasyWeChat\Factory;
use function EasyWeChat\Kernel\Support\get_client_ip;

class SunnyController extends Controller
{

    public function kids()
    {
        $data = [
            [
                'id' => 1,
                'name' => "小米",
                'title' => '我的祖国',
                'image' => 'http://t1.hxzdhn.com/uploads/tu/201910/9999/985531bd0d.jpg1',
                'post' => rand(1, 100),
            ],
            [
                'id' => 2,
                'name' => "大黄",
                'title' => '我的宝宝',
                'image' => 'http://t1.hxzdhn.com/uploads/tu/201910/9999/985531bd0d.jpg1',
                'post' => rand(1, 100),
            ],
            [
                'id' => 3,
                'name' => "小黑",
                'title' => '我的师妹',
                'image' => 'http://t1.hxzdhn.com/uploads/tu/201910/9999/985531bd0d.jpg1',
                'post' => rand(1, 100),

            ],
            [
                'id' => 4,
                'name' => "小明",
                'title' => '我的世界',
                'image' => 'http://t1.hxzdhn.com/uploads/tu/201910/9999/985531bd0d.jpg1',
                'post' => rand(1, 100),

            ],
        ];

        return response()->json(['data' => $data]);
    }

    public function vote(Request $request)
    {
        $id = $request->get('id');
        return response()->json(['data' => $id]);
    }

    public function detail(Request $request)
    {
        $id = $request->get('id');
        Log::info($id);
        $data = [
            'id' => $id,
            'name' => '小黑',
            'title' => '我的祖国',
            'text' => '内容'
        ];
        return response()->json(['data' => $data]);

    }

    public function wxLogin(Request $request)
    {
        $code = $request->get('code');
        $config = [
            'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID'),
            'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET'),

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];
        $app = Factory::miniProgram($config);
        $info = $app->auth->session($code);


        Log::info($request);
        Log::info($info);

    }

    public function info(Request $request)
    {
        $ip = get_client_ip();
        Log::info($ip);
        Log::info($request);
        $user_name = $request->get('user_name') ?? $request->get('real_name');
        $real_name = $request->get('real_name') ?? '帅比';
        $real_age = $request->get('real_age') ?? 22;
        $birthday = $request->get('birthday') ?? date('Y-m-d');
        $myemail = $request->get('myemail') ?? '暂无';
        $card = $request->get('card') ?? '保密';
        $telphone = $request->get('telphone') ?? 保密;
        $myurl = $request->get('myurl') ?? '保密';
        $lovecolor = $request->get('lovecolor') ?? '保密';

        $data = [
            'user_name' => $user_name,
            'real_name' => $real_name,
            'real_age' => $real_age,
            'birthday' => $birthday,
            'myemail' => $myemail,
            'card' => $card,
            'telphone' => $telphone,
            'myurl' => $myurl,
            'lovecolor' => $lovecolor,
            'content' => $request->get('content') ?? '暂无',
            'created_at' => date('Y-m-d H:i:s')

        ];

        $ret = StudentInfo::insert($data);

        Log::info($ret);

    }
}
