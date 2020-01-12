<?php


namespace App\Services;


use App\AwemeUser;
use Arr;

class AwemeUserService
{
    /**
     * 根据media.douyin.com的userinfo接口返回信息做添加
     *
     * @param $mediaUserInfo
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function saveByMediaUserInfo($mediaUserInfo)
    {
        $attr = [
            'user_id' => auth()->id(),
            'uid' => Arr::get($mediaUserInfo, 'uid'),
            'unique_id' => Arr::get($mediaUserInfo, 'unique_id'),
            'short_id' => Arr::get($mediaUserInfo, 'short_id'),
            'nick' => Arr::get($mediaUserInfo,'nickname'),
            'avatar_uri' => Arr::get($mediaUserInfo, 'avatar_thumb.url_list.0'),
            'fans' => Arr::get($mediaUserInfo, 'follower_count', 0),
            'follow' => Arr::get($mediaUserInfo, 'following_count', 0),
            'cookie' => Arr::get($mediaUserInfo, 'cookie'),
        ];

        return AwemeUser::query()->updateOrCreate(Arr::only($attr, 'uid'), $attr);
    }

    /**
     * 获取
     * 10个粉丝未到1000
     * cookie正常
     * 的账号，增粉
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed[]
     */
    public function getFollowedAwemeUser()
    {
        return AwemeUser::query()
            ->scopes(['cookie'])
            ->where('fans','<',1000)
            ->limit(10)
            ->get();
    }

    /**
     * 获取所有
     * cookie正常
     * 今日关注未到100
     * 的账号，用于给其他账号增粉
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed[]
     */
    public function getFollowAwemeUser()
    {
        return AwemeUser::query()
            ->scopes(['cookie'])
            ->where('today_follow','<',100)
            ->get();
    }
}
