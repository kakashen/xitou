<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use QL\QueryList;

class QueryImgList extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    for ($i = 1; $i <= 1; $i++) {
      $list = QueryList::get("https://www.qiushibaike.com/imgrank/page/$i/");
      $srcs = $list->find('.thumb img')->attrs("src")->all();

      foreach ($srcs as $key => $src) {
        $src = "http://" . substr($src, 2);

        if (!$finename = $this->file_exists_S3($src)) continue;
        $app = app('wechat.official_account');
        $result = $app->material->uploadImage($finename); // {"errcode":40007,"errmsg":"invalid media_id"}
        // {
        //    "media_id":MEDIA_ID,
        //    "url":URL
        // }

        if (!isset($result['media_id'])) continue;

        // 保存数据
        DB::table('img_lists')->updateOrInsert(
          ['qiu_url' => $src],
          ['qiu_url' => $src, 'media_id' => $result['media_id'], 'url' => $result['url']]
        );
      }
    }
  }

  private function file_exists_S3(string $url)
  {
    $state = @file_get_contents($url, 0, null, 0, 1); // 获取网络资源的字符内容
    if ($state) {
      $filename = storage_path('app/public/') . date("dMYHis") . '.jpg'; // 文件名称生成
      ob_start(); // 打开输出
      readfile($url); // 输出图片文件
      $img = ob_get_contents(); // 得到浏览器输出
      ob_end_clean(); // 清除输出并关闭
      $fp2 = @fopen($filename, "a");
      fwrite($fp2, $img); // 向当前目录写入图片文件，并重新命名
      fclose($fp2);
      return $filename;
    } else {
      return 0;
    }
  }
}
