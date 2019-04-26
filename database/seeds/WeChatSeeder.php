<?php

use Illuminate\Database\Seeder;

class WeChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app = app('wechat.official_account');

        $result = $app->material->uploadImage("/path/to/your/image.jpg");


             /*{
                "media_id":MEDIA_ID,
                "url":URL
             }*/
    }
}
