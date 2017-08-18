<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    /**
     * @var int　勤怠タイプ:出勤
     **/
    const WORK_TYPE_START_WORK = 1;
   
    /**
     * @var int　勤怠タイプ:退勤
     **/
    const WORK_TYPE_FINISH_WORK = 2;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'work_time', 'work_type', 
    ];
}
