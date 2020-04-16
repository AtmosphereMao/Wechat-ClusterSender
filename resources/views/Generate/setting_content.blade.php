<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Generate - 添加内容</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <script type="text/javascript" src="{{url('jquery/jquery-3.2.1.min.js?version=1.0.0')}}"></script>
    <script type="text/javascript" src="{{url('javascript/setting_content.js?version=1.0.0')}}"></script>
    @section('script')
        <script id="ueditor"></script>
        <script>
            var ue=UE.getEditor("ueditor");
            ue.ready(function(){
                //因为Laravel有防csrf防伪造攻击的处理所以加上此行
                ue.execCommand('serverparam','_token','{{ csrf_token() }}');
            });
        </script>
    @stop


    <link rel="stylesheet" type="text/css" href="{{url("/css/common.css")}}">
</head>
<body id="app-layout" tabindex="1" class="loadingInProgress">

<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                WetChat-ClusterSender
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/home') }}">Home</a></li>
                @if(Auth::user()!=null)
                    @if(Auth::user()->rule=="vip")
                        <li><a href="{{ url('/generate') }}">Generate</a></li>
                        <li><a href="{{ url('/masssend') }}">Mass Send</a> </li>
                    @endif
                    @if(Auth::user()->rule=="user" || Auth::user()->rule=="vip")
                        <li><a href="{{ url('/management') }}">Management</a></li>
                    @endif
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('management/modify') }}"><i class="fa fa-btn fa-sign-out"></i>修改密码</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>注销</a></li>

                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>



<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Generate Setting</div>

                    <div class="panel-body" >
                        <input type="button" id="wxinfo_table_back" value="上一步" class="btn btn-info"><br><br><br>
                        <span style="font-weight: bold;font-size: 24px;">添加内容:</span>
                        @if(session('msg'))
                            <p class="WarningMsg">{{session('msg')}}</p>
                            @endif
                            <form method="post">
                                {{csrf_field()}}
                                <span style="font-size: 16px;">内容名<span style="font-size: 10px;">(可不填写)：</span></span><input type="text" name="name">
                                <div id="ueditor" class="edui-default">

                                    @include('UEditor::head')

                                    <script id="content" name="content" type="text/plain" style="width:900px;height:500px;padding-top: 20px;"></script>

                                    <script type="text/javascript">
                                    var ue = UE.getEditor('content');
                                    </script>
                                </div>
                                <input type="submit" value="添加" style="width: 50px">
                            </form>
                    </div>

            </div>
        </div>
    </div>
</div>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>

