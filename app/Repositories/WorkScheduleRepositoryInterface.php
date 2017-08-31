<?php

namespace App\Repositories;

interface WorkScheduleRepositoryInterface
{    
    /**
     * 勤怠データ保存
     *
     * @param array $request
     * @param int $id
     * @return void
     */
    public function save($request, $id = null);

    /**
     * 勤怠一覧データ取得
     *
     * @var int $year
     * @var int $month
     * return array
     */
    public function getScheduleList($year, $month);
    
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
     * ajax 月の勤務確認 (管理者)
     *
     * @var int $year
     * @var int $month
     * @var int $day
     * @var int $id
     * return array
     */
    public function calendarAjax();

    /**
     * 詳細検索
     *
     * @param array $request
     * @return void
     */
    public function countSearch($condition);
}