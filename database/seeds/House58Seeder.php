<?php

use App\SecondHouse;
use Illuminate\Database\Seeder;
use QL\QueryList;

class House58Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $url = 'https://rizhao.58.com/rzkfq/ershoufang/h1/?PGTID=0d30000c-00c6-a843-6e3d-3c0044e82773&ClickID=1';

        $get = QueryList::get($url);

        // 定义采集规则
        $rules = [
            // 采集文章标题
            // 'title' => ['h2>a', 'text'],
            'link' => ['h2>a', 'href'],
            // 'baseinfo1' => ['p:eq(1)', 'text'],
            // 'baseinfo2' => ['p:eq(2)', 'text'],
            // 'jjrinfo' => ['.jjrinfo>span:eq(1)', 'text'],
            'sum' => ['.price>.sum', 'text']
        ];

        $range = '.house-list-wrap>li';
        // 采集logr
        $rule_logr = [
            'logr' => ['.house-list-wrap>li', 'logr']
        ];
        $logr = $get->rules($rule_logr)->query()->getData();

        $data = $get->rules($rules)->range($range)->query()->getData();

        $all = $data->all();

        foreach ($all as $k => &$value) {
            $post_date = $this->getDateTime($logr[$k]['logr']);
            $value['post_date'] = $post_date ? $post_date : strtotime('-1 year') * 1000;
            $link = $value['link'];
            $detail = QueryList::get($link);
            $detail_rules = [
                // 'name' => ['meta', 'content'],
                'phone' => ['.phone-num', 'text'],
                'community' => ['.mr_10>a:eq(0)', 'text'],
                'region' => ['.mr_10>a:eq(1)', 'text'],
                // house-basic-item2
                'area' => ['.main', 'text'],
            ];

            $user = $detail->rules($detail_rules)->query()->getData();
            $phone = $community = $area = '';
            foreach ($user as $item) {
                $phone = $item['phone'] ?? '';
                $community = $item['community'] ?? '';
                $area = $item['area'] ?? '';
            }
            $value['phone'] = $phone;
            $value['community'] = $community;
            $value['area'] = $area;

            sleep(1);
        }
        unset($value);

        SecondHouse::insert($all);
    }

    /**
     * @param string $logr
     * @return bool|string
     * 获取时间戳 ms
     */
    private function getDateTime(string $logr)
    {
        $num = strpos($logr, '@postdate:');

        return (int)substr($logr, $num + 10, 13) / 1000;
    }
}
