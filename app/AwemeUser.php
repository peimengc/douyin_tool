<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AwemeUser
 * @package App
 */
class AwemeUser extends Model
{
    protected $fillable = [
        'user_id',
        'uid',
        'unique_id',
        'short_id',
        'nick',
        'avatar_uri',
        'fans',
        'follow',
        /*'tool_follow',
        'tool_fans',
        'today_follow',*/
        'cookie',
    ];

    protected $appends = [
        'share_url'
    ];

    //==========================================
    /**
     * cookie可用
     * @param $builder
     */
    public function scopeCookie(Builder $builder)
    {
        $builder->where('cookie', '!=', '');
    }

    //============================================

    //增粉url
    public function addFollowTaskUrl()
    {
        return url('/awemeUsers/'.$this->id.'/followTask');
    }

    //关注别人
    public function follow($num = 1)
    {
        $this->today_follow += $num;
        $this->tool_follow += $num;

        $this->save();
    }

    //被关注
    public function followed($num = 1)
    {
        $this->tool_fans += $num;

        $this->save();
    }

    //========================================

    public function getShareUrlAttribute()
    {
        return 'https://www.iesdouyin.com/share/user/' . $this->uid;
    }

    //======================================
    public function followTasks()
    {
        return $this->hasMany(FollowTask::class);
    }

    public function followTask()
    {
        return $this->hasOne(FollowTask::class)->where('status',1);
    }

    public function followeds()
    {
        return $this->belongsToMany(static::class,'follow_followed','followed_id','follow_id','id','id');
    }

}
