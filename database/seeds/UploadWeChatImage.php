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
                var_dump($result);
                continue;
            }

            $result['type'] = 3;
            // var_dump(json_encode($result));return;
            $ret = $this->curl_request('http://www.xitou.online/api/image_list/store', $result, []);
            // var_dump($ret);
            if ($ret) {
                try {
                    // copy($dir . $image, 'E:\python_code\image_done\\' . $image);
                    unlink($dir . $image);//删除旧目录下的文件
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                echo 1, "\r\n";
            }
            file_put_contents('result.html', $ret . PHP_EOL, FILE_APPEND);
            file_put_contents('result.csv', $image . PHP_EOL, FILE_APPEND);

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

    //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
    public function curl_request($url,$post='',$cookie='', $returnCookie=0){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }
}
