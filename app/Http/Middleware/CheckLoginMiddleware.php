<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckLoginMiddleware
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
        if (Session::has('id')) {
            return $next($request);
        }
        
        \Session::flash('error_message', 'ログインしてください');
        return redirect('login');   
    }
}
