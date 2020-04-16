$(document).ready(function() {
    $(".IamButtton").click(function () {
            html2canvas($("body"),{ // $(".myImg")是你要复制生成canvas的区域，可以自己选
                onrendered:function(canvas){
                    dataURL =canvas.toDataURL("image/png");
                    $("body").append(canvas);
                    console.log(dataURL);

                },
                width:320,
                height:400
            });
        });
    });