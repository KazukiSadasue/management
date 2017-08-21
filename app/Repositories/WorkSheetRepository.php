<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\WorkSheet;
use Carbon\Carbon;
use Session;

class WorkSheetRepository implements WorkSheetRepositoryInterface
{
    protected $project;
    protected $work_sheet;

    /**
    * @param object $user
    */
    public function __construct(Project $project, WorkSheet $work_sheet)
    {
    $this->project = $project;
    $this->work_sheet = $work_sheet;
    }

    /**
     * 全プロジェクトデータ取得
     *
     * retrun array $projects
     */
    public function get_projects()
    {
        return $this->project->all();
    }

    /**
     * 勤怠データ登録
     *
     * @var array $request
     */
    public function store($request)
    {
        $request['user_id'] = Session::get('id');
        return $this->work_sheet->create($request);
    }
}