<?php

use Illuminate\Database\Seeder;

class UploadWeChatImage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dir = 'E:\python_code\images\\';
        $images = scandir($dir);

        $app = app('wechat.official_account');
        foreach ($images as $image) {
            if (!is_file($dir . $image)) {
                continue;
            }

            $result = $app->material->uploadImage($dir . $image);
            if (!isset($result['media_id'])) {
                break;
            }

            $result['type'] = 2;
            // var_dump(json_encode($result));return;
            $ret = $this->post('http://www.xitou.online/api/image_list/store', json_encode($result), []);
            // var_dump($ret);
            if ($ret) {

                echo 1, "\r\n";
            }
            file_put_contents('result.html', $ret, FILE_APPEND);
        }


        /*{
           "media_id":MEDIA_ID,
           "url":URL
        }*/
    }

    public function post(string $url, string $data, array $headers
        , string $certFileName = '', string $keyFileName = ''): string
    {
        $curl = curl_init($url);

        //设置超时
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (count($headers) != 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        if ($certFileName != '' && $keyFileName != '') {
            curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($curl, CURLOPT_SSLCERT, $certFileName);
            curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($curl, CURLOPT_SSLKEY, $keyFileName);
        }

        $res = curl_exec($curl);

        if ($res === false || curl_errno($curl)) {

            return $res;
        }

        curl_close($curl);
        return $res;
    }
}
