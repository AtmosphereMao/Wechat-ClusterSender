@extends('layouts.app')
@section('title','WetChat-ClusterSender')
@section('content')
<link rel="stylesheet" type="text/css" href="css/common.css?version=1.0.0">
<script type="text/javascript" src="jquery/jquery-3.2.1.min.js?version=1.0.0"></script>
<script type="text/javascript" src="javascript/common.js?version=1.0.0"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Cluster Sender</div>
                @if(empty(Auth::user()))
                <div class="panel-body">
                    请登录
                </div>
                @else

                    <div class="panel-body">
                        @if(session('js_warning_time'))
                            <div id = "js_warning">
                                <img src="../icon/delete01.png" class="close_warning">
                                <p class="js_warning_time">{{session('js_warning_time')}}</p>
                            </div>
                        @endif
                        欢迎进入Cluster Sender
                        <p style="text-align: center;margin-top: 800px;">
                        **************** 以上内容页 ****************
                        </p>


                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
