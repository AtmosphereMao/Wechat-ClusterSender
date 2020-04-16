$(document).ready(function () {
    $("#all").change(function () {
        var flag = $(this).is(":checked");
        $("input[type=checkbox]").each(function () {
            $(this).prop("checked", flag);
        })
    });
    if ($('tr').length >= 10)
    {
        $('.wxinfo_friends_content').after('<button type="button" id="more" class="btn btn-primary btn-lg btn-block">加载更多信息</button>');
    }
    $('#more').click(function () {
        // alert($('tr').length);
        $.post('',{
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'count' : $('tr').length
        },function (data) {
            if(data=="")
            {
                $('#more').remove();
                $('.wxinfo_friends_content').append('<center style="margin-top: 10px;" class="text-black-50">已全部显示</center>');
            }
            $('tbody').append(data);
        });
    });
});