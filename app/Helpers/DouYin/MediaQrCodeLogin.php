<?php


namespace App\Helpers\DouYin;


use App\AwemeUser;
use App\Events\AwemeUserCookieInvalid;
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
    public function setCookie($redirectUrl)
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

    //获取cookie
    public function getCookie($redirectUrl = null)
    {
        return $redirectUrl ? $this->setCookie($redirectUrl)->cookie : $this->cookie;
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

    //根据cookie获取userInfo
    public function getUserInfo($cookie = null)
    {
        $cookie = $cookie ?? $this->cookie;

        $contents = $this->geUserInfoContentsByCookie($cookie);

        if ($this->cookieInvalid($contents)){
            throw new MediaQrCodeCookieException('Cookie失效');
        }
        //提取userinfo
        return $this->abstractUserInfoByContent($contents);
    }

    //根据数据库的抖音账号数据获取userInfo
    public function getUserInfoByModel(AwemeUser $awemeUser)
    {
        $contents = $this->geUserInfoContentsByCookie($awemeUser->cookie);

        if ($this->cookieInvalid($contents)){
            //触发cookie失效事件
            event(new AwemeUserCookieInvalid($awemeUser));
        }

        return $this->abstractUserInfoByContent($contents);
    }

    //cookie是否无效
    protected function cookieInvalid($contents)
    {
        return Arr::get($contents, 'status_code') === 8;
    }

    //根据cookie获取contents
    protected function geUserInfoContentsByCookie($cookie)
    {
        $client = new Client();

        $request = $client->request(
            'GET',
            $this->getUserInfoUrl,
            [
                'headers' => [
                    'Cookie' => ($cookie instanceof AwemeUser) ? $cookie->cookie : $cookie
                ]
            ]
        );

        return json_decode($request->getBody()->getContents(), 1);
    }

    //从抖音的response中提取userInfo
    protected function abstractUserInfoByContent($contents)
    {
        if (
            Arr::get($contents, 'status_code') === 0
            && $userInfo = Arr::get($contents, 'user')
        ) {
            return $userInfo;
        }

        throw new \Exception('用户信息获取失败');
    }
}
