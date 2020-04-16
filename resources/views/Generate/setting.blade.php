<script type="text/javascript" src="{{asset('org/uploadify/jquery.uploadify.js?version=1.0.6')}}"></script>
<script type="text/javascript" src="{{asset('javascript/setting.js?version=1.0.1')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}"/>

{{--<link rel="stylesheet" type="text/css" href="{{asset('css/common.css?version=1.0.1')}}">--}}
<link rel="stylesheet" type="text/css" href="{{asset('css/setting.css?version=1.0.1')}}">

<div id="wxinfo_setting">

    <input type="button" id="wxinfo_table_submit" class="btn btn-success" style="margin-left: 10px;" value="提交" >
    <input type="button" id="wxinfo_table_back" class="btn btn-info" style="margin-left:10px;" value="上一步" ><br><br>

    <div class="lightbox" id="lightbox" onClick="window.location.href='javascript:close()'"></div>
    <div id="pop" class="pop" style="display: none;">
        <img src="">
    </div>

    <div class="wxinfo_setting_box">

        <div class="wxinfo_setting_content">
            <h4 class="content_title">标题</h4>
            <input type="text" name="page_title" class="page_title">
        </div>
        </div>

        <div class="wxinfo_setting_content">
            <h4 class="content_title">内容<span style="font-size: 10px;margin-left: 10px;">可多选，多选后将每位朋友的内容都是随机的</span></h4>
            @forelse($Page_Content as $value)
                <div id="content_box" >
                    <div id="content_text">
                        {!!$value->content_text!!}
                    </div>
                    <div id="content_function" name="{{$value->id}}">
                        <input type="checkbox" name="page_content"><input class="content_name" readonly="readonly" name="{{$value->content_name}}" value="{{$value->content_name}}">
                        <a class="content_delete" onclick="deleteContent(this)">删除</a>
                    </div>
                </div>

            @empty
                <p style="font-weight: bold">没有数据</p>
            @endforelse
            <div id="content_upload">
            <input type="button" id="content_add" value="添加内容" class="btn btn-info">
            </div>
        </div>

        <div class="wxinfo_setting_content">
            <h4 class="content_title">样式</h4>

            @forelse($Page_CSS as $value)
                <div id="css_box" >
                    <img class="css_image" src="../../{{$value->snapshot_filename}}.png" >
                    <div id="css_function" name="{{$value->html_filename}}">
                         <input type="radio" name="page_css"><span class="css_name">{{$value->css_name}}</span>
                         <a class="css_preview" onclick="preView(this)">预览</a>
                    </div>
                </div>

                @empty
                <p>没有数据</p>
                @endforelse

        </div>

        <div class="wxinfo_setting_content">
            <h4 class="content_title">背景</h4>
            <div class="background_public">
            <h4>官方背景</h4>
            @forelse($Page_Background as $value)
                <div id="background_box">
                    <img class="background_image" src="../webpage-background/official/{{$value->image_filename}}" >
                    <div id="background_function" name="{{$value->image_filename}}">
                        <input type="radio" name="page_background"><span class="background_name">{{$value->image_name}}</span>
                    </div>
                </div>
                @empty
                <p>没有数据</p>
            @endforelse
            </div>

            <div class="background_private">
            <h4>个人背景 <span style="font-size: 10px;margin-left: 10px;">双击文件名可更名</span></h4>
            @forelse($Page_Background_User as $value)
                <div id="background_box">
                    <img class="background_image" src="../webpage-background/{{Auth::user()->name}}/{{$value->image_filename}}" >
                    <div id="background_function"  name="{{$value->image_filename}}">
                        <input type="radio" name="page_background"><input type="text" readonly="readonly" class="background_name" name="{{$value->image_name}}" value="{{$value->image_name}}">
                        <a class="background_delete" onclick="deleteBackground(this)">删除</a>
                    </div>
                </div>
                @empty
                    <p style="font-weight: bold;">没有数据</p>
            @endforelse

                <div id="background_upload">
                    <h4>个人背景 - 上传</h4>

                    <div id="upload"></div>
                </div>
            </div>
        </div>

    </div>
    <input type="button" id="wxinfo_table_submit" value="提交" style="float: right;" >