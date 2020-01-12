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
}
