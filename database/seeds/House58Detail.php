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
    public function run()
    {
        $gets = SecondHouse::where('phone', '')->get();
        foreach ($gets as $get) {
            $link = $get->link;
            $detail = QueryList::get($link);
            $rules = [
                // 'name' => ['meta', 'content'],
                'phone' => ['.phone-num', 'text'],
                'community' => ['.mr_10>a:eq(0)', 'text'],
                'region' => ['.mr_10>a:eq(1)', 'text'],
                'area' => ['.area>.main', 'text'],
            ];

            $data = $detail->rules($rules)->query()->getData()->all();

            if (isset($data[0]) && count($data[0]) === 4) {

                SecondHouse::where('id', $get->id)->update([
                        'phone' => $data[0]['phone'],
                        'community' => $data[0]['community'],
                        'region' => $data[0]['region'],
                        'area' => $data[0]['area'],
                    ]);
            }
            sleep(1);
        }
    }
}
