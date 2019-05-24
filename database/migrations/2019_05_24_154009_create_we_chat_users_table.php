<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeChatUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_chat_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscribe')->default(0);
            $table->string('openid')->default('');
            $table->string('nickname')->default('');
            $table->tinyInteger('sex')->default(0);
            $table->string('city')->default(0);
            $table->string('province')->default(0);
            $table->string('country')->default(0);
            $table->bigInteger('subscribe_time')->default(0);
            $table->string('unionid')->default(0);
            $table->string('remark')->default(0);
            $table->string('groupid')->default(0);
            $table->json('tagid_list')->default(null);
            $table->string('subscribe_scene')->default('');
            $table->integer('qr_scene')->default(0);
            $table->string('qr_scene_str')->default('');
            $table->timestamps();
            /*
             * <xml>
              <ToUserName><![CDATA[toUser]]></ToUserName>
              <FromUserName><![CDATA[fromUser]]></FromUserName>
              <CreateTime>1348831860</CreateTime>
              <MsgType><![CDATA[text]]></MsgType>
              <Content><![CDATA[this is a test]]></Content>
              <MsgId>1234567890123456</MsgId>
            </xml>
            */
            /*{
                "subscribe": 1,
                "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
                "nickname": "Band",
                "sex": 1,
                "language": "zh_CN",
                "city": "广州",
                "province": "广东",
                "country": "中国",
                "headimgurl":"http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
                "subscribe_time": 1382694957,
                "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
                "remark": "",
                "groupid": 0,
                "tagid_list":[128,2],
                "subscribe_scene": "ADD_SCENE_QR_CODE",
                "qr_scene": 98765,
                "qr_scene_str": ""
            }
             */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('we_chat_users');
    }
}
