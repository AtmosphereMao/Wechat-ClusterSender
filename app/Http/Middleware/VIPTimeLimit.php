<?php

namespace App\Http\Middleware;

use App\UserModel;
use Closure;
use Illuminate\Support\Facades\Auth;

class VIPTimeLimit
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
        if(Auth::user()==null)
        {
            return $next($request);
        }
        if(Auth::user()->rule=="vip")
        {
            $time = Auth::user()->vip_time_limit;
            //永久期限用户
            if($time == "9999-01-01 00:00:00")
            {
                return $next($request);
            }

            //检测是否会员过期
            date_default_timezone_set("Asia/Shanghai");
            $nowtime = date("Y-m-d H:i:s", time());
            $value = strtotime($nowtime) - strtotime($time);
//            dd($value);
            if($value >=0)
            {
                $flight = UserModel::where(['name'=>Auth::user()->name,'email'=>Auth::user()->email])->update(['rule'=>'user']);

            }
        }
        return $next($request);
    }
}
