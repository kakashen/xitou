<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $material = $app->material;

        $start = 0;
        for ($i = 0; $i < 19; $i++) {
            $res = $material->list('image', $start, 20);

            foreach ($res['item'] as $re) {
                $media_id = $re['media_id'];
                $name = $re['name'];
                $url = $re['url'];

                DB::table('img_lists')->updateOrInsert([
                   'media_id' => $media_id
                ],['media_id' => $media_id, 'name' => $name, 'url' => $url]);
            }
            $start += 20;
            echo $start;
        }

    }
}
