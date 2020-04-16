@extends('layouts.app')
@section('title','Management - 个人资料')
@section('content')
<script type="text/javascript" src="{{asset('javascript/management.js?version=1.0.0')}}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Management
                    <form action="" style="float: right;">
                        <select id="Management_function" style="font-family:Verdana, Arial, Helvetica, sans-serif;">
                            <option value="edit">个人信息</option>
                            <option value="webPage">生成页面管理</option>
                            <option value="modify">修改密码</option>
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
                    <form action="{{url('management/edit')}}" method="post">
                        {{csrf_field()}}
                        账号ID : <span>{{Auth::user()->account_id}}</span><br>
                    个人名称 : <input name="name" value="{{Auth::user()->name}}"><br>
                    邮箱 :  <span>{{Auth::user()->email}}</span><br>
                    VIP :  <span style="font-weight: bold">{{Auth::user()->rule}}</span>
                    <span style="margin-left: 30px;">
                        @if(Auth::user()->vip_time_limit =='9999-01-01 00:00:00')
                            永久
                            @else
                            {{Auth::user()->vip_time_limit}}后到期  <a href="#" style="margin-left: 10px;">续费</a>
                            @endif
                    </span>
                        <br>
                        <input type="submit" value="保存信息" class="btn btn-info"  >
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
