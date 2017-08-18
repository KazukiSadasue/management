<?php

namespace App\Repositories;

use App\Models\History;
use Session;
use Response;
use Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class HistoryRepository implements HistoryRepositoryInterface
{
    protected $history;

    /**
    * @param object $history
    */
    public function __construct(History $history)
    {
    $this->history = $history;
    }

    /**
     * 勤務開始（Ajax:1=すでに出勤済み 2=出勤しました 3=退勤してません)
     *
     */
    public function start()
    {

        //一番新しい勤怠タイプが[出勤]だったら、すでに出勤済み
        $history = $this->history->where('user_id', '=', Session::get('id'))->orderBy('created_at', 'desc')->first();
        if ($history['work_type'] == History::WORK_TYPE_START_WORK){
            return Response::make(Config::get('const.WORK_TYPE')['DONE']);
        }

        //勤怠履歴があり、一番新しい勤怠タイプが[退勤]だったら、一番新しい[出勤]の時間を比較
        //一番新しい出勤時間が「今日」だったら、すでに出勤済み
        $history = $this->history->where('user_id', '=', Session::get('id'))->orderBy('created_at', 'desc')->where('work_type', '=', History::WORK_TYPE_START_WORK)->first();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        if( isset($history['work_time']) ){
            $work_time = new Carbon($history['work_time']);
            if ($work_time->between($today,$tomorrow)) {
                return Response::make(Config::get('const.WORK_TYPE')['DONE']);
            }
        }

        $data['user_id'] = Session::get('id');
        $data['work_type'] = History::WORK_TYPE_START_WORK;
        $data['work_time'] = Carbon::createFromTimestamp( Input::get('work_time') );
        $this->history->create($data);
        return Response::make(Config::get('const.WORK_TYPE')['DO']);
    }
    
    /**
     * 勤務終了（Ajax:1=すでに退勤済み 2=退勤しました 3=出勤してません)
     *
     */
    public function finish()
    {
        $data['user_id'] = Session::get('id');
        $data['work_type'] = History::WORK_TYPE_FINISH_WORK;
        
        //一番新しい勤怠タイプが[退勤]だったら、すでに退勤済み
        $history = $this->history->where('user_id', '=', Session::get('id'))->orderBy('created_at', 'desc')->first();
        if ($history['work_type'] == History::WORK_TYPE_FINISH_WORK) {
            return Response::make(Config::get('const.WORK_TYPE')['DONE']);
        }

        //一回も出勤した記録がなかったら、出勤してません
        if ( !isset($history['work_time']) ) {
            return Response::make(Config::get('const.WORK_TYPE')['DONT']);
        }

        $data['work_time'] = Carbon::createFromTimestamp( Input::get('work_time') );
        $this->history->create($data);
        return Response::make(Config::get('const.WORK_TYPE')['DO']);
    }

    /**
     * 履歴取得
     *
     */
    public function history()
    {
        $histories = $this->history->where('user_id', '=', Session::get('id'))->orderBy('id', 'desc')->paginate(15);
        return view('mypage', ['histories' => $histories]);
    }

}