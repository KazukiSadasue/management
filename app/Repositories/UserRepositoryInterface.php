<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    /**
     * ユーザー作成
     *
     * @var array $data
     */
    public function store($data);
   
    /**
     * ログイン処理
     *
     * @var array $data
     */
    public function login($data);
}