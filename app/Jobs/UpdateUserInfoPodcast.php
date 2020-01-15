<?php

namespace App\Jobs;

use App\AwemeUser;
use App\Helpers\DouYin\MediaQrCodeLogin;
use App\Services\AwemeUserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserInfoPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $awemeUser;

    /**
     * UpdateUserInfoPodcast constructor.
     * @param MediaQrCodeLogin $mediaQrCodeLogin
     * @param AwemeUser $awemeUser
     */
    public function __construct(AwemeUser $awemeUser)
    {
        $this->awemeUser = $awemeUser;
    }

    /**
     * @param MediaQrCodeLogin $mediaQrCodeLogin
     * @param AwemeUserService $awemeUserService
     * @throws \App\Exceptions\MediaQrCodeCookieException
     */
    public function handle(MediaQrCodeLogin $mediaQrCodeLogin,AwemeUserService $awemeUserService)
    {
        $awemeUserService->saveByMediaUserInfo($mediaQrCodeLogin->getUserInfo($this->awemeUser->cookie));
    }
}
