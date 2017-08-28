<?php

namespace App\Repositories;

interface AdminRepositoryInterface
{  
    /**
     * ログイン処理
     *
     * @var array $data
     */
    public function login($data);
    
}