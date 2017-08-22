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
   
}