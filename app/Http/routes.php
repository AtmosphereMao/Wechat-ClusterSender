<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
});

Route::auth();


//首页
Route::get('/home', 'HomeController@index');

    /*内部用户页面*/

//VIP期限验证  —— 需要登录页面
Route::group(['middleware'=>['vip-time-limit']],function (){


//生成页
Route::group(['namespace'=>'VIP','middleware'=>['auth-vip','countdown']],function () {
    Route::get('generate', 'GenerateController@index');

    Route::group(['prefix'=>'generate'],function (){
        Route::get('login','GenerateController@login');
        Route::get('validation/{uuid}','GenerateController@validation');
        Route::post('loading','GenerateController@setinfo');
        Route::get('choose','GenerateController@choose');
        Route::post('choose/add','GenerateController@add');
        Route::post('setting','GenerateController@setting');
        Route::any('setting/content/add','GenerateController@content_add');
        Route::delete('setting/content/delete','GenerateController@content_delete');
        Route::post('setting/content/update','GenerateController@content_update');
        Route::post('setting/uploadfile','GenerateController@upload');
        Route::post('setting/background/delete','GenerateController@background_delete');
        Route::post('setting/background/update','GenerateController@background_update');
        Route::any('submit','GenerateController@submit');
        Route::any('test','GenerateController@test');
        Route::any('test1','GenerateController@sendEmail');
    });
    Route::any('masssend','MasssendController@index');
});
//快照
    Route::group(['namespace'=>'VIP','prefix'=>'generate'],function (){
        Route::get('setting/css/snapshot','GenerateController@css_snapshot');
    });
//用户管理页面
Route::group(['namespace'=>'VIP'],function(){
    Route::get('management','ManagementController@index');
    Route::group(['prefix'=>'management'],function (){
    //普通用户管理界面
        Route::any('edit','ManagementController@edit');
        Route::any('modify','ManagementController@modify');

    //VIP功能管理界面
        Route::group(['middleware'=>['auth-vip']],function(){
            Route::any('webPage','ManagementController@webPage');
            Route::group(['prefix'=>'webPage'],function (){
                Route::delete('delete','ManagementController@webPage_delete');
            });


        });



    });
});


//VIP期限结束
});
    /*内部用户页面*/





    /*公开页面*/

//WebPage
Route::group(['prefix'=>'webpage'],function(){
    Route::get('search/{page_id}','WebPageController@search_friend');
});

    /*公开页面*/