<?php


namespace App\Helpers\DouYin;


use App\Events\AwemeUserFollowError;
use App\Events\AwemeUserFollowSuccess;

class FollowUserHelper
{
    use Decrypt570;

    protected $followUserUrl = 'https://aweme.snssdk.com/aweme/v1/commit/follow/user/?user_id=%s&type=1&channel_id=3&from=0&retry_type=no_retry&iid=98491914327&device_id=66865915362&ac=wifi&channel=wandoujia_aweme1&aid=1128&app_name=aweme&version_code=570&version_name=5.7.0&device_platform=android&ssmix=a&device_type=Redmi+6A&device_brand=xiaomi&language=zh&os_api=27&os_version=8.1.0&openudid=3b16bece99db59ec&manifest_version_code=570&resolution=720*1344&dpi=320&update_version_code=5702&_rticket=1578812999168&mcc_mnc=46011&ts=1578812998&js_sdk_version=1.13.10&as=a1552c6136b44e661a8499&cp=cd4de65764a71065e1OkWo&mas=01169ebe22115681164f124de8fcb17b589c9c2c1c868c6c6ca62c';

    public function followUsers($followedAwemeUsers, $followAwemeUsers)
    {
        foreach ($followedAwemeUsers as $followedAwemeUser) {
            $this->followUser($followedAwemeUser, $followAwemeUsers);
        }
    }

    public function followUser($followedAwemeUser, $followAwemeUsers)
    {
        foreach ($followAwemeUsers as $followAwemeUser) {
            //自己
            if ($followAwemeUser->uid === $followedAwemeUser->uid) {
                continue;
            }
            //关注
            $this->followUserRequest($followedAwemeUser, $followAwemeUser);
        }
    }

    /**
     *follow_status : 4 私密账号
     *follow_status : 2 已关注
     *
     * @param $followedAwemeUser
     * @param $followAwemeUser
     * @throws \App\Exceptions\Decrypt570Exception
     */
    protected function followUserRequest($followedAwemeUser, $followAwemeUser)
    {
        $followResponse = $this->decryptAndRequet(
            sprintf($this->followUserUrl, $followedAwemeUser->uid),
            'get',
            [
                'Cookie' => $followAwemeUser->cookie
            ]
        );

        //关注成功/失败
        if (isset($followResponse['is_enterprise'])
            && $followResponse['status_code'] === 0) {

            event(new AwemeUserFollowSuccess($followedAwemeUser, $followAwemeUser, $followResponse));
        } else {

            event(new AwemeUserFollowError($followedAwemeUser, $followAwemeUser, $followResponse));
        }
    }
}
