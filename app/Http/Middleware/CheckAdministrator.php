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
        if (Session::has('admin')) {
            return $next($request);
        }

        \Session::flash('error_message', 'ログインしてください');
        return redirect('/admin/login');   

    }
}
