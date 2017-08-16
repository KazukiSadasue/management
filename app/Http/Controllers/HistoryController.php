<?php 

namespace App\Http\Controllers;

use App\Repositories\HistoryRepositoryInterface;
use Session;

class HistoryController extends Controller
{
    public function __construct(HistoryRepositoryInterface $history_repository)
    {
        $this->history_repository = $history_repository;
    }

    /**
     * 勤務開始
     */
    public function start()
    {
        if (Session::has('id'))
        {
            return $this->history_repository->start();     
        }
        \Session::flash('error_message', 'ログインしてください');
        return redirect('login');   
    }
    
    /**
     * 勤務終了
     */
    public function finish()
    {
        if (Session::has('id'))
        {
            return $this->history_repository->finish();     
        }
        \Session::flash('error_message', 'ログインしてください');
        return redirect('login');   
    }
    
    /**
     * マイページ
     */
    public function mypage()
    {
        if (Session::has('id'))
        {
            return $this->history_repository->history();        
        }
        \Session::flash('error_message', 'ログインしてください');
        return redirect('login');   
    }
    
}