<?php


namespace App\Helpers\DouYin;


use App\Exceptions\MediaQrCodeCookieException;
use GuzzleHttp\Client;
use Arr;

class MediaQrCodeLogin
{
    protected $getQrCodeUrl = 'https://sso.douyin.com/get_qrcode/?aid=10006';
    protected $checkQrCodeUrl = 'https://sso.douyin.com/check_qrconnect/?aid=10006&token=';
    protected $getUserInfoUrl = 'https://media.douyin.com/web/api/media/user/info/';

    protected $cookie;

    /**
     * 获取登陆二维码
     *
     * @return array
     */
    public function getQrCode()
    {
        return $this->qrCodeRequest();
    }

    /**
     * 验证二维码是否有效，无效返回新的二维码
     *
     * @param $token
     * @return mixed
     */
    public function checkQrCode($token)
    {
        return $this->qrCodeRequest($token);
    }

    /**
     *验证或者获取qrcode
     *
     * @param null $token
     * @return mixed
     */
    protected function qrCodeRequest($token = null)
    {
        $client = new Client();

        $request = $client->request(
            'GET',
            $token ? $this->checkQrCodeUrl . $token : $this->getQrCodeUrl,
            [
                'verify' => false
            ]
        );

        return json_decode($request->getBody()->getContents(), 1);
    }

    /**
     * 请求扫码返回的redirect_url，
     * 重定向两次，第二次有set-cookie
     *
     * @param $redirectUrl
     * @return $this
     * @throws \Exception
     */
    public function getCookie($redirectUrl)
    {

        $client = new Client();

        $request = $client->request(
            'GET',
            $redirectUrl,
            [
                'allow_redirects' => false,//禁止重定向
            ]
        );


        $location = $request->getHeader('location')[0];

        $request = $client->request(
            'GET',
            $location,
            [
                'allow_redirects' => false,//禁止重定向
            ]
        );
        //获取set-cookie并提取sessionid
        if ($this->cookie = $this->formatSetCookie($request->getHeader('set-cookie'))) {
            return $this;
        }

        throw new \Exception('扫码后Cookie获取失败');
    }

    /**
     * 提取sessionid
     * @param $setCookies
     * @return bool|mixed
     */
    protected function formatSetCookie($setCookies)
    {

        foreach ($setCookies as $setCookie) {
            //包含sessionid关键字
            if (strpos($setCookie, 'sessionid') !== false) {

                $cookies = explode(';', $setCookie);

                return $cookies[0];
            }

        }

        return false;
    }

    /**
     * 根据cookie获取userInfo
     * @param $cookie
     * @return mixed
     * @throws \Exception
     * @throws MediaQrCodeCookieException
     */
    public function getUserInfo($cookie = null)
    {
        $cookie = $cookie ?? $this->cookie;

        $client = new Client();

        $request = $client->request(
            'GET',
            $this->getUserInfoUrl,
            [
                'headers' => [
                    'Cookie' => $cookie
                ]
            ]
        );

        $contents = json_decode($request->getBody()->getContents(), 1);

        if (Arr::get($contents, 'status_code') === 8){
            throw new MediaQrCodeCookieException('Cookie失效');
        }

        if (
            Arr::get($contents, 'status_code') === 0
            && $userInfo = Arr::get($contents, 'user')
        ) {
            return $userInfo+compact('cookie');
        }

        throw new \Exception('扫码后用户信息获取失败');
    }
}
