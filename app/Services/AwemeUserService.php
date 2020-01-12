<?php


namespace App\Services;


use App\AwemeUser;
use Arr;

class AwemeUserService
{
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
}
