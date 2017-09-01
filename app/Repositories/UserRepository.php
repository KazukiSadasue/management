<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    /**
    * @param object $user
    */
    public function __construct(User $user)
    {
    $this->user = $user;
    }

    /**
     * ユーザー作成
     *
     * @var array $data
     */
    public function store($data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->user->create($data);
    }

    /**
     * ログイン処理
     *
     * @var array $data
     */
    public function login($data)
    {
        $user = $this->user->where('email', '=', $data['email'])->first();
        if (Hash::check($data['password'],$user['password']))
        {
            Session::put('user', $user);
            return redirect('/user/calendar');
        }
        \Session::flash('error_message', 'パスワードが違います');
        return redirect('/user/login');
    }

    /**
     * ユーザー取得
     *
     */
    public function getUser()
    {
        return $this->user->all();
    }

    /**
     * ユーザー情報更新
     *
     * @param array $condition
     * @return void
     */
    public function save($condition)
    {
        $image = Image::make($condition['fileName']->getRealPath());
        $fileName = $condition['fileName']->getClientOriginalName();
        $path = public_path() . '/images/';

        $image->save($path . $fileName)
            ->resize(200,200)
            ->save($path . 'thumbnail-' . $fileName);

        $picture_path = '/images/thumbnail-' . $fileName;
        $this->user->where('id', '=', Session::get('user')['id'])->update(['image' => $picture_path]);

        Session::push('user', Session::get('user'));

        return;
    }

}