<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;

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
            return Session::put('user', $user);
        }
        return;
    }

}