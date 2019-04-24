<?php

use App\SecondHouse;
use Illuminate\Database\Seeder;
use QL\QueryList;

class House58List extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $url = 'https://rizhao.58.com/rzkfq/ershoufang/h1/?PGTID=0d30000c-00c6-a843-6e3d-3c0044e82773&ClickID=1';
        // 个人
        $url = 'https://rizhao.58.com/ershoufang/0/?PGTID=0d30000c-00c6-9909-d709-83e17f5761d2&ClickID=1';
        $get = QueryList::get($url);

        // 定义采集规则
        $rules = [
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
            if (!$this->startsWith($value['link'], 'https:')) {
                $value['link'] = 'https:' . $value['link'];
            }
            $date_time = $this->getDateTime($logr[$k]['logr']);
            $value['post_date'] = $date_time;
            $value['from'] = '58';
            $value['type'] = 1;
            print_r($value);
        }

        unset($value);
//        SecondHouse::insert($all);
        foreach ($all as $item) {
            $link = $item['link'] ?? null;
            if (!$link) continue;

            unset($item['link']);

            SecondHouse::updateOrCreate([
                'link' => $link
            ],$item);
        }
    }

    /**
     * @param string $logr
     * @return bool|string
     * 获取时间戳 ms
     */
    private function getDateTime(string $logr)
    {
        $num = strpos($logr, '@postdate:');

        return floor(substr($logr, $num + 10, 13) / 1000);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    private function startsWith($haystack, $needle): bool
    {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}
