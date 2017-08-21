<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSheet extends Model
{
    /**
     * @var int　勤怠タイプ:出勤
     **/
    const WORK_TYPE_GO = 1;
    
    /**
     * @var int　勤怠タイプ:午前休
     **/
    const WORK_TYPE_AM = 2;
    
    /**
     * @var int　勤怠タイプ:午後休
     **/
    const WORK_TYPE_PM = 3;
    
    /**
     * @var int　勤怠タイプ:全休
     **/
    const WORK_TYPE_ALL = 4;
   
    
    /**
     * @var int　作業内容:プログラム
     **/
    const WORK_DATA_PROGRAM = 1;
   
    /**
     * @var int　作業内容:デザイン
     **/
    const WORK_DATA_DESIGN = 2;
   
    /**
     * @var int　作業内容:仕様
     **/
    const WORK_DATA_SPEC = 3;
    
    /**
     * @var int　作業内容:テスト
     **/
    const WORK_DATA_TEST = 4;
   
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'project_id', 'work_type', 'work_data', 'remarks', 'start_work', 'finish_work', 'approval'
    ];
}
