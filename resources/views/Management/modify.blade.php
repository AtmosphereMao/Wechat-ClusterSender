@extends('layouts.app')
@section('title','Management - 修改密码')
@section('content')
<script type="text/javascript" src="{{asset('javascript/management.js?version=1.0.0')}}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Management
                    <form action="" style="float: right;">
                        <select name="Management_function" id="Management_function" style="font-family:Verdana, Arial, Helvetica, sans-serif;" datacol="yes" >
                            <option value="modify">修改密码</option>
                            <option value="edit">个人信息</option>
                            <option value="webPage">生成页面管理</option>
                        </select>
                    </form>
                </div>

                <div class="panel-body">
                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                            <p class="WarningMsg">{{$error}}</p>
                        @endforeach
                    @endif
                    @if(session('msg'))
                            <p class="WarningMsg">{{session('msg')}}</p>
                        @endif
                    <form action="" method="post">
                        {{csrf_field()}}
                        <span id="require">旧密码 : </span><input type="text" name="password_old"><br>
                        <span id="require">新密码 : </span><input type="text" name="password"><br>
                        <span id="require">确认密码 : </span><input type="text" name="password_confirmation"><br>
                        <button type="submit" class="btn btn-info">修改密码</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
