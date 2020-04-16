$(document).ready(function() {
    if(sessionStorage.getItem("wxinfo_keys")!=null)
    {
        var key = sessionStorage.getItem("wxinfo_keys");
        key=JSON.parse(key);
        for(var i=0;i<key.length;i++) {
            $("input[value='"+key[i]+"']").prop('checked', true);

        }
    }

    $("#all").change(function () {
        var flag = $(this).is(":checked");
        $("input[type=checkbox]").each(function () {
            $(this).prop("checked", flag);
            // if ($(this).css('background-color') == 'rgb(255, 255, 255)') {
            //     $(this).css('background-color', '#CCC');
            // } else {
            //     $(this).css('background-color', '#FFF');
            // }
        })
    })
    $("#wxinfo_table_next").click(function(){//输出选中的值
        if(!($("input[name=checkbox]:checkbox").is(":checked")))
        {
            if(!($(".wxinfo_msg").length>0)) {

                $(".wxinfo_friends_content").prepend(" <div class='wxinfo_msg'><p style='color: red;font-weight: bold;'>请选择好友</p></div> ");
                return false;
            }
            return false;
        }
        var key = new Array();
        $("input[name=checkbox]:checkbox:checked").each(function(){
            key.push($(this).val());
        });
        key = JSON.stringify(key);
        sessionStorage.setItem("wxinfo_keys",key);
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

    });


});