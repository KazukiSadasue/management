<?php

namespace App\Repositories;

use App\Models\History;
use Session;

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
        $data['user_id'] = Session::get('id');
        $data['work_type'] = 1;
        $user = $this->history->where('user_id', '=', Session::get('id'))->orderBy('id', 'desc')->first();
        if ($user['work_type'] == 1)
        {
            \Session::flash('error_message', 'すでに出勤済みです');
            return redirect('mypage');
        }
        $this->history->create($data);
        return redirect('mypage');
    }
    
    /**
     * 勤務終了
     *
     */
    public function finish()
    {
        $data['user_id'] = Session::get('id');
        $data['work_type'] = 2;
        $user = $this->history->where('user_id', '=', Session::get('id'))->orderBy('id', 'desc')->first();
        if ($user['work_type'] == 2 )
        {
            \Session::flash('error_message', 'すでに退勤済みです');
            return redirect('mypage');
        }
        $this->history->create($data);
        return redirect('mypage');
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