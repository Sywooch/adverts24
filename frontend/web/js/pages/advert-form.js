;jQuery('#files').fileupload({
    "accept": "image/*",
    "acceptFileTypes": '',
    "dataType": "json",
    "getFilesFromResponse": true,
    "maxFileSize": 5242880,
    "multiple": "multiple",
    "messages": {
        "maxNumberOfFiles": "Можно загрузить максимум 3 файла.",
        "acceptFileTypes": "Поддерживаемые форматы файлов: png, jpeg, jpg",
        "maxFileSize": "Загрузите файл не более 5МБайт"
    }
    ,
    "url": "/adverts/advert/file-upload?id=3&owner=app%5Cmodules%5Cadverts%5Cmodels%5Car%5CAdvertTemplet"
});
jQuery('#files').on('fileuploadadd', function (e, data) {

});
jQuery('#files').on('fileuploadprogressall', function (e, data) {
    $('#files-progressbar').progressbar({
        value: parseInt(data.loaded / data.total * 100, 10)
    });
});
jQuery('#files').on('fileuploaddone', function (e, data) {
    if (data.result.success && data.result.file) {
        var file = data.result.file;
        var template = '<div class="file-container" data-action="file-container"><img class="img-thumbnail" src="xafiLjm_" alt=""><div class="file-delete visible" data-action="file-delete" data-url="/adverts/advert/file-delete?id=FQu3dIH6"><i class="glyphicon glyphicon-remove"></i></div><div class="file-deleting" data-action="file-deleting"><i class="fa fa-refresh fa-spin"></i></div></div>';
        template = template.replace(/xafiLjm_/g, file.url);
        template = template.replace(/FQu3dIH6/g, file.deleteUrl);
        $('[data-action=files-list]').append(template);
        $('.files-list .files-empty').hide();
        $('.file-uploaded-success').css('display', 'inline').delay(4000).animate({
            opacity: 0
        }, 2000, function () {
            $('.file-uploaded-success').css('display', '')
        });
        $('.file-uploaded-fail').hide();
    } else if (data.result.errors && data.result.errors.owner_id) {
        $('.file-uploaded-fail').html(data.result.errors.owner_id).css('display', 'inline');
    }
    $('#files-progressbar').progressbar({
        value: 0
    });
});
jQuery('#files').on('fileuploadfail', function (e, data) {
    $('#files-progressbar').progressbar({
        value: parseInt(0, 10)
    });
    alert('Ошибка загрузки файла. Пожалуйста, попробуйте еще раз');
});
jQuery('#files').on('fileuploadprocess', function (e, data) {
    $('.file-uploaded-fail').html('').hide();
});
jQuery('#files').on('fileuploadprocessfail', function (e, data) {
    var file = data.files[0];
    if (file.error) {
        $('.file-uploaded-fail').html(file.error).show();
    }
});