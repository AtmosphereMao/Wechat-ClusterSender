<?php

namespace App\Http\Controllers\VIP;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Model\WebPage_ContentModel;
use App\Http\Model\WebPage_UserModel;
use App\Http\Model\WXinfo_CountDownModel;
use App\Http\Model\WXinfo_OperationModel;
use App\Http\Model\WebPage_CssModel;
use App\Http\Model\WebPage_BackgroundModel;
use App\Http\Model\WebPage_Background_UserModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\WXinfo_GetValueModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use function Sodium\add;


class GenerateController extends Controller
{
    //析构
    public function __construct()
    {
        $this->middleware('auth');
    }


    //首页
    public function index()
    {
        $wxinfo_getvalue = WXinfo_GetValueModel::where(['user_id'=> Auth::user()->id])->first();

        if(isset($wxinfo_getvalue)){
            return view('Generate.generate',['getvalue_isset'=>'true']);

        }else
        {
            return view('Generate.generate',['getvalue_isset'=>'false']);
        }

    }

    public function login()
    {

//        if(!(session('login_count')))
//        {
//            Session::put('login_count',0);
//        }
//        $i =session('login_count');
//        $i = $i++;
//        session(['login_count'=>$i]);
        $output = shell_exec('python ../app/Http/Controllers/Python/Login.py');

        $uuid = $output;

        return $uuid;


    }

    public function validation($uuid)
    {
        $output = exec('python ../app/Http/Controllers/Python/Validation.py ' . $uuid);
        if ($output == "") {

            return "二维码超时，请重新扫描二维码";
        }

        $output = urldecode($output);
        $resulf = substr($output, 1);
        $resulf = substr($resulf, 0, -1);
        $resulf = str_replace("'", "", $resulf);
        $wx_array = explode(",", $resulf);
        $json_string = json_encode($wx_array);
//        重置数据库的用户数据
        $id = Auth::user()->id;
        $wxinfo_getvalue = WXinfo_GetValueModel::All();
        $info = $wxinfo_getvalue->where('user_id', $id);
        if (!($info->isEmpty())) {
            $flight = WXinfo_GetValueModel::where('user_id', $id)->delete();
        }

//        记录用户的访问请求
        $ip = $_SERVER["REMOTE_ADDR"];
        $username = Auth::user()->name;
        $flight = WXinfo_OperationModel::create(['ip' => $ip, 'user_id' => $id]);

        return $json_string;
    }

    public function setinfo()
    {
        if ($input = Input::All()) {
            $wxinfo_getvalue = WXinfo_GetValueModel::All();
            $id = Auth::user()->id;
            $info = $wxinfo_getvalue->where('user_id', $id);
//            首次运行获取值
            if ($info->isEmpty()) {
                $base_uri = $input['base_uri'];
                $redirect_uri = $input['redirect_uri'];
//                DOS需要转义才能传参
                $redirect_uri = str_replace("&", "^&", $redirect_uri);
                $push_uri = $input['push_uri'];
//                GetInfo自定义函数
                $wx_array = GetInfo($base_uri, $redirect_uri, $push_uri);       //GetInfo函数 -----> helpers
//                dd($wx_array);
                
                if ($wx_array == "") {
                    abort('403', '二维码超时，请重新扫描二维码');
                }
//                为数据库添加数组
                $array_serialize = serialize($wx_array);
                $flight = WXinfo_GetValueModel::create(['user_id' => $id,'friends_info' => $array_serialize]);
                if ($flight == null) {
                    abort('403', '发生未知错误，请稍后再试');
                }
            } else {
                return redirect('generate/choose');
            }
            return redirect('generate/choose');
        } else {
            abort('403', '禁止使用URL进入');
        }

    }

    public function choose()
    {

        $wxinfo_getvalue = WXinfo_GetValueModel::where(['user_id'=> Auth::user()->id])->first();
        if (!(isset($wxinfo_getvalue))) {
            return back();
        }
        $array_serialize = $wxinfo_getvalue->friends_info;
        $wx_array = unserialize($array_serialize);
        return view('Generate.choose', ['wx_array' => $wx_array]);
    }


    //setting页面内容
    public function setting()
    {
        $Page_CSS = WebPage_CssModel::All();
        $Page_Background = WebPage_BackgroundModel::All();
        $Page_Background_User = WebPage_Background_UserModel::All()->where('user_id', Auth::user()->id);
        $Page_Content = WebPage_ContentModel::All()->where('user_id', Auth::user()->id);

        return view('Generate.setting', ['Page_CSS' => $Page_CSS, 'Page_Background' => $Page_Background, 'Page_Background_User' => $Page_Background_User, 'Page_Content' => $Page_Content]);
    }

    //setting页面内容 —— 图片上传
    public function upload()
    {
        //正常上传
//        $file = Input::file('fileUpload');
//        $input = Input::All();
//        $name = $input['fileName'];
//        if($name == "")
//        {
//            return redirect(url('generate/choose'))->with('msg','背景名不能为空');
//        }
//        if($file == null)
//        {
//            return redirect(url('generate/choose'))->with('msg','文件不能为空');
//        }
//        if ($file->isValid()) {
//            $realPath = $file->getRealPath();
//            $entension = $file->getClientOriginalExtension();
//            if ($entension != "jpg" && $entension !="png") {
//                return back();
//            }
//                $filename =rand(100000,999999);
//                $Page_Background_User = WebPage_Background_UserModel::All();
//                $isset = $Page_Background_User->where('create_user',Auth::user()->account_id)->get(1);
//
//
//            $newName =  $filename  . '.' . $entension;
//            try {
//                $path = $file->move(public_path() . "/webpage-background/" . Auth::user()->name, $newName);
//            }
//            catch (Exception $e)
//            {
//                abort(403, '限制文件大小为8M以内');
//            }
//            $flight = WebPage_Background_UserModel::create(['image_name'=>$name,'image_filename'=>$newName,'create_user'=>Auth::user()->account_id]);
//        }
//        return back();

        //异步上传
        $file = Input::file('fileData');
        if ($file == null) {
            return redirect(url('generate/choose'))->with('msg', '文件不能为空');
        }
        if ($file->isValid()) {

            $realPath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
            if ($entension != "jpg" && $entension != "png") {
                return back();
            }

            do {
                $filename_path = chr(rand(65, 90)) . chr(rand(65, 90)) . rand(100000, 999999);
                $filename = $filename_path.'.'.$entension;
                $Page_Background_User = WebPage_Background_UserModel::All();
                $isset = $Page_Background_User->where('image_filename', $filename)->get(1);
            } while ($isset != null);

            $newName = $filename;
            try {
                $path = $file->move(public_path() . "/webpage-background/" . Auth::user()->name, $newName);
            } catch (Exception $e) {
                abort(403, '限制文件大小为5M以内');
            }
            $name = $filename_path;
            $flight = WebPage_Background_UserModel::create(['image_name' => $name, 'image_filename' => $newName, 'user_id' => Auth::user()->id]);
        } else {
            return "上传失败";
        }
//        $Success = array($filename_path, $entension);
//        $Success = json_encode($Success);
        return "上次成功";
    }

    //setting页面内容 —— 图片删除
    public function background_delete()
    {
//        $input = Input::All();
        $fileName = $_POST['fileName'];
        $flight = WebPage_Background_UserModel::where(['image_filename' => $fileName, 'user_id' => Auth::user()->id])->delete();
        if ($flight == 1) {
            unlink(public_path() . "/webpage-background/" . Auth::user()->name . "/" . $fileName);
            return "删除成功";
        } else {
            return "删除失败";
        }
    }

    //setting页面内容 —— 图片更名
    public function background_update()
    {
        $fileName = $_POST['fileName'];
        $updateName = $_POST['updateName'];
        $flight = WebPage_Background_UserModel::where(['image_filename' => $fileName, 'user_id' => Auth::user()->id])->update(['image_name' => $updateName]);
        if ($flight == 1) {
            return "更改成功";
        } else {
            return "更改失败";
        }
    }

    //setting页面内容 —— 样式快照预览
    public function css_snapshot()
    {
        if (isset($_GET['cssName'])) {
            $WebPage_Css = WebPage_CssModel::All();
            $WebPage_Css = $WebPage_Css->where('html_filename', $_GET['cssName'])->first();
            if (!(isset($WebPage_Css)))
            {
                abort('404');
            }
                $WebPage_User = WebPage_UserModel::where(['user_id'=>'0'])->first();
                $WebPage_Content = $WebPage_User->page_content;
                $WebPage_Content = WebPage_ContentModel::where(['id'=>$WebPage_Content])->first()->content_text;
                $Background_create = 'official';
                $create_user = '官方';
                if($WebPage_User->RemarkName ==" NULL")
                {
                    $Name = $WebPage_User->NickName;
                }else{
                    $Name = $WebPage_User->RemarkName;
                }
                return view('webpage.'.$WebPage_Css->html_filename,['WebPage_User'=>$WebPage_User,'Name'=>$Name,'WebPage_Content'=>$WebPage_Content,'WebPage_Css'=>$WebPage_Css,'Background_create'=>$Background_create,'Create_user'=>$create_user]);
        }

    }

    //setting页面内容 —— 内容页
    public function content_add(Request $request)
    {
        if($request->isMethod('post')) {
            if ($input = Input::All()) {
                if ($input['content'] == null) {
                    return back()->with('msg', '请输入内容');
                } else {
                    $content = $input['content'];
                    $match = preg_match('/background-color:(.*?);/', $content, $new);
                    if ($match == 1) {
                        $content = str_replace("$new[0]", "", $content);
                    }

                    $flight = WebPage_ContentModel::create(['content_name' => $input['name'], 'content_text' => $content, 'user_id' => Auth::user()->id]);
                    return redirect(url('generate/choose'));
                }
            }
        }

        return view('Generate.setting_content');
    }

    //setting页面内容 —— 内容名更名
    public function content_update()
    {
        $id = $_POST['id'];
        $updateName = $_POST['updateName'];
        $flight = WebPage_ContentModel::where(['id' => $id, 'user_id' => Auth::user()->id])->update(['content_name' => $updateName]);
        if ($flight == 1) {
            return "更改成功";
        } else {
            return "更改失败";
        }
    }

    //setting页面内容 —— 内容删除 method delete
    public function content_delete()
    {
        $id = $_POST['id'];
        $flight = WebPage_ContentModel::where(['id' => $id, 'user_id' => Auth::user()->id])->delete();
        if ($flight == 1) {
            $data = [
                'status' => 0,
                'msg' => '删除成功!',
            ];
            return $data;
        } else {
            $data = [
                'status' => 1,
                'msg' => '删除失败!',
            ];
            return $data;
        }
    }

    //setting页面内容 —— 提交请求
    public function submit()
    {
        if ($input = Input::All()) {
            $rules = [
                'key' => 'required',
                'page_title' => 'required',
                'page_content' => 'required',
                'page_css' =>'required',
                'page_background' => 'required'
            ];

            $message = [
                'key.required' => '请选择朋友',
                'page_title.required' => '请填写标题',
                'page_content.required' => '请选择内容',
                'page_css.required' => '请选择样式',
                'page_background.required' => '请选择背景',
            ];
            $validator = Validator::make($input, $rules, $message);
            if (!($validator->passes())) {
                return back()->withErrors($validator);
            }
            $key = $input['key'];
            $key = json_decode($key);
            $page_title = $input['page_title'];
            $page_content = explode(",", $input['page_content']);
            $page_css = $input['page_css'];
            $page_background = $input['page_background'];

            //判断内容权限
            foreach ($page_content as $value) {
                $isset_page_content = WebPage_ContentModel::where(['id' => $value, 'user_id' => Auth::user()->id])->first();
                if (!(isset($isset_page_content))) {
                    return back()->with('msg', '不存在此内容，请联系管理员');
                }
                unset($isset_page_content);
            }

            //判断CSS权限
            $isset_page_css = WebPage_CssModel::where(['html_filename' => $page_css])->first();
            if (isset($isset_page_css)) {
                unset($isset_page_css);
                //判断选取的背景
                $page_background_pass = substr($page_background, '0', '2');
                if (preg_match('/[a-zA-Z]/', $page_background_pass)) {
                    //个人背景
                    $isset_page_background = WebPage_Background_UserModel::where(['image_filename' => $page_background, 'user_id' => Auth::user()->id])->first();
                    //判断背景权限
                    if (isset($isset_page_background)) {
                        unset($isset_page_background);
                        //判断Wxinfo_Friends是否过期.
                        $isset_wxinfo_friends = WXinfo_GetValueModel::where(['user_id'=>Auth::user()->id])->first();
                        if (!(isset($isset_wxinfo_friends))) {
                            return redirect(url('generate'))->with('msg', '信息超时，请重新获取');
                        }
                        //整理需要上传的数据库
                        $wxinfo_friends_getvalue = unserialize($isset_wxinfo_friends->friends_info);
                        unset($isset_wxinfo_friends);
                        $wxinfo_friends = array();
                        $i = 0;
                        foreach ($key as $value) {
                            if(!(array_key_exists($value,$wxinfo_friends_getvalue)))
                            {
                                return back()->with('msg', '请勿使用一个不存在的朋友');
                            }
                            $wxinfo_friends[$i]['NickName'] = $wxinfo_friends_getvalue[$value][0];
                            $wxinfo_friends[$i]['RemarkName'] = $wxinfo_friends_getvalue[$value][1];
                            $wxinfo_friends[$i]['Province'] = $wxinfo_friends_getvalue[$value][2];
                            $wxinfo_friends[$i]['City'] = $wxinfo_friends_getvalue[$value][3];
                            $i++;

                        }
                        unset($wxinfo_friends_getvalue);
                        //上传数据库
                         $i = 0;
                         foreach($wxinfo_friends as $value){

                             do {
                                 $page_id = rand(10000000, 99999999);
                                 $WebPage_User = WebPage_UserModel::All();
                                 $isset = $WebPage_User->where('page_id',$page_id)->get(1);
                             } while ($isset !=null);

                            $NickName = $value['NickName'];
                            $RemarkName = $value['RemarkName'];
                            $Province = $value['Province'];
                            $City = $value['City'];
                            $page_content_rand = array_rand($page_content);
                            print_r($page_content[$page_content_rand]);
                            $flight = WebPage_UserModel::create(['page_id'=>$page_id,'NickName'=>$NickName,'RemarkName'=>$RemarkName,'Province'=>$Province,'City'=>$City,'user_id'=>Auth::user()->id,'page_css' =>$page_css,'page_title'=>$page_title,'page_content'=>$page_content[$page_content_rand],'page_background'=>$page_background]);
                            $i++;
                         }
                        $flight = WXinfo_GetValueModel::where(['user_id'=>Auth::user()->id])->delete();


                    } else {
                        return back()->with('msg', '不存在此背景图，请联系管理员');
                    }
                } else {
                    //管理员背景
                    $isset_page_background = WebPage_BackgroundModel::where(['image_filename' => $page_background])->first();
                    //判断背景权限
                    if (isset($isset_page_background)) {
                        unset($isset_page_background);
                        //判断Wxinfo_Friends是否过期.
                        $isset_wxinfo_friends = WXinfo_GetValueModel::where(['user_id'=>Auth::user()->id])->first();
                        if (!(isset($isset_wxinfo_friends))) {
                            return redirect(url('generate'))->with('msg', '信息超时，请重新获取');
                        }
                        //整理需要上传的数据库
                        $wxinfo_friends_getvalue = unserialize($isset_wxinfo_friends->friends_info);
                        unset($isset_wxinfo_friends);
                        $wxinfo_friends = array();
                        $i = 0;
                        foreach ($key as $value) {
                            if(!(array_key_exists($value,$wxinfo_friends_getvalue)))
                            {
                                return back()->with('msg', '请勿使用一个不存在的朋友');
                            }
                            $wxinfo_friends[$i]['NickName'] = $wxinfo_friends_getvalue[$value][0];
                            $wxinfo_friends[$i]['RemarkName'] = $wxinfo_friends_getvalue[$value][1];
                            $wxinfo_friends[$i]['Province'] = $wxinfo_friends_getvalue[$value][2];
                            $wxinfo_friends[$i]['City'] = $wxinfo_friends_getvalue[$value][3];
                            $i++;

                        }
                        unset($wxinfo_friends_getvalue);
                        //上传数据库
                        $i = 0;
                        foreach($wxinfo_friends as $value){
                            do {
                                $page_id = rand(10000000, 99999999);
                                $WebPage_User = WebPage_UserModel::All();
                                $isset = $WebPage_User->where('page_id',$page_id)->get(1);
                            } while ($isset !=null);
                            $NickName = $value['NickName'];
                            $RemarkName = $value['RemarkName'];
                            $Province = $value['Province'];
                            $City = $value['City'];
                            $page_content_rand = array_rand($page_content);
                            $flight = WebPage_UserModel::create(['page_id'=>$page_id,'NickName'=>$NickName,'RemarkName'=>$RemarkName,'Province'=>$Province,'City'=>$City,'user_id'=>Auth::user()->id,'page_css'=>$page_css,'page_title'=>$page_title,'page_content'=>$page_content[$page_content_rand],'page_background'=>$page_background]);
                            $i++;
                        }
                        $flight = WXinfo_GetValueModel::where(['user_id'=>Auth::user()->id])->delete();


                    } else {
                        return back()->with('msg', '不存在此背景图，请联系管理员');
                    }
                }
            } else {
                return back()->with('msg', '不存在此样式，请联系管理员');
            }


        }
        return redirect(url('generate'))->with('msg', '提交成功');
    }


    public function test()
    {
        if (isset($_GET['url']))
        {
            set_time_limit(0);
            $url = trim($_GET['url']);
            $htmlName = str_replace("cssName=",'',strstr($url,'cssName'));
            $url = substr_replace($url,'http://','0','0');
            $filePath = chr(rand(65,90)).chr(rand(65,90)).rand(100000, 999999).'.png';
            $WebPage_Css = WebPage_CssModel::All();
            $isset = $WebPage_Css->where('snapshot_filename', $filePath)->first();

            if (is_file($filePath))
            {
                exit($filePath);
            }

            $command = "G:/phantomjs/bin/phantomjs G:/phantomjs/bin/snap.js {$url} {$filePath}";  //这个地方是真正调用phantomjs这个程序的。使用路径来实现调用
            $exec = exec($command);
//            dd($exec);
            exit($filePath);
        }
    }

}
