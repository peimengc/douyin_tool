<?php


namespace App\Helpers\DouYin;


use App\Exceptions\Decrypt570Exception;
use GuzzleHttp\Client;
use Arr;

trait Decrypt570
{

    /**
     * @param $url
     * @param string $method
     * @param array $header
     * @return mixed
     * @throws Decrypt570Exception
     */
    public function decryptAndRequet($url,$method='get',$header=[])
    {
        $client = new Client();

        $request = $client->request('GET', '172.24.1.255:46657/mas?url=' . urlencode($url));

        $decryptArr = json_decode($request->getBody()->getContents(), 1);

        if (Arr::get($decryptArr, 'status') !== 1) {
            throw new Decrypt570Exception('解密异常');
        }

        $header = [
                'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 8.1.0; zh_CN; Redmi 6A; Build/O11019; Cronet/58.0.2991.0)',
                'X-Khronos' => Arr::get($decryptArr, 'khronos'),
                'X-Gorgon' => Arr::get($decryptArr, 'gorgon'),
            ] + $header;

        $request = $client->request($method, Arr::get($decryptArr, 'url'), [
            'verify' => false,
            'headers' => $header
        ]);

        return json_decode($request->getBody()->getContents(),1);

    }
}
