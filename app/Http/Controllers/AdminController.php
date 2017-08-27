<?php 

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\LoginUserPost;
use Session;

class AdminController extends Controller
{
    public function __construct(UserRepositoryInterface $user_repository)
    {
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
    public function login(LoginUserPost $request)
    {
        $this->user_repository->login($request->all());
        if ( Session::get('user')['approval'] == \App\Models\User::ADMINISTRATOR ) {
            return redirect('/admin/search');
        }
        if (Session::get('user')['approval'] == \App\Models\User::GENERAL_USER) {
            \Session::flash('error_message', '管理者ユーザーではありません');
            return redirect('/admin/login');   
        }

        \Session::flash('error_message', 'パスワードが違います');
        return redirect('/admin/login');
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
     * ユーザー検索
     */
    public function search()
    {
        return view('search_user');
    }
}