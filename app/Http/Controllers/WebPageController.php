<?php

namespace App\Http\Controllers;

use App\Http\Model\WebPage_Background_UserModel;
use App\Http\Model\WebPage_BackgroundModel;
use App\Http\Model\WebPage_ContentModel;
use App\Http\Model\WebPage_CssModel;
use App\Http\Model\WebPage_UserModel;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class WebPageController extends Controller
{
    public function search_friend($page_id){
        $WebPage_User = WebPage_UserModel::where(['page_id'=>$page_id])->first();
        if(!(isset($WebPage_User))){
            abort('404');
        }
        $WebPage_Content = $WebPage_User->page_content;
        $WebPage_Content = WebPage_ContentModel::where(['id'=>$WebPage_Content])->first()->content_text;
        $WebPage_Css = $WebPage_User->page_css;
        $WebPage_Css = WebPage_CssModel::where(['html_filename'=>$WebPage_Css])->first();
        $WebPage_Background = $WebPage_User->page_background;
        $page_background_pass = substr($WebPage_Background, '0', '2');
        if (preg_match('/[a-zA-Z]/', $page_background_pass)) {
            $Background_create = WebPage_Background_UserModel::where(['image_filename'=>$WebPage_Background])->first()->create_user;
        }else{
            $Background_create = 'official';
        }
        if($WebPage_User->RemarkName ==" NULL")
        {
            $Name = $WebPage_User->NickName;
        }else{
            $Name = $WebPage_User->RemarkName;
        }
        $create_user = User::where(['id'=>$WebPage_User->user_id])->first()->name;
        return view('webpage.'.$WebPage_Css->html_filename,['WebPage_User'=>$WebPage_User,'Name'=>$Name,'WebPage_Content'=>$WebPage_Content,'WebPage_Css'=>$WebPage_Css,'Background_create'=>$Background_create,'Create_user'=>$create_user]);
    }
}
