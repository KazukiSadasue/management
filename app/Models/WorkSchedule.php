<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    /**
     * @var int　勤怠タイプ:出勤
     **/
    const TYPE_GO = 1;
    
    /**
     * @var int　勤怠タイプ:午前休
     **/
    const TYPE_AM = 2;
    
    /**
     * @var int　勤怠タイプ:午後休
     **/
    const TYPE_PM = 3;
    
    /**
     * @var int　勤怠タイプ:全休
     **/
    const TYPE_ALL = 4;
   
    
    /**
     * @var int　作業内容:プログラム
     **/
    const PROGRAM = 1;
   
    /**
     * @var int　作業内容:デザイン
     **/
    const DESIGN = 2;
   
    /**
     * @var int　作業内容:仕様
     **/
    const SPEC = 3;
    
    /**
     * @var int　作業内容:テスト
     **/
    const TEST = 4;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'project_id', 'type', 'employment', 'remarks','day_at' , 'start_at', 'finish_at', 'approval',
    ];
}
