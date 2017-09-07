<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\WorkScheduleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\WorkSchedulePost;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class WorkScheduleController extends Controller
{
    public function __construct(WorkScheduleRepositoryInterface $work_schedule_repository,
                                UserRepositoryInterface $user_repository)
    {
        $this->work_schedule_repository = $work_schedule_repository;
        $this->user_repository = $user_repository;
    }
    /**
     * ユーザーカレンダー表示
     */
    public function calendar($id = null, $year = null, $month = null)
    {
        if ($year == null) {
            $year = Carbon::now()->year;
        }
        if ($month == null) {
            $month = Carbon::now()->month;
        }
        $data = $this->work_schedule_repository->getScheduleList($year, $month, $id);
        $users = $this->user_repository->getUser();
        return view('/admin/calendar', [
            'data' => $data,
            'users' => $users,
        ]);
    }

    /**
     * スケジュール編集
     */
    public function workSchedule($id, $year, $month, $day)
    {
        $data = $this->work_schedule_repository->getSchedule($year, $month, $day, $id);
        return view('/admin/work_schedule', [
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
    public function save(WorkSchedulePost $request, $id)
    {
        $this->work_schedule_repository->save($request->all(), $id);
        return redirect("/admin/calendar/" . $id . "/" . $request['year'] . "/" . $request['month']);
    }
    
    /**
     * ajax 月の勤怠チェック
     */
    public function calendarAjax()
    {
        return $this->work_schedule_repository->calendarAjax();
    }

    /**
     * 詳細検索
     *
     * @return void
     */
    public function search(Request $request)
    {
        $conditions = $request->all();

        $data = $this->work_schedule_repository->search($conditions);

        foreach (DB::table('projects')->get() as $project) {
            $projects[$project->id] = $project->project_name;
        }

        return view('/admin/search',[
            'data' => $data,
            'conditions' => $conditions,
            'projects' => $projects,
        ]);
    }

    /**
     * 検索結果詳細
     *
     * @return void
     */
    public function detail(Request $request)
    {
        $data = $this->work_schedule_repository->searchDetail($request->all());
        return view('/admin/search_detail',[
            'schedules' => $data['work_schedules'],
        ]);
    }
}