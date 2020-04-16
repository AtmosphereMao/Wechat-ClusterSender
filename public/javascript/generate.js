$(document).ready(function() {
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
            $(document.body).append(form);
            form.submit();
        }
    });
    $("#login-choose").click(function(){
        window.location.href = "generate/choose";
        return;
    });
    $("#login-qrcode").click(function () {
        $(this).attr("disabled", "disabled");
        htmlobj = $.ajax({
            url: "generate/login",
            async: false
        });
        if (htmlobj.responseText.length > 100) {
            window.location.href = "generate";
            return;
        }
        $("#qrcode").show();
        $("#qrcode").html("<img src='https://login.weixin.qq.com/qrcode/" + htmlobj.responseText + "'><p class=\"qrcode-message\" style=\"margin-top: 10px;\">请扫描二维码登录</p>");
        $.get('generate/validation/' + htmlobj.responseText, function (resulf) {
            var data = eval('(' + resulf + ')');
            $("#qrcode").append("<p id='qrcoderesulf'>" + data[3] + "</p>");
            if ($("#qrcoderesulf").text() == " 正在登录...") {
                setTimeout(function () {
                    $.StandardPost('generate/loading', {base_uri: data[0], redirect_uri: data[1], push_uri: data[2]});
                }, 1000);
            }
            else {
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            }
        });
    });


});
