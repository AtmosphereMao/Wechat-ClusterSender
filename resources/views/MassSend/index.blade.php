@extends('layouts.app')
@section('title','Mass Send - 群发首页')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/masssend_index.css?version=1.0.0')}}">
    <script type="text/javascript" src="{{asset('layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{asset('javascript/masssend_index.js?version=1.0.4')}}"></script>


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Management

                </div>

                <div class="panel-body">
                    <div class="search_box">
                        <form class="my-sm-0" action="" method="get">
                            <div class="input-group mb-0" >
                                <input type="text" class="form-control" name="search" placeholder="请输入关键字">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">搜索</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
                        <div id="wxinfo_friends">
                            <input type="checkbox" id="all" style="width: 18px; height: 18px;" /> 全选
                            <div class="wxinfo_friends_content">
                                <table class="table wxinfo">

                                    <tr>
                                        <th></th>
                                        <th>页面ID:</th>
                                        <th>用户名:</th>
                                        <th>备注名:</th>
                                        <th>城市-省:</th>
                                        <th>城市-市:</th>
                                        <th>标题:</th>
                                        <th>创建时间:</th>
                                        <th>Action</th>
                                    </tr>

                                            @forelse($wx_array as $value)
                                        <tr>
                                            <th> <input type="checkbox"  id="wxinfo_table_check" name="checkbox" value="{{$value->page_id}}" style="width: 18px; height: 18px;" /></th>
                                            <th> <span><a href="{{url('webpage/search/')."/".$value->page_id}}" target="_blank"> {{$value->page_id}}</a></span></th>
                                            <th> <span>{!!$value->NickName!!}</span></th>
                                            <th> <span>{!!$value->RemarkName!!}</span></th>
                                            <th> <span>{{$value->Province}}</span></th>
                                            <th> <span>{{$value->City}}</span></th>
                                            <th> <span>{{$value->page_title}}</span></th>
                                            <th> <span>{{$value->create_time}}</span></th>
                                            <th>
                                                <span><a href="javascript:void(0)" onclick="WebPageDelete('{{$value->page_id}}')" data-id="{{$value->id}}">发送</a> </span>
                                                
                                            </th>

                                        </tr>
                                                @empty
                                        <tr>
                                            <th>没有数据</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                                @endforelse



                                </table>
                            </div>
                            <div id="page_action">
                                <button class="btn btn-success" href="javascript:void(0)" onclick="WebPageMostDelete()">发送所选</button>
                            </div>



                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
