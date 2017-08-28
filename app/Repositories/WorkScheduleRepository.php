<?php

namespace App\Repositories;

use App\Models\WorkSchedule;
use Carbon\Carbon;
use Session;
use Yasumi\Yasumi;
use Illuminate\Support\Facades\DB;

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
        $request['start_at'] = Carbon::createFromTime($request['start_work_hour'], $request['start_work_min']);
        $request['finish_at'] = Carbon::createFromTime($request['finish_work_hour'], $request['finish_work_min']);
        $request['employment'] = implode(',', $request['employment']);
        if ($request['update'] == false) {
            $request['user_id'] = Session::get('user')['id'];
            $request['day_at'] = Carbon::createFromDate($request['year'], $request['month'], $request['day']);

            $this->work_schedule->create($request);
            return redirect("/calendar/" . $request['year'] . "/" . $request['month']);
        } else {
            $this->work_schedule->where('id', '=', $request['id'])->first()->update($request);
            return redirect("/calendar/" . $request['year'] . "/" . $request['month']);
        }
    }
    
    /**
     * 勤怠データ登録、承認　（管理者）
     *
     * @var array $request
     */
    public function store_admin($id, $request)
    {
        $request['start_at'] = Carbon::createFromTime($request['start_work_hour'], $request['start_work_min']);
        $request['finish_at'] = Carbon::createFromTime($request['finish_work_hour'], $request['finish_work_min']);
        $request['employment'] = implode(',', $request['employment']);
        if ( !isset( $request['approval'] ) ) {
            $request['approval'] = 0;
        }
        
        if ($request['update'] == false) {
            $request['user_id'] = $id;
            $request['day_at'] = Carbon::createFromDate($request['year'], $request['month'], $request['day']);

            $this->work_schedule->create($request);
            return redirect("/admin/search/" . $id . "/" . $request['year'] . "/" . $request['month']);
        } else {
            $this->work_schedule->where('id', '=', $request['id'])->first()->update($request);
            return redirect("/admin/search/" . $id . "/" . $request['year'] . "/" . $request['month']);
        }
    }

    /**
     * 勤怠データ取得
     *
     * @var int $year
     * @var int $month
     * return array
     */
    public function get_schedule($year, $month)
    {
        $data['first_day'] = Carbon::create($year, $month)->startOfMonth();
        $data['last_day'] = Carbon::create($year, $month)->endOfMonth();
        $data['now_date'] = Carbon::now();
        $data['five_years_ago'] = Carbon::now()->subYear(5);
        $data['after_five_years'] = Carbon::now()->addYear(5);
        
        foreach ( Yasumi::create('Japan', $year, 'ja_JP') as $holiday ) {
            if( $data['first_day']->format('m') == $holiday->format('m') ) {
                $data['holidays'][$holiday->format('d')] = $holiday->getName();
            }
        }

        $schedules = $this->work_schedule->
            join('projects', 'projects.id', '=', 'work_schedules.project_id')->
            where('user_id', '=', Session::get('user')['id'])->
            where('day_at', '>=', $data['first_day'])->
            where('day_at', '<=', $data['last_day'])->
            orderBy('day_at', 'asc')->get();

        foreach ( $schedules as $schedule ) {
            $data['schedules'][$schedule['day_at']] = $schedule;
        }

        return $data;
    }

    /**
     * 勤怠データ取得(管理者側)
     *
     * @var int $year
     * @var int $month
     * @var int $id
     * return array
     */
    public function get_schedule_admin($id, $year, $month)
    {
        $data['first_day'] = Carbon::create($year, $month)->startOfMonth();
        $data['last_day'] = Carbon::create($year, $month)->endOfMonth();
        $data['now_date'] = Carbon::now();
        $data['five_years_ago'] = Carbon::now()->subYear(5);
        $data['after_five_years'] = Carbon::now()->addYear(5);
        $data['id'] = $id;
        
        foreach ( Yasumi::create('Japan', $year, 'ja_JP') as $holiday ) {
            if( $data['first_day']->format('m') == $holiday->format('m') ) {
                $data['holidays'][$holiday->format('d')] = $holiday->getName();
            }
        }

        $schedules = $this->work_schedule->
            join('projects', 'projects.id', '=', 'work_schedules.project_id')->
            where('user_id', '=', $id)->
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
    public function get_entry($year, $month, $day)
    {
        $data['entry'] = $this->work_schedule->where('user_id', '=', Session::get('user')['id'])->where('day_at', '=', $year . '-' . $month . '-' . $day)->first();
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
     * 勤怠入力ページ取得 (管理者)
     *
     * @var int $year
     * @var int $month
     * @var int $day
     * @var int $id
     * return array
     */
    public function get_entry_admin($id, $year, $month, $day)
    {
        $data['entry'] = $this->work_schedule->where('user_id', '=', $id)->where('day_at', '=', $year . '-' . $month . '-' . $day)->first();
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
}