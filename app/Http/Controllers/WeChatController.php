<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeChatController extends Controller
{
  public function checkSignature()
  {
    $signature = \request("signature");
    $timestamp = \request('timestamp');
    $nonce = \request('nonce');
    $echostr = \request('echostr');
    $token = env('WECHAT_TOKEN', 'nitaishuaile');

    $tmpArr = array($timestamp, $nonce, $token);
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode($tmpArr);
    $tmpStr = sha1($tmpStr);

    if ($signature == $tmpStr) {
      return $echostr;
    }
    return 0;
  }
}
