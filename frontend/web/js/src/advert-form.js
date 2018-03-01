jQuery(function ($) {;

    //
    $(document).on('click', "#button-group-type label", function (event) {
        var self = $(this),
            btnGroup = self.parent();

        btnGroup.find('label').removeClass('active');
        self.addClass('active')

        btnGroup.find('input[name=type]').attr('value', self.attr('data-value')).trigger('change');
    });
    $(document).on('click', "#button-group-currency label", function (event) {
        var self = $(this),
            btnGroup = self.parent();

        btnGroup.find('label').removeClass('active');
        self.addClass('active')

        btnGroup.find('input[name=currency_id]').attr('value', self.attr('data-value')).trigger('change');
    });

    //
    $('#category_id').multiselectPopup(multiselectPopupCategoryOptions);
    $('#geography_id').multiselectPopup(multiselectPopupGeographyOptions);

    //
    if (jQuery('#expiry_at').data('datetimepicker')) {
        jQuery('#expiry_at').datetimepicker('destroy');
    }
    jQuery("#expiry_at-datetime").datetimepicker(datetimepicker_89119b01);

    //
    jQuery('#files-progressbar').progressbar();
    jQuery('#files').fileupload({
        "accept": "image/*",
        "acceptFileTypes": "/(\\.|\\/)(gif|jpe?g|png)$/i",
        "dataType": "json",
        "getFilesFromResponse": true,
        "maxFileSize": 5242880,
        "multiple": "multiple",
        "messages": {
            "maxNumberOfFiles": "Можно загрузить максимум 3 файла.",
            "acceptFileTypes": "Поддерживаемые форматы файлов: png, jpeg, jpg",
            "maxFileSize": "Загрузите файл не более 5МБайт"
        },
        "url": "/adverts/advert/file-upload?id=2&owner=common%5Cmodules%5Cadverts%5Cmodels%5Car%5CAdvertTemplet"
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
            var template = '<div class="file-container" data-action="file-container"><img class="img-thumbnail" src="3oEMk-Bn" alt=""><div class="file-delete visible" data-action="file-delete" data-url="/adverts/advert/file-delete?id=OeRd1Zie"><i class="glyphicon glyphicon-remove"></i></div><div class="file-deleting" data-action="file-deleting"><i class="fa fa-refresh fa-spin"></i></div></div>';
            template = template.replace(/3oEMk-Bn/g, file.url);
            template = template.replace(/OeRd1Zie/g, file.deleteUrl);
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
    jQuery('#advert-form').yiiActiveForm(yiiActiveFormAdvertFormAttributesAttributes, yiiActiveFormAdvertFormAttributesOptions);
    jQuery('#advert-form').on('ajaxSubmitComplete', function (event, jqXHR) {
        var url = jqXHR.getResponseHeader('X-Reload-Url');
        if (url) {

        }
    });
    jQuery('#advert-form').on('ajaxComplete', function (data) {
        $.ajax({
            url: '/adverts/advert/save-templet',
            method: 'post',
            data: $(this).serialize(),
            success: function (data, textStatus, jqXHR) {

            },
            error: function () {
                alert('Ошибка, данные объявления не сохранилиь автоматически!');
            }
        });
    });
    jQuery('#advert-form').on('click', '[data-action=file-delete]', function () {
        var self = $(this);
        var img = self.prev();
        var container = self.parent();
        container.css('width', img.css('width')).css('height', img.css('height'));
        container.find('[data-action=file-deleting]').show();
        self.removeClass('visible');
        $.ajax({
            url: self.attr('data-url'),
            success: function (data, textStatus, jqXHR) {
                self.prev().animate({
                    width: 0
                }, 300, function () {
                    self.parents('.file-container').remove();
                });
                $('.files-list .files-empty').show();
            },
            error: function () {
                alert('error. Посмотри firebug!');
            }
        });
        return false;
    });
});