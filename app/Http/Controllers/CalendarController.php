<?php 

namespace App\Http\Controllers;

use App\Repositories\WorkScheduleRepositoryInterface;
use App\Http\Requests\WorkSchedulePost;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function __construct(WorkScheduleRepositoryInterface $work_schedule_repository)
    {
        $this->work_schedule_repository = $work_schedule_repository;
    }

    /**
     * 日付一覧トップ
     */
    public function index()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        return redirect("/calendar/${year}/${month}");
    }
    
    /**
     * 日付一覧ページ
     */
    public function list($year, $month)
    {
        $data = $this->work_schedule_repository->get_schedule($year, $month);

        return view('calendar', [
            'data' => $data
        ]);
    }

    /**
     * 勤怠記入ページ
     */
    public function entry($year, $month, $day)
    {
        $data = $this->work_schedule_repository->get_entry($year, $month, $day);

        return view('work_schedule', [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'data' => $data,
        ]);
    }

    /**
     * 勤怠登録
     */
    public function store(WorkSchedulePost $request)
    {
        return $this->work_schedule_repository->store($request->all());
    }
}