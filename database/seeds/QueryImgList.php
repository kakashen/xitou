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

    for ($i = 1; $i <= 20; $i++) {
      $qiushi_tag_id = [];
      $list = QueryList::get("https://www.qiushibaike.com/text/page/$i/");
      $qiushi_tag_id[] = $list->find('#content-left .block')->attrs("id");
      $contents = $list->find('.content span')->htmls();

      print_r($contents);

      $cnt = 0;
      foreach ($contents as $key => $content) {
        if ($content == '查看全文') {
          $cnt--;
          continue;
        };

        DB::table('qiu_shi_bai_kes')->updateOrInsert(
          ['qiushi_tag_id' => $qiushi_tag_id[0][$cnt]],
          ['qiushi_tag_id' => $qiushi_tag_id[0][$cnt], 'content' => $content]
        );
        $cnt++;
      }
    }
  }
}
