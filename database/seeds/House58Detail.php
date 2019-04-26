<?php

use App\SecondHouse;
use Illuminate\Database\Seeder;
use QL\QueryList;

class House58Detail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(int $limit = 10000)
    {
        $gets = SecondHouse::where('phone', '')->limit($limit)->get();
        $i = 0;
        foreach ($gets as $get) {
            $link = $get->link;
            $detail = QueryList::get($link);
            $rules = [
                // 'name' => ['meta', 'content'],
                'phone' => ['.phone-num', 'text'],
                'community' => ['.house-basic-item3>li:eq(0)>span:eq(1)', 'text'],
                'region' => ['.house-basic-item3>li:eq(1)>span:eq(1)>a:eq(0)', 'text'],
                'area' => ['.area>.main', 'text'],
            ];

            $data = $detail->rules($rules)->query()->getData()->all();

            if (isset($data[0]) && count($data[0]) === 4) {

                $ret = SecondHouse::where('id', $get->id)->update([
                        'phone' => $data[0]['phone'],
                        'community' => $data[0]['community'],
                        'region' => $data[0]['region'],
                        'area' => $data[0]['area'],
                    ]);
                if ($ret) {
                    echo $i++;
                }
            }
            sleep(1);
        }
    }
}
