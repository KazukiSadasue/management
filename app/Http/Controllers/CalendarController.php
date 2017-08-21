<?php 

namespace App\Http\Controllers;

use App\Repositories\WorkSheetRepositoryInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yasumi\Yasumi;

class CalendarController extends Controller
{
    public function __construct(WorkSheetRepositoryInterface $work_sheet_repository)
    {
        $this->work_sheet_repository = $work_sheet_repository;
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

        \Log::error(Config::get('const.WEEKDAY')[Carbon::now()->dayOfWeek]);

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
    public function view($year, $month, $day)
    {
        $projects = $this->work_sheet_repository->get_projects();
        return view('work_sheet', [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'projects' => $projects,
        ]);
    }
    
    /**
     * 勤怠登録
     */
    public function store(Request $request)
    {
        $this->work_sheet_repository->store($request->all());
        return redirect('/calendar');
    }
}