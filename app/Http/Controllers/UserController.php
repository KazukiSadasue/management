<?php 

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\LoginUserPost;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image;

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
        return redirect('/user/login');
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
        return redirect('/user/login');
    }
    
    /**
     * ユーザー設定
     *
     * @return void
     */
    public function setting()
    {
        var_dump(Session::get('user')['image']);
        return view('setting');
    }
    
    /**
     * ユーザー設定変更
     *
     * @return void
     */
    public function saveSetting(Request $request)
    {
        $this->user_repository->save($request->all());
        return redirect('user/setting');
    }
















    /**
     * ユーザーページ
     * 使っていない
     */
    public function mypage()
    {
        return $this->user_repository->checkUser();
    }
}