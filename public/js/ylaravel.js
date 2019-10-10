var editor = new wangEditor('content');
/*var E = window.wangEditor
var editor = new E('#content')*/

editor.config.uploadImgUrl = '/posts/image/upload';

// 设置 headers（举例）
editor.config.uploadHeaders = {
    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
};

editor.create();