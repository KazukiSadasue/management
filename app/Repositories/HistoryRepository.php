<?php

namespace App\Repositories;

use App\Models\History;
use Session;
use Response;
use Input;
use Carbon\Carbon;

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
     * 勤務開始
     *
     */
    public function start()
    {
        // $condition = Input::get('work_time');
        // \Log::error(print_r($condition,true));

        $data['user_id'] = Session::get('id');
        $data['work_type'] = History::WORK_TYPE_START_WORK;

        $history = $this->history->where('user_id', '=', Session::get('id'))->orderBy('id', 'desc')->first();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        if( isset($history['work_time']) ){
            $work_time = new Carbon($history['work_time']);
            if ($work_time->between($today,$tomorrow)) {
                return Response::make('true');
            }
            else{
                $data['work_time'] = Carbon::createFromTimestamp( Input::get('work_time') )->toDateTimeString();   
                \Log::error(Input::get('work_time'));
                \Log::error($data['work_time']);
                $this->history->create($data);
                return Response::make('false');
            }
        }
        
        if ($history['work_type'] == History::WORK_TYPE_START_WORK){
            return Response::make('true');
        }
        $data['work_time'] = Carbon::createFromTimestamp( Input::get('work_time') );
        \Log::error(Input::get('work_time'));
        \Log::error($data['work_time']);
        $this->history->create($data);
        \Log::error('aaaaaaaaaaaaaaaaaaaa');
        return Response::make('false');
    }
    
    /**
     * 勤務終了
     *
     */
    public function finish()
    {
        $data['user_id'] = Session::get('id');
        $data['work_type'] = History::WORK_TYPE_FINISH_WORK;

        $histories = $this->history->where('user_id', '=', Session::get('id'))->orderBy('id', 'desc');
        
        $history = $histories->where('work_type', '=', History::WORK_TYPE_FINISH_WORK)->first();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        if (isset($history['work_time'])) {
            $work_time = new Carbon($history['work_time']);
            if ($work_time->between($today,$tomorrow)){
                return Response::make('true');
            }
            else{
                $this->history->create($data);
                return Response::make('false');
            }
        }        
        
        $history = $histories->first();
        if ($history['work_type'] == History::WORK_TYPE_FINISH_WORK ){
            return Response::make('true');
        }

        $this->history->create($data);
        return Response::make('false');
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