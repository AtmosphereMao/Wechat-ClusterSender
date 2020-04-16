<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    {{--<meta http-equiv=Content-Type content=“text/html;charset=utf-8″>--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">--}}

    {{--<meta name="spm-id" content="a21bo">--}}
    {{--<meta name="renderer" content="webkit">--}}
    {{--<meta name="aplus-xplug" content="none">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}

    <title>{{$Name}},{{$WebPage_User->page_title}}</title>
    <link rel="stylesheet" type="text/css" href="{{url('css/emoji.css')}}">
    <script src="{{url('jquery/jquery.min.js')}}"></script>
    <script src="{{url('jquery/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('org/html2canvas/html2canvas.min.js')}}"></script>
    <script>


    </script>


    <link href="{{url('webpage-css')."/".$WebPage_Css->html_filename."/".$WebPage_Css->js_filename}}.css?version=1.0.1" rel="stylesheet" type="text/css">
    <script src="{{url('webpage-css')."/".$WebPage_Css->html_filename."/".$WebPage_Css->js_filename}}.js?version=1.0.2"></script>
    <meta charset="utf-8">
</head>
<body background="{{url('webpage-background')."/".$Background_create."/".$WebPage_User->page_background}}">
<div class="wrap">
    <audio src="{{url('webpage-css')."/".$WebPage_Css->html_filename}}/bainian.mp3" autoplay loop></audio>
    <div class="heng_left"></div>
    <div class="heng_right"></div>
    <div class="deng"></div>
    <div class="lihua"></div>
    <div class="tips">
        今天是<script type="text/javascript">
            var day="";
            var month="";
            var year="";
            mydate=new Date();
            mymonth=mydate.getMonth()+1;
            myday= mydate.getDate();
            myyear= mydate.getYear();
            year=(myyear > 200) ? myyear : 1900 + myyear;
            document.write(year+"年"+mymonth+"月"+myday+"日 ");</script><script language="JavaScript">
            var urodz= new Date("1/28/2018");
            var s="春节";
            var now = new Date();
            var ile = urodz.getTime() - now.getTime();
            var dni = Math.floor(ile / (1000 * 60 * 60 * 24))+1;
            if (dni > 1)
                document.write("离"+s+"还有"+dni +"天 ")
            else if (dni == 1)
                document.write("明天就"+s+"啦！")
            else if (dni == 0)
                document.write(""+s+"！")
            else
                document.write("祝福永远不晚！");
        </script>
    </div><div class="clear"></div>
    <div class="title">
        {{$Name}}<br>
        {{$WebPage_User->page_title}}
    </div><div class="clear"></div>
    <div class="gif">
        <img src="{{url('webpage-css')."/".$WebPage_Css->html_filename}}/1.gif" alt="年年有余" />
        <img src="{{url('webpage-css')."/".$WebPage_Css->html_filename}}/2.gif" alt="心想事成" />
        <img src="{{url('webpage-css')."/".$WebPage_Css->html_filename}}/3.gif" alt="恭喜发财" />
        <img src="{{url('webpage-css')."/".$WebPage_Css->html_filename}}/4.gif" alt="大吉大利" />
    </div><div class="clear"></div>
    <div class="zhufu">
        {!!$WebPage_Content!!}
    </div>
    <div class="create_user"><p style="float: right;margin-right: 100px;">{{$Create_user}}</p></div>
    <div class="clear"></div>
    <div class="clear"></div>
    <div class="copyright">
        CopyRight &copy; 2018 <a href="#" target="_blank">P I E.com</a> Theme by <a href="#" target="_blank">P I E</a>
    </div>


</div>

</body>
</html>
