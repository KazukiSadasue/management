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
     * 勤怠データ登録、承認　（管理者）
     *
     * @var array $request
     */
    public function storeAdmin($id, $request);
    
    /**
     * 勤怠一覧データ取得
     *
     * @var int $year
     * @var int $month
     * return array
     */
    public function getScheduleList($year, $month);

    /**
     * 勤怠データ取得(管理者側)
     *
     * @var int $year
     * @var int $month
     * @var int $id
     * return array
     */
    public function getScheduleListAdmin($id, $year, $month);
    
    /**
     * 勤怠入力ページ取得
     *
     * @var int $year
     * @var int $month
     * @var int $day
     * return array
     */
    public function getSchedule($year, $month, $day);
    
    /**
     * 勤怠入力ページ取得 (管理者)
     *
     * @var int $year
     * @var int $month
     * @var int $day
     * @var int $id
     * return array
     */
    public function getScheduleAdmin($id, $year, $month, $day);

    /**
     * ajax 月の勤務確認 (管理者)
     *
     * @var int $year
     * @var int $month
     * @var int $day
     * @var int $id
     * return array
     */
    public function searchAjax();
}