@extends('layouts.app')
@section('title','Generate')
@section('content')
<script type="text/javascript" src="../jquery/jquery-3.2.1.min.js?version=1.0.0"></script>
<script type="text/javascript" src="../javascript/choose.js?version=1.0.1"></script>
<link rel="stylesheet" type="text/css" href="../css/common.css?version=1.0.1">
<link rel="stylesheet" type="text/css" href="{{url('css/emoji.css')}}">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">正在加载设定页面</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Generate Setting</div>

                    <div class="panel-body" >
                        @if(count($errors)>0)
                            <div class="error">
                                @foreach($errors->all() as $error)
                                    <p class="WarningMsg">{{$error}}</p>
                                @endforeach
                            </div>
                        @endif
                        @if(session('msg'))
                            <p class="WarningMsg">{{session('msg')}}</p>
                            @endif
                        {{--@for($i=0;$i<count($wx_array);$i++)--}}
                            {{--@for($a=0;$a<3;$a++)--}}
                                {{--@switch($a)--}}
                                    {{--@case(0)--}}
                                    {{--用户名:{{$wx_array[$i][$a]}}--}}
                                    {{--@break--}}
                                    {{--@case(1)--}}
                                    {{--备注名:{{$wx_array[$i][$a]}}--}}
                                    {{--@break--}}
                                    {{--@case(2)--}}
                                    {{--城市-省:{{$wx_array[$i][$a]}}--}}
                                    {{--@break--}}
                                    {{--@default--}}
                                    {{--城市-市:{{$wx_array[$i][$a]}}<br/>--}}
                                {{--@endswitch--}}
                            {{--@endfor--}}
                        {{--@endfor--}}
                        <div id="wxinfo_friends">
                            <input type="checkbox" id="all" style="width: 18px; height: 18px;" /> 全选
                            <input type="button" id="wxinfo_table_next" value="下一步" class="btn btn-info">
                            <div class="wxinfo_friends_content">
                                <table class="table wxinfo">

                                    <tr>
                                        <th></th>
                                        <th>用户名:</th>
                                        <th>备注名:</th>
                                        <th>城市-省:</th>
                                        <th>城市-市:</th>
                                    </tr>
                            {{--@for($i=0;$i<count($wx_array);$i++)--}}
                                {{--<tr>--}}
                                {{--@for($a=0;$a<=3;$a++)--}}
                                        {{--<th> <input type="checkbox"  id="wxinfo_table_check" name="checkbox" value="{{$i}}" style="width: 18px; height: 18px;" /></th>--}}
                                    {{--@if($a==0)--}}
                                            {{--<th>{!!$wx_array[$i][$a]!!}</th>--}}
                                        {{--@elseif($a==1)--}}
                                            {{--<th> {!!$wx_array[$i][$a]!!}</th>--}}
                                            {{--@elseif($a==2)--}}
                                            {{--<th> {!!$wx_array[$i][$a]!!}</th>--}}
                                            {{--@elseif($a==3)--}}
                                            {{--<th>{!!$wx_array[$i][$a]!!}</th></tr>--}}
                                    {{--@endif--}}
                                {{--@endfor--}}
                            {{--@endfor--}}
                                    <?php $count = 0?>
                            @forelse($wx_array as $item)
                                <tr>
                                    <th> <input type="checkbox"  id="wxinfo_table_check" name="checkbox" value="{{$count++}}" style="width: 18px; height: 18px;" /></th>
                                    @foreach($item as $value)
                                        <th>{!!$value!!}</th>
                                    @endforeach
                                </tr>
                            @empty
                                    <tr>没有数据</tr>
                            @endforelse

                                </table></div>

                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
