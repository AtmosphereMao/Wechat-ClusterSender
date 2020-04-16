$(document).ready(function () {
    $("#all").change(function () {
        var flag = $(this).is(":checked");
        $("input[type=checkbox]").each(function () {
            $(this).prop("checked", flag);
        })
    });
});
function WebPageDelete(page_id) {

    layer.confirm('\'确定要删除这个页面吗',{
        btn: ['确定','取消']
    },function () {
        $.post('webPage/delete', {
            '_method': 'delete',
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'part': page_id
        }, function (data) {
            if (data.status == 0) {
                layer.msg(data.msg, {icon: 6, time: 800});
                setTimeout(function () {
                    location.href = location.href;
                }, 800);
            } else {
                layer.msg(data.msg, {icon: 5, time: 800});
            }
        });
    });
}

function WebPageMostDelete() {

    layer.confirm('确定要删除所选的页面吗',{
        btn: ['确定','取消']
    },function () {
        var page_id = new Array();
        $("input[name=checkbox]:checkbox:checked").each(function(){
            page_id.push($(this).val());
        });
        if(page_id=='')
        {
            layer.msg("删除失败，请选择页面", {icon: 5, time: 800});
            return false;
        }
        page_id = JSON.stringify(page_id);
        $.post('webPage/delete', {
            '_method': 'delete',
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'part': page_id
        }, function (data) {
            if (data.status == 0) {
                layer.msg(data.msg, {icon: 6, time: 800});
                setTimeout(function () {
                    location.href = location.href;
                }, 800);
            } else {
                layer.msg(data.msg, {icon: 5, time: 800});
            }
        });
    });
}