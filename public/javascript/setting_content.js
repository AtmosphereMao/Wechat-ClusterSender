
$(document).ready(function() {
    var ue=UE.getEditor("content");
    $("input[type='submit']").click(function(){
        var ue=UE.getEditor("content");
        if(ue.getContentTxt()=="") {
            if (!($(".WarningMsg").length > 0)) {
                $('form').before("<p class=\"WarningMsg\">请输入内容</p>");
                return false;
            }
            $(".WarningMsg").remove();
            $('form').before("<p class=\"WarningMsg\">请输入内容</p>");
            return false;
        }
        else{
            if(ue.getContentTxt().length>500)
            {
                if (!($(".WarningMsg").length > 0)) {
                    $('form').before("<p class=\"WarningMsg\">请勿超过500字</p>");
                    return false;
                }
                $(".WarningMsg").remove();
                $('form').before("<p class=\"WarningMsg\">请勿超过500字</p>");
                return false;
            }
            return true;
        }


    });
    $("#wxinfo_table_back").click(function () {
        window.location.href = "../../choose";
        return;
    });


});
