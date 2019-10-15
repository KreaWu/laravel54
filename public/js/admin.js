$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.post-audit').click(function (event) {
    var target = $(event.target);
    var post_id = target.attr('post-id');
    var status = target.attr('post-action-status');

    $.ajax({
        url: "/admin/posts/" + post_id + "/status",
        method: 'POST',
        data: {'status': status},
        dataType: 'json',
        success: function (data) {
            alert("123");
            if(data.error != 0 ){
                alert(data.msg);
                return;
            }
            target.parent().parent().remove();
        }


    });

})
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//专题删除
$('.resource-delete').click(function (event) {
    if (confirm("确定删除该专题？")===false){
        return;
    }

    var target = $(event.target);
    event.preventDefault();//阻止元素发生默认的行为,即阻止a标签发生页面跳转
    var url = $(target).attr('delete-url');

    $.ajax({
        url: url,
        method: 'POST',
        data: {"_method": 'DELETE'}, //recource中为delete方法
        dataType: "json",
        success: function (data) {
            //alert(data);
            if (data.error != 0){
                alert(data.msg);
                return;
            }
            //target.parent().parent().remove();
            window.location.reload();

        }

    })

})