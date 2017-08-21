<?php

namespace App\Repositories;

interface WorkSheetRepositoryInterface
{
    /**
     * 全プロジェクトデータ取得
     *
     * retrun array $projects
     */
    public function get_projects();
    
    /**
     * 勤怠データ登録
     *
     * @var array $request
     * @var int $year
     * @var int $month
     * @var int $day
     */
    public function store($request, $year, $month, $day);
   
}