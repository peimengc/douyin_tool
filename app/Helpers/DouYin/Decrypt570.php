<?php


namespace App\Helpers\DouYin;


use App\Exceptions\Decrypt570Exception;
use GuzzleHttp\Client;
use Arr;
use GuzzleHttp\Exception\GuzzleException;

trait Decrypt570
{

    protected $tDecryptArr;//解密后数据

    protected $tHeader;//请求头
    protected $tResponse;//返回内容

    /**
     * @param $url
     * @param string $method
     * @param array $header
     * @return mixed
     * @throws Decrypt570Exception
     */
    public function decryptAndRequet($url, $method = 'get', $header = [])
    {
        $client = new Client();

        try {
            $request = $client->request('GET', '172.24.1.255:46657/mas?url=' . urlencode($url));
        } catch (GuzzleException $e) {
            throw new Decrypt570Exception('解密异常:'.$e->getMessage(),$e->getCode());
        }

        $this->tDecryptArr = json_decode($request->getBody()->getContents(), 1);

        if (Arr::get($this->tDecryptArr, 'status') !== 1) {
            throw new Decrypt570Exception('解密异常:返回信息有误');
        }

        $this->tHeader  = [
                'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 8.1.0; zh_CN; Redmi 6A; Build/O11019; Cronet/58.0.2991.0)',
                'X-Khronos' => Arr::get($this->tDecryptArr, 'khronos'),
                'X-Gorgon' => Arr::get($this->tDecryptArr, 'gorgon'),
            ] + $header;

        $request = $client->request($method, Arr::get($this->tDecryptArr, 'url'), [
            'verify' => false,
            'headers' => $this->tHeader
        ]);

        return $this->tResponse = json_decode($request->getBody()->getContents(), 1);
    }
}
