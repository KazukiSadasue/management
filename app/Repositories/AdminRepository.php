<?php

namespace App\Repositories;


use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;

class AdminRepository implements AdminRepositoryInterface
{
    protected $admin;

    /**
    * @param object $admin
    */
    public function __construct(Admin $admin)
    {
    $this->admin = $admin;
    }

    /**
     * ログイン処理
     *
     * @var array $data
     */
    public function login($data)
    {
        $admin = $this->admin->where('email', '=', $data['email'])->first();
        if (Hash::check($data['password'],$admin['password']))
        {
            Session::put('admin', $admin);
            return redirect('/admin/search');
        }
        \Session::flash('error_message', 'パスワードが違います');
        return redirect('/admin/login');
    }
}