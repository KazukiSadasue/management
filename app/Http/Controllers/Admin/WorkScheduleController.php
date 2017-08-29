<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\WorkScheduleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\WorkSchedulePost;

class WorkScheduleController extends Controller
{
    public function __construct(WorkScheduleRepositoryInterface $work_schedule_repository,
                                UserRepositoryInterface $user_repository)
    {
        $this->work_schedule_repository = $work_schedule_repository;
        $this->user_repository = $user_repository;
    }
    /**
     * ユーザー検索
     */
    public function search($id = 1, $year = 2017, $month = 8)
    {
        $data = $this->work_schedule_repository->getScheduleListAdmin($id, $year, $month);
        $users = $this->user_repository->getUser();
        return view('search_list', [
            'data' => $data,
            'users' => $users,
        ]);
    }

    /**
     * スケジュール編集
     */
    public function edit($id, $year, $month, $day)
    {
        $data = $this->work_schedule_repository->getScheduleAdmin($id, $year, $month, $day);
        return view('admin_edit', [
            'id' => $id,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'data' => $data,
        ]);
    }

    /**
     * スケジュール変更、承認
     */
    public function store(WorkSchedulePost $request, $id)
    {
        return $this->work_schedule_repository->store($request->all(), $id);
    }
    
    /**
     * ajax 月の勤怠チェック
     */
    public function searchAjax()
    {
        return $this->work_schedule_repository->searchAjax();
    }
}