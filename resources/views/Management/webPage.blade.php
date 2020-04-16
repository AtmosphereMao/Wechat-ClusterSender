@extends('layouts.app')
@section('title','Management - 生成页面管理')
@section('content')
    <link rel="stylesheet" type="text/css" href="../css/management_webPage.css?version=1.0.0">
    <script type="text/javascript" src="{{asset('layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{asset('javascript/management.js?version=1.0.0')}}"></script>
    <script type="text/javascript" src="{{url('javascript/management_webPage.js?version=1.0.2')}}"></script>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Management
                    <form action="" style="float: right;">
                        <select name="Management_function" id="Management_function" style="font-family:Verdana, Arial, Helvetica, sans-serif;" datacol="yes" >
                            <option value="webPage">生成页面管理</option>
                            <option value="edit">个人信息</option>
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
                                                <span><a href="javascript:void(0)" onclick="WebPageDelete('{{$value->page_id}}')" data-id="{{$value->id}}">删除</a> </span>

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
                                <a href="javascript:void(0)" onclick="WebPageMostDelete()">删除所选</a>
                            </div>


                            <div id="page_change">
                                @if($count != 0 && isset($wx_array[0]))
                                    <div id="page" style="margin-top: 10px;">
                                        <a href="webPage?pageid=1" class="btn btn-dark">首页</a>
                                        @if($now !=1)
                                            <a href="webPage?pageid={{$now-1}}" class="btn btn-dark">上一页</a>
                                        @endif
                                        @if($now<=5 && $now!=1)
                                            @for($i=1;$i<$now;$i++)
                                                <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                            @endfor
                                        @elseif($now==1)

                                        @elseif($now+5<=$count)
                                            @for($i=$now-4;$i<$now;$i++)
                                                <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                            @endfor
                                        @elseif($now+5>$count)
                                            @if($now<10)
                                                @if($now+5<=$count)
                                                    @for($i=1;$i<$now;$i++)
                                                        <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                                    @endfor
                                                @else
                                                    @if($count>10)
                                                        @for($i=$now-((10-($count-$now))-1);$i<$now;$i++)
                                                            {{----}}
                                                            <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                                        @endfor
                                                    @else
                                                        @for($i=1;$i<$now;$i++)
                                                            {{----}}
                                                            <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                                        @endfor
                                                    @endif
                                                @endif

                                            @else
                                                @for($i=$now-((10-($count-$now))-1);$i<$now;$i++)
                                                    {{----}}
                                                    <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                                @endfor
                                            @endif
                                        @endif
                                        <strong style="color: red"><a href="webPage?pageid={{$now}}" class="btn btn-dark">{{$now}}</a></strong>
                                        @if($now+5 <$count )
                                            @if($count-$now<5)
                                                @for($i=$now+1;$i<=10;$i++)
                                                    <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                                @endfor

                                            @elseif($now<=5)
                                                @if($count>=10)
                                                    @for($i=$now+1;$i<=10;$i++)
                                                        <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                                    @endfor
                                                @else
                                                    @for($i=$now+1;$i<=$count;$i++)
                                                        <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                                    @endfor
                                                @endif

                                                {{--@elseif--}}
                                                {{--                @if($count)--}}

                                            @else
                                                @for($i=$now+1;$i<$now+6;$i++)
                                                    <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                                @endfor
                                            @endif

                                        @else
                                            @for($i=$now+1;$i<=$count;$i++)
                                                <a href="webPage?pageid={{$i}}" class="btn btn-dark">{{$i}}</a>
                                            @endfor
                                        @endif

                                        @if($now !=$count)
                                            <a href="webPage?pageid={{$now+1}}" class="btn btn-dark">下一页</a>
                                        @endif
                                        <a href="webPage?pageid={{$count}}" class="btn btn-dark">尾页</a>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
