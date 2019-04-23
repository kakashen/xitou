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
        $users = $app->user->list();
        var_dump($users);
    }
}
