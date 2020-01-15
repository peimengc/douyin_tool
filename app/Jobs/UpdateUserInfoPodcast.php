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
    public $timeout = 300;

    /**
     * UpdateUserInfoPodcast constructor.
     * @param MediaQrCodeLogin $mediaQrCodeLogin
     * @param AwemeUser $awemeUser
     */
    public function __construct()
    {
    }

    /**
     * @param MediaQrCodeLogin $mediaQrCodeLogin
     * @param AwemeUserService $awemeUserService
     */
    public function handle(MediaQrCodeLogin $mediaQrCodeLogin,AwemeUserService $awemeUserService)
    {
        $awemeUserService->getSomeToUpdate()->each(function ($awemeUser) use ($mediaQrCodeLogin,$awemeUserService) {
            $awemeUserService->saveByMediaUserInfo(
                $mediaQrCodeLogin->getUserInfoByModel($awemeUser),
                [
                    'update_time' => now()
                ]);
        });
    }
}
