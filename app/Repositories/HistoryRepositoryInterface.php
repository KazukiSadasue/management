<?php

namespace App\Repositories;

interface HistoryRepositoryInterface
{
    /**
     * 勤務開始
     *
     */
    public function start();
    
    /**
     * 勤務終了
     *
     */
    public function finish();
    
    /**
     * 履歴取得
     *
     */
    public function history();
   
}