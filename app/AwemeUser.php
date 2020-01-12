<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'cookie',*/
    ];

}
