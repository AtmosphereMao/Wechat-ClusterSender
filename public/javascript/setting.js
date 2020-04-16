$(document).ready(function() {
    var content_pass = 0;
    var background_pass = 0;
    $.extend({
        StandardPost: function (url, args) {
            var form = $("<form method='post'></form>"),
                input;
            form.attr({"action": url});
            //CSRF防护
            form.append("<input type=\"hidden\" name=\"_token\" value=\"" + $('meta[name="csrf-token"]').attr('content') + "\">");
            $.each(args, function (key, value) {
                input = $("<input type='hidden'>");
                input.attr({"name": key});
                input.val(value);
                form.append(input);
            });
            form.submit();
        }
    });


    var url = window.location.host;
    $('#upload').uploadify({
        auto:true,
        multi:false,
        fileTypeExts:'*.jpg;*.jpeg;*.png;',
        fileSizeLimit:32768,
        formData     : {
            '_token'     : $('meta[name="csrf-token"]').attr('content')
        },
        buttonText:'上传图片',
        showUploadedPercent:true,//是否实时显示上传的百分比，如20%
        showUploadedSize:true,
        removeTimeout:9999999,
        uploader: "setting/uploadfile",
        onUploadStart:function(){
            //alert('开始上传');
        },
        onUploadSuccess:function(file, data, response){
            if(data =="上传失败")
            {
                alert('上传失败');
            }else if(data =="上次成功")
            {
                alert('上次成功');
                $.ajax({
                    type: "POST",
                    url: "setting",
                    data: { '_token': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        $(".panel-body").html(result);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $(".panel-body").html("there is something wrong!");
                        alert("出错！！请稍候尝试："+XMLHttpRequest.status);
                        // alert(XMLHttpRequest.readyState);
                        // alert(textStatus);
                    }
                });
            }


            // $(".upload_state span").html("已上传");
            // $(".upload_time span").html(parseInt($(".upload_time span").html())+1);
            //
            // alert('上传成功');
            // $("#upload").before("<input class='filename' type='hidden' value="+data+">");
        },
        onUploadError:function (file,data) {
            switch(data.status){
                case "302":
                    alert("只允许上传jpg,png文件");
                    break;
                case "500":
                    alert("文件大小不能超过5MB");
                    break;
            }
        }
    });




    $("#wxinfo_table_submit").click(function () {
        if(sessionStorage.getItem("wxinfo_keys")==null){
            if (!($(".WarningMsg").length > 0)) {
                $('#wxinfo_setting').before("<p class=\"WarningMsg\">请选择朋友</p>");
                return false;
            }
            $(".WarningMsg").remove();
            $('#wxinfo_setting').before("<p class=\"WarningMsg\">请选择朋友</p>");
            return false;
        }

        if($(".page_title").val()==""){
            if (!($(".WarningMsg").length > 0)) {
                $('#wxinfo_setting').before("<p class=\"WarningMsg\">请填写标题</p>");
                return false;
            }
            $(".WarningMsg").remove();
            $('#wxinfo_setting').before("<p class=\"WarningMsg\">请填写标题</p>");
            return false;
        }
        if(!($("input[name=page_content]:checkbox:checked").val()=="on"))
        {
            if (!($(".WarningMsg").length > 0)) {
                $('#wxinfo_setting').before("<p class=\"WarningMsg\">请选择内容</p>");
                return false;
            }
            $(".WarningMsg").remove();
            $('#wxinfo_setting').before("<p class=\"WarningMsg\">请选择内容</p>");
            return false;
        }
        if(!($("input[name=page_css]:checked").val()=="on")){
            if (!($(".WarningMsg").length > 0)) {
                $('#wxinfo_setting').before("<p class=\"WarningMsg\">请选择样式</p>");
                return false;
            }
            $(".WarningMsg").remove();
            $('#wxinfo_setting').before("<p class=\"WarningMsg\">请选择样式</p>");
            return false;
        }
        if(!($("input[name=page_background]:checked").val()=="on")) {
            if (!($(".WarningMsg").length > 0)) {
                $('#wxinfo_setting').before("<p class=\"WarningMsg\">请选择背景</p>");
                return false;
            }
            $(".WarningMsg").remove();
            $('#wxinfo_setting').before("<p class=\"WarningMsg\">请选择背景</p>");
            return false;
        }
        var content = new Array();
        $("input[name=page_content]:checkbox:checked").each(function(){
            content.push($(this).parent('div').attr('name'));
        });
        // alert($("input[name=page_background]:checked").parent('div').attr('name'));

        StandardPost('submit', {
            key : sessionStorage.getItem("wxinfo_keys") ,
            page_title : $(".page_title").val() ,
            page_content : content ,
            page_css : $("input[name=page_css]:checked").parent('div').attr('name') ,
            page_background :  $("input[name=page_background]:checked").parent('div').attr('name')
        });
    });


    $("#wxinfo_table_back").click(function () {
        window.location.href = "choose";
        return;
    });

    $("#content_add").click(function(){
        window.location.href="setting/content/add";
    });

    $("img").click(function(){
        var fileUrl = $(this).prop('src');
        showImage(true,fileUrl);
    });

    $(".content_name").dblclick(function () {
        $(this).removeAttr("readonly");
        content_pass = 1;
    });

    $(".content_name").blur(function () {
        if(content_pass==0)
        {
            return false;
        }
        if($(this).val().length>8)
        {
            alert('内容名最大限制8个字符');
            return false;
        }
        $(this).attr("readonly","readonly");

        if($(this).val()!=$(this).attr('name'))
        {
            $.ajax({
                type: "POST",
                url: "setting/content/update",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id' : $(this).parent('div').attr('name'),
                    'updateName' : $(this).val()
                },
                success: function(result){
                    alert(result);
                    $.ajax({
                        type: "POST",
                        url: "setting",
                        data: { '_token': $('meta[name="csrf-token"]').attr('content')},
                        success: function(result){
                            content_pass = 0;
                            $(".panel-body").html(result);

                        }
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $(".panel-body").html("there is something wrong!");
                    alert("出错！！请稍候尝试："+XMLHttpRequest.status);
                    // alert(XMLHttpRequest.readyState);
                    // alert(textStatus);
                }
            });
        }
    });

    $(".background_name").dblclick(function () {
        $(this).removeAttr("readonly");
        background_pass = 1;
    });
    $(".background_name").blur(function () {
        if(background_pass ==0)
        {
            return false;
        }
        if($(this).val().length>8)
        {
            alert('背景名最大限制8个字符');
            return false;
        }
        $(this).attr("readonly","readonly");

        if($(this).val()!=$(this).attr('name'))
        {
            $.ajax({
                type: "POST",
                url: "setting/background/update",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'fileName' : $(this).parent('div').attr('name'),
                    'updateName' : $(this).val()
                },
                success: function(result){
                    alert(result);
                    $.ajax({
                        type: "POST",
                        url: "setting",
                        data: { '_token': $('meta[name="csrf-token"]').attr('content')},
                        success: function(result){
                            background_pass = 0;
                            $(".panel-body").html(result);
                        }
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $(".panel-body").html("there is something wrong!");
                    alert("出错！！请稍候尝试："+XMLHttpRequest.status);
                    // alert(XMLHttpRequest.readyState);
                    // alert(textStatus);
                }
            });
        }
    });


});

function deleteContent(fileName){
    var flag = confirm("真的要删除吗");
    if(flag == true){
        var id = $(fileName).parent('div').attr('name');
        $.post("setting/content/delete",{'_method':'delete','_token':$('meta[name="csrf-token"]').attr('content'),'id' : id},function (data) {
            if(data.status==0){
                alert(data.msg);
                $.ajax({
                    type: "POST",
                    url: "setting",
                    data: { '_token': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        $(".panel-body").html(result);
                    }
                 });
            }else{
                alert(data.msg);
            }
        });
    }

};


function deleteBackground(fileName){
    var flag = confirm("真的要删除吗");
    var fileName = $(fileName).parent('div').attr('name');
    if(flag == true){
        // $.StandardPost('setting/background/delete', {fileName: fileName});
        $.ajax({
            type: "POST",
            url: "setting/background/delete",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'fileName' : fileName
            },
            success: function(result){
                alert(result);
                $.ajax({
                    type: "POST",
                    url: "setting",
                    data: { '_token': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        $(".panel-body").html(result);
                    }
                });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $(".panel-body").html("there is something wrong!");
                alert("出错！！请稍候尝试："+XMLHttpRequest.status);
                // alert(XMLHttpRequest.readyState);
                // alert(textStatus);
            }
        });
    }

};




function preView(cssName){
    var cssName = $(cssName).parent('div').attr('name');
    window.location.href="setting/css/snapshot?cssName="+cssName;
}


function showImage(isShow,fileUrl){
    var state = "";
    if(isShow){
        state = "block";
    }else{
        state = "none";
    }
    var pop = document.getElementById("pop");
    pop.style.display = state;
    $('#pop img').attr("src",fileUrl);
    var lightbox = document.getElementById("lightbox");
    lightbox.style.display = state;
}
function close(){
    showImage(false);
}


function StandardPost(url, args) {
    var form = $("<form method='post'></form>"),
        input;
    form.attr({"action": url});
    //CSRF防护
    form.append("<input type=\"hidden\" name=\"_token\" value=\"" + $('meta[name="csrf-token"]').attr('content') + "\">");
    $.each(args, function (key, value) {
        input = $("<input type='hidden'>");
        input.attr({"name": key});
        input.val(value);
        form.append(input);
    });
    $("body").append(form);
    form.submit();
}