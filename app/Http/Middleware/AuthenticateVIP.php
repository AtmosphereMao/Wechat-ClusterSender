<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateVIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                    return response('Unauthorized.', 401);

            } else {
                return redirect()->guest('login');

            }
        }
        if(Auth::user()->rule=="vip")
        {
            return $next($request);
        }
        else
        {
            //返回主目录（以后可跳转充值页面）
            return redirect()->guest('/');
        }

    }
}
