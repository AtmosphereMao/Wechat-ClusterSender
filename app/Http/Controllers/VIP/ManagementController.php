<?php

namespace App\Http\Controllers\VIP;

use App\Http\Model\WebPage_UserModel;
use App\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    //析构
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return redirect(url('management/edit'));
    }


    //普通页面
    public function edit(Request $request){
            if($request->isMethod('post')) {
                if ($input = Input::All()) {
                    if ($input['name'] == Auth::user()->name) {
                        return back()->with('msg', '修改成功');
                    }
                    $rules = [
                        'name' => 'required|max:10|unique:users',
                    ];
                    $message = [
                        'name.required' => '个人名称不能为空',
                        'name.max' => '名字不能超过10位',
                        'name.unique' => '名字已存在',
                    ];
                    $validator = Validator::make($input, $rules, $message);
                    if ($validator->passes()) {
                        $flight = UserModel::where(['id'=>Auth::user()->id])->update(['name' => $input['name']]);
                        return back()->with('msg', '修改成功');
                    } else {
                        return back()->withErrors($validator);
                    }
                }
            }
        return view('Management.edit');
    }
    public function modify(Request $request){
        if($request->isMethod('post')) {
            if ($input = Input::all()) {
                $rules = [
                    'password' => 'required|between:6,20|confirmed',
                    'password_old' => 'required',
                ];

                $message = [
                    'password_old' => '旧密码不能为空',
                    'password.required' => '新密码不能为空',
                    'password.between' => '新密码必须在6~20位之间',
                    'password.confirmed' => '新密码和确认密码不一致',
                ];
                $validator = Validator::make($input, $rules, $message);
                if ($validator->passes()) {
                    if (Hash::check($input['password_old'], Auth::user()->password)) {
                        $password = $password = Hash::make($input['password']);
                        $flight = UserModel::where(['name' => Auth::user()->name, 'email' => Auth::user()->email])->update(['password' => $password]);
                        return back()->with('msg', '修改成功');
                    } else {
                        return back()->with('msg', '旧密码不正确');
                    }
                } else {
                    return back()->withErrors($validator);
                }
            }
        }
        return view('Management.modify');
    }



    //VIP功能页面
    public function webPage(){
        if (isset($_GET['pageid']))
        {
            $page_id = $_GET['pageid'];
        }else{
            $page_id = 1;
        }
        $sum = $page_id*10-10;
        $count = WebPage_UserModel::All()->where('user_id',Auth::user()->id)->count();
        $count = ceil($count/10);
        $wx_array = WebPage_UserModel::where('user_id',Auth::user()->id)->offset($sum)->take(10)->get();
//        dd($count);
        return view('Management.webPage',['wx_array'=>$wx_array,'count'=>$count,'now'=>$page_id]);
    }
    //method delete
    public function webPage_delete(){

        $page_id=json_decode($_POST['part']);
        if(is_array($page_id)){
            //是数组
            $success = 0;
            $fail = 0;
            foreach ($page_id as $value)
            {
                if(WebPage_UserModel::where(['page_id'=>$value,'user_id'=>Auth::user()->id])->delete())
                {
                    $success++;
                }else{
                    $fail++;
                }
            }
            $data  =[
                'status' => 0,
                'msg' => '删除成功 '.$success.' 个，删除失败 '.$fail.' 个。'
            ];
            return $data;

        }else{
            //不是数组
            if(WebPage_UserModel::where(['page_id'=>$page_id,'user_id'=>Auth::user()->id])->delete())
            {
                $data = [
                    'status' => 0,
                    'msg' => '删除成功!',
                ];
                return $data;
            }else{
                $data = [
                    'status' => 1,
                    'msg' => '删除失败!',
                ];
                return $data;
            }
        }
    }
    //删除
//    function webPageSQL_delete($page_id){
//        return WebPage_UserModel::where(['page_id'=>$page_id,'create_user'=>Auth::user()->name])->delete() ;
//    }
}
