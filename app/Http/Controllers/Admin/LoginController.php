<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AdminRepositoryInterface;
use App\Http\Requests\LoginAdminPost;
use Session;

class LoginController extends Controller
{
    public function __construct(AdminRepositoryInterface $admin_repository)
    {
        $this->admin_repository = $admin_repository;
    }

    /**
     * ログインページ表示
     */
    public function index()
    {
        return view('admin/login');
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
}