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
     */
    public function store($request);
   
}