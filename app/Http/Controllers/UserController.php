<?php 

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\LoginUserPost;
use Session;

class UserController extends Controller
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
        return view('login');
    }

    /**
     * ログイン処理
     */
    public function login(LoginUserPost $request)
    {
        return $this->user_repository->login($request->all());
    }
    
    /**
     * ログアウト処理
     */
    public function logout()
    {
        Session::flush();
        return redirect('login');
    }

    /**
     * 新規作成ページ表示
     */
    public function create()
    {
        return view('create');
    }

    /**
     * 新規登録
     */
    public function store(StoreUserPost $request)
    {
        $this->user_repository->store($request->all());
        return redirect('login');
    }
    
    /**
     * ユーザーページ
     */
    public function mypage()
    {
        return $this->user_repository->checkUser();
    }
}