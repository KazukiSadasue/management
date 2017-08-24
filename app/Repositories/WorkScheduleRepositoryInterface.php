<?php

namespace App\Repositories;

interface WorkScheduleRepositoryInterface
{    
    /**
     * 勤怠データ登録
     *
     * @var array $request
     */
    public function store($request);
    
    /**
     * 勤怠一覧データ取得
     *
     * @var int $year
     * @var int $month
     * return array
     */
    public function get_schedule($year, $month);
    
    /**
     * 勤怠入力ページ取得
     *
     * @var int $year
     * @var int $month
     * @var int $day
     * return array
     */
    public function get_entry($year, $month, $day);
}