<?php 

namespace App\Http\Controllers;

use App\Repositories\AdminRepositoryInterface;
use App\Repositories\WorkScheduleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\LoginAdminPost;
use App\Http\Requests\WorkSchedulePost;
use Session;

class AdminController extends Controller
{
    public function __construct(AdminRepositoryInterface $admin_repository,
                                WorkScheduleRepositoryInterface $work_schedule_repository,
                                UserRepositoryInterface $user_repository)
    {
        $this->admin_repository = $admin_repository;
        $this->work_schedule_repository = $work_schedule_repository;
        $this->user_repository = $user_repository;
    }

    /**
     * ログインページ表示
     */
    public function index()
    {
        return view('admin_login');
    }

    /**
     * ログイン処理
     */
    public function login(LoginAdminPost $request)
    {
        return $this->admin_repository->login($request->all());
    }

    /**
     * ログアウト処理
     */
    public function logout()
    {
        Session::flush();
        return redirect('/user/login');
    }

    /**
     * ユーザー検索　トップ
     */
    public function search_top()
    {
        $users = $this->user_repository->get_user();
        return view('search_user',['users' => $users]);
    }

    /**
     * ユーザー検索　一覧
     */
    public function search_list($id, $year, $month)
    {
        $data = $this->work_schedule_repository->get_schedule_admin($id, $year, $month);
        $users = $this->user_repository->get_user();
        return view('search_list', [
            'data' => $data,
            'users' => $users,
        ]);
    }

    /**
     * ユーザー編集
     */
    public function edit($id, $year, $month, $day)
    {
        $data = $this->work_schedule_repository->get_entry_admin($id, $year, $month, $day);
        return view('admin_edit', [
            'id' => $id,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'data' => $data,
        ]);
    }
    
    /**
     * ユーザー変更、承認
     */
    public function store(WorkSchedulePost $request, $id)
    {
        return $this->work_schedule_repository->store_admin($id, $request->all());
    }
}