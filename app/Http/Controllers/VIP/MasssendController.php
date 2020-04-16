<?php

namespace App\Http\Controllers\VIP;

use App\Http\Model\WebPage_UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class MasssendController extends Controller
{
    public function index()
    {
        if(isset($_POST['count']))
        {
            $count = $_POST['count'];
        }else{
            $count =0;
        }
//        $count = WebPage_UserModel::All()->where('user_id',Auth::user()->id)->count();

        if(isset($_GET['search']))
        {
            $serach =$_GET['search'];
            $wx_array = WebPage_UserModel::where('user_id',Auth::user()->id)->where('NickName','like','%'.$serach.'%')->orwhere('RemarkName','like','%'.$serach.'%')->orderBy('id','desc')->offset($count)->take(16)->get();
        }
        else
        {
            $wx_array = WebPage_UserModel::where('user_id',Auth::user()->id)->orderBy('id','desc')->offset($count)->take(10)->get();
        }

        if($count>=1)
        {
            return view('MassSend.index_more',['wx_array'=>$wx_array]);
        }
        return view('MassSend.index',['wx_array'=>$wx_array]);
    }
}
