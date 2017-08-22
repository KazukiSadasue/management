<?php

namespace App\Repositories;

use App\Models\WorkSchedule;
use Carbon\Carbon;
use Session;

class WorkScheduleRepository implements WorkScheduleRepositoryInterface
{
    protected $work_schedule;

    /**
    * @param object $user
    */
    public function __construct(WorkSchedule $work_schedule)
    {
    $this->work_schedule = $work_schedule;
    }

    /**
     * 勤怠データ登録
     *
     * @var array $request
     */
    public function store($request)
    {
        $request['user_id'] = Session::get('id');
        $request['day_at'] = Carbon::createFromDate($request['year'], $request['month'], $request['day']);
        $request['start_at'] = Carbon::createFromTime($request['start_work_hour'], $request['start_work_min']);
        $request['finish_at'] = Carbon::createFromTime($request['finish_work_hour'], $request['finish_work_min']);
        $request['employment'] = implode(',', $request['employment']);
        if ($request['start_at']->gt($request['finish_at'])) {
            \Session::flash('error_message', '勤務時間が正しくありません');
            return redirect("/calendar/" . $request['year'] . "/" . $request['month'] . "/" . $request['day']);
        }

        $this->work_schedule->create($request);
        return redirect("/calendar/" . $request['year'] . "/" . $request['month']);
    }
}