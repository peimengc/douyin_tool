<?php


namespace App\Helpers\DouYin;


use App\Events\AwemeUserFollowError;
use App\Events\AwemeUserFollowSuccess;

class FollowUserHelper
{
    use Decrypt570;

    protected $followUserUrl = 'https://api.amemv.com/aweme/v1/commit/follow/user/?user_id=%s&type=1&channel_id=1&from=0&retry_type=no_retry&iid=97651225365&device_id=66865915362&ac=wifi&channel=wandoujia_aweme1&aid=1128&app_name=aweme&version_code=570&version_name=5.7.0&device_platform=android&ssmix=a&device_type=Redmi+6A&device_brand=xiaomi&language=zh&os_api=27&os_version=8.1.0&openudid=3b16bece99db59ec&manifest_version_code=570&resolution=720*1344&dpi=320&update_version_code=5702&_rticket=1578105905331&mcc_mnc=46011&ts=1578105904&js_sdk_version=1.13.10&as=a1856fd0d0837eacbf6299&cp=f734e45b03f103c2e1IoQs&mas=012800b0740eb04177e4f30a8a3e5001439c9c4c6c6646c686a6ec';

    public function followUsers($followTasks, $followAwemeUsers)
    {
        if ($followTasks->isEmpty() || $followAwemeUsers->isEmpty()) {
            return;
        }

        foreach ($followTasks as $followTask) {
            $this->followUser($followTask, $followAwemeUsers);
        }
    }

    public function followUser($followTask, $followAwemeUsers)
    {
        foreach ($followAwemeUsers as $followAwemeUser) {
            //关注
            $this->followUserRequest($followTask, $followAwemeUser);
        }
    }

    /**
     *follow_status : 4 私密账号
     *follow_status : 2 已关注
     *
     * @param $followTask
     * @param $followAwemeUser
     * @throws \App\Exceptions\Decrypt570Exception
     */
    protected function followUserRequest($followTask, $followAwemeUser)
    {
        dump(sprintf($this->followUserUrl, $followTask->awemeUser->uid));
        $followResponse = $this->decryptAndRequet(
            sprintf($this->followUserUrl, $followTask->awemeUser->uid),
            'get',
            [
                'Cookie' => $followAwemeUser->cookie
            ]
        );
        echo json_encode($this->tDecryptArr);
        dd($this->tDecryptArr,$this->tHeader,$this->tResponse);
        //关注成功/失败
        if (
            (isset($followResponse['is_enterprise'])
                && $followResponse['status_code'] === 0)
            || $followResponse['follow_status'] === 4
        ) {

            event(new AwemeUserFollowSuccess($followTask, $followAwemeUser, $followResponse));
        } else {

            event(new AwemeUserFollowError($followTask, $followAwemeUser, $followResponse));
        }
    }
}
