<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowTask extends Model
{
    protected $fillable = [
        'target_fans',
        /*'aweme_user_id',
        'init_follow',
        'init_fans',
        'over_follow',
        'over_fans',
        'add_fans',
        'status',*/
    ];

    public function awemeUser()
    {
        return $this->belongsTo(AwemeUser::class);
    }

    public function followed($num = 1)
    {
        $this->add_fans += $num;

        if ($this->add_fans >= $this->target_fans){
            $this->status = 2;

            //TODO 触发增粉任务完成事件
        }

        $this->save();
    }
}
