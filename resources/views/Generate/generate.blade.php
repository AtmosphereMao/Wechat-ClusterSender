@extends('layouts.app')
@section('title','Generate')
@section('content')
<script type="text/javascript" src="jquery/jquery-3.2.1.min.js?version=1.0.0"></script>
<script type="text/javascript" src="javascript/generate.js?version=1.0.1"></script>
<link rel="stylesheet" type="text/css" href="css/common.css?version=1.0.0">
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Generate Setting</div>

                    <div class="panel-body" >
                        @if(session('msg'))
                            <p class="WarningMsg">{{session('msg')}}</p>
                        @endif
                        <button id="login-qrcode" type="button" class="btn btn-info" >获取登录二维码授权</button>
                            @if($getvalue_isset=="true")
                        <button id="login-choose" type="button" class="btn btn-warning">重新设置信息</button>
                            @endif

                        <div id="qrcode">


                        </div>

                        @if(session('js_warning_second'))
                            <div id = "js_warning">
                                <p class="js_warning_time">{{session('js_warning_second')}}</p>

                            </div>
                            @endif
                        {{csrf_field()}}
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
