<?php


namespace App\Services;


use App\AwemeUser;
use App\FollowTask;
use Arr;
use Illuminate\Database\Eloquent\Builder;

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
            'nick' => Arr::get($mediaUserInfo, 'nickname'),
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
            ->with(['followTask', 'followeds'])
            ->scopes(['cookie'])
            ->has('followTask')
            ->limit(1)
            ->get();
    }

    /**
     * 获取所有
     * cookie正常
     * 今日关注未到100
     * 的账号，用于给其他账号增粉
     *
     * @param FollowTask $followTask
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|mixed[]
     */
    public function getFollowAwemeUser(FollowTask $followTask)
    {
        return AwemeUser::query()
            ->scopes(['cookie'])
            ->where('today_follow', '<', 100)
            ->whereNotIn('id', $followTask->awemeUser->followeds->pluck('id')->push($followTask->awemeUser->id))
            ->inRandomOrder()
            ->limit($followTask->rel_target_fans)
            ->get();
    }

    public function paginate($perPage = null, $columns = ['*'])
    {
        return AwemeUser::query()
            ->with(['followTask'])
            ->when(request('keywords'), function (Builder $builder, $keywords) {
                $builder->where(function (Builder $builder) use ($keywords) {
                    if (is_string($keywords)) {
                        $builder->where('nick', 'like', "%{$keywords}%")
                            ->orWhere('unique_id', 'like', "%{$keywords}%");
                    } else {
                        $builder->where('uid', $keywords)->orWhere('short_id', $keywords);
                    }
                });
            })
            ->when(request('user_id'), function (Builder $builder, $user_id) {
                $builder->where('user_id', $user_id);
            })
            ->paginate($perPage, $columns);
    }

    public function findAndNotTask($awemeUserId)
    {
        return AwemeUser::query()
            ->whereDoesntHave('followTasks', function (Builder $builder) {
                $builder->where('status', 1);
            })
            ->findOrFail($awemeUserId);
    }

    public function todayFollowZero()
    {
        AwemeUser::query()->update([
            'today_follow' => 0
        ]);
    }
}
