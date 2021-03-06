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
    
    /**
     * ユーザー取得
     *
     */
    public function getUser();

    /**
     * 画像アップロード
     *
     * @param array $condition
     * @return void
     */
    public function upload($data);

    /**
     * ユーザー情報更新
     *
     * @param array $condition
     * @return void
     */
    public function update($data);
}