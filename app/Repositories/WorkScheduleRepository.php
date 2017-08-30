<?php

namespace App\Repositories;

use App\Models\WorkSchedule;
use Carbon\Carbon;
use Session;
use Yasumi\Yasumi;
use Illuminate\Support\Facades\DB;
use Response;
use Input;

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
     * 勤怠データ保存
     *
     * @param array $request
     * @param int $id
     * @return void
     */
    public function save($request, $id = null)
    {
        $request['start_at'] = Carbon::createFromTime($request['start_work_hour'], $request['start_work_min']);
        $request['finish_at'] = Carbon::createFromTime($request['finish_work_hour'], $request['finish_work_min']);
        $request['employment'] = implode(',', $request['employment']);
        if ( !isset( $request['approval'] ) ) {
            $request['approval'] = 0;
        }
        if ($request['update'] == false) {
            $this->create($request, $id);
        } else {
            $this->update($request);
        }
    }

    /**
     * 勤怠データ作成
     *
     * @param array $request
     * @param int $id
     * @return void
     */
    private function create($request, $id)
    {
        $request['user_id'] = is_null($id) ? Session::get('user')['id'] : $id;
        $request['day_at'] = Carbon::createFromDate($request['year'], $request['month'], $request['day']);

        $this->work_schedule->create($request);
    }
    
    /**
     * 勤怠データ更新
     *
     * @param array $request
     * @return void
     */
    private function update($request)
    {
        $this->work_schedule->where('id', '=', $request['id'])->first()->update($request);
    }

    /**
     * 勤怠データ登録
     *
     * @var array $request
     */
    


    /**
     * 勤怠データ取得
     *
     * @var int $year
     * @var int $month
     * return array
     */
    public function getScheduleList($year, $month, $id = null)
    {
        $data['first_day'] = Carbon::create($year, $month)->startOfMonth();
        $data['last_day'] = Carbon::create($year, $month)->endOfMonth();
        $data['now_date'] = Carbon::now();
        $data['five_years_ago'] = Carbon::now()->subYear(5);
        $data['after_five_years'] = Carbon::now()->addYear(5);
        $data['id'] = is_null($id) ? Session::get('user')['id'] : $id;
        
        foreach ( Yasumi::create('Japan', $year, 'ja_JP') as $holiday ) {
            if( $data['first_day']->format('m') == $holiday->format('m') ) {
                $data['holidays'][$holiday->format('d')] = $holiday->getName();
            }
        }
        $schedules = $this->work_schedule->
            join('projects', 'projects.id', '=', 'work_schedules.project_id')->
            where('user_id', '=', $data['id'])->
            where('day_at', '>=', $data['first_day'])->
            where('day_at', '<=', $data['last_day'])->
            orderBy('day_at', 'asc')->get();

        foreach ( $schedules as $schedule ) {
            $data['schedules'][$schedule['day_at']] = $schedule;
        }

        return $data;
    }

    /**
     * 勤怠入力ページ取得
     *
     * @var int $year
     * @var int $month
     * @var int $day
     * return array
     */
    public function getSchedule($year, $month, $day, $id = null)
    {
        $data['entry'] = $this->work_schedule
        ->where('user_id', '=', is_null($id) ? Session::get('user')['id'] : $id)
        ->where('day_at', '=', $year . '-' . $month . '-' . $day)->first();
        $data['projects'] = DB::table('projects')->get();
        
        $data['update'] = false; //true:更新処理 false:新規作成
        if ( isset($data['entry']) ) {
            $data['update'] = true;
        }

        foreach ( explode( ',', $data['entry']['employment'] ) as $employment ) {
            $data['employment'][$employment] = $employment;
        }
        return $data;
    }
    
    /**
     * ajax 月の勤務確認 (管理者)
     *
     * @var int $year
     * @var int $month
     * @var int $id
     * return array
     */
    public function calendarAjax()
    {
        $first_day = Carbon::create(Input::get('year'), Input::get('month'))->startOfMonth()->format('Y-m-d');
        $last_day = Carbon::create(Input::get('year'), Input::get('month'))->endOfMonth()->format('Y-m-d');
        
        $users = $this->work_schedule
        ->join('users', 'users.id', '=', 'work_schedules.user_id')
        ->select('user_id', 'name')->distinct()
        ->where('day_at', '>=', $first_day)
        ->where('day_at', '<=', $last_day)->get();

        return Response::make($users);
    }

    /**
     * 詳細検索
     *
     * @param array $request
     * @return void
     */
    public function search($condition)
    {
        $work_schedules = $this->work_schedule
            ->select('name', DB::raw('COUNT(*) as target'))
            ->join('users', 'users.id', '=', 'work_schedules.user_id');
        
        if( isset($condition['start_date']) ){
            $work_schedules = $work_schedules->where('day_at', '>=', $condition['start_date']);
        }
        if( isset($condition['end_date']) ){
            $work_schedules = $work_schedules->where('day_at', '<=', $condition['end_date']);
        }
        if( isset($condition['project_id']) ){
            $work_schedules = $work_schedules->where('project_id', '=', $condition['project_id']);
        }

        $data['work_schedules'] = $work_schedules->groupBy('name')->get();

        $projects = DB::table('projects')->get();
        foreach ($projects as $project) {
            $data['projects'][$project->id] = $project->project_name;
        }

        \Log::error($data);
        return $data;
    }
}