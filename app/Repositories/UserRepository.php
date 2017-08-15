<?php

namespace App\Repositories;

use App\Models\User;

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
     * 名前で1レコードを取得
     *
     * @var $name
     * @return object
     */
    public function getFirstRecordByName($name)
    {
        return $this->user->where('name', '=', $name)->first();
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
        $data['password'] = bcrypt($data['password']);
        $user = $this->user->where('email', '=', $data['email'])->first();
        if ($user['password'] != $data['password'])
        {
            return redirect('create');
            \Log::error(print_r($user['password'],true));
        }

        if ($user['password'] == $data['password'])
        {
            return redirect('create');
        }
    }    
}