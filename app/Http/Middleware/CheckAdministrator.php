<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('user')) {
            if (Session::get('user')['approval'] == \App\Models\User::ADMINISTRATOR) {
                return $next($request);
            }
            if (Session::get('user')['approval'] == \App\Models\User::GENERAL_USER) {
                \Session::flash('error_message', '管理者ユーザーではありません');
                return redirect('/user/login');   
            }
        }

        \Session::flash('error_message', 'ログインしてください');
        return redirect('/user/login');   

    }
}
