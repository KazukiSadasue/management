<?php 

namespace App\Http\Controllers;

use App\Repositories\WorkScheduleRepositoryInterface;
use App\Http\Requests\WorkSchedulePost;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Yasumi\Yasumi;
use Illuminate\Support\Facades\DB;

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
        
        $first_day = Carbon::create($year, $month)->startOfMonth();
        $last_day = Carbon::create($year, $month)->endOfMonth();
        $now_date = Carbon::now();
        $five_years_ago = Carbon::now()->subYear(5);
        $after_five_years = Carbon::now()->addYear(5);
        $holidays = Yasumi::create('Japan', $year, 'ja_JP');

        return view('calendar', [
            'first_day' => $first_day,
            'last_day' => $last_day,
            'five_years_ago' => $five_years_ago,
            'after_five_years' => $after_five_years,
            'holidays' => $holidays,
        ]);
    }

    /**
     * 勤怠記入ページ
     */
    public function entry_page_show($year, $month, $day)
    {
        $projects = DB::table('projects')->get();
        return view('work_schedule', [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'projects' => $projects,
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