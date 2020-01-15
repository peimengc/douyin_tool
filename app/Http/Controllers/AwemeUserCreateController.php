<?php

namespace App\Http\Controllers;

use App\Helpers\DouYin\MediaQrCodeLogin;
use App\Services\AwemeUserService;
use Illuminate\Http\Request;

class AwemeUserCreateController extends Controller
{
    protected $mediaQrCodeLogin;

    public function __construct(MediaQrCodeLogin $mediaQrCodeLogin)
    {
        $this->mediaQrCodeLogin = $mediaQrCodeLogin;
    }

    public function getQrCode()
    {
        return $this->mediaQrCodeLogin->getQrCode();
    }

    public function checkQrCode($token = null)
    {
        if ($token) {
            return $this->mediaQrCodeLogin->checkQrCode($token);
        } else {
           return $this->mediaQrCodeLogin->getQrCode();
        }
    }

    public function getUserInfo(Request $request,AwemeUserService $awemeUserService)
    {
        $userInfo = $this->mediaQrCodeLogin
            ->setCookie($request->query('redirect_url'))
            ->getUserInfo();

        $awemeUser = $awemeUserService->saveByMediaUserInfo($userInfo,[
            'cookie' => $this->mediaQrCodeLogin->getCookie()
        ]);

        return [
            'error_code'=>0,
            'data' => $awemeUser->toArray(),
        ];
    }
}
