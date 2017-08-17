<?php 

namespace App\Http\Controllers;

use App\Repositories\HistoryRepositoryInterface;
use Session;
use Response;

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
        return $this->history_repository->start();
    }
    
    /**
     * 勤務終了
     */
    public function finish()
    {
        return $this->history_repository->finish();     
    }
    
    /**
     * マイページ
     */
    public function mypage()
    {
        return $this->history_repository->history();        
    }
    
}