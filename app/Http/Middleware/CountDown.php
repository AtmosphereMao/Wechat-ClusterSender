<?php

namespace App\Http\Middleware;

use App\Http\Model\WXinfo_CountDownModel;
use App\Http\Model\WXinfo_OperationModel;
use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Support\Facades\Auth;

class CountDown
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
        $id = Auth::user()->id;
        $wxinfo_countdown = WXinfo_CountDownModel::All();
        $data = $wxinfo_countdown->where('user_id',$id);
        if($data->isEmpty())
        {
            $ip = $_SERVER["REMOTE_ADDR"];
            $OperaionCount = WXinfo_OperationModel::where(['ip'=>$ip,'user_id'=>$id])->count();
            if ($OperaionCount == 10)
            {
                $flight = WXinfo_OperationModel::where('user_id',$id)->delete();
                $flight = WXinfo_CountDownModel::create(['ip'=>$ip,'user_id'=>$id]);
            }
        }else {
            $time = $data->first()->create_time;
            date_default_timezone_set("Asia/Shanghai");
            $nowtime = date("Y-m-d H:i:s", time());
            $value = strtotime($nowtime) - strtotime($time);
            if($value >=1200)
            {
                $flight = WXinfo_CountDownModel::where('user_id',$id)->delete();
            }
            else
            {
                $value = 1200-$value;
                $second = $value%60;
                $min = floor($value/60);
                return redirect('home')->with('js_warning_time',"由于您多次请求Generate，请 ".$min." 分 ".$second." 秒后再试");
            }
        }

        return $next($request);
    }
}
