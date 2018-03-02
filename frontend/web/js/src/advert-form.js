jQuery(function ($) {
    // price
    $('#advert-form').on('blur', '[name=min_price], [name=max_price]', function(event) {
        var currencyField = $('#advert-form .field-currency_id')
        form = $('#advert-form');
        if (!form.find('[name=min_price]')[0].value && !form.find('[name=max_price]')[0].value) {
            currencyField.fadeOut(1000);
        } else {
            currencyField.fadeIn(1000);
        }
    });

    // files uploading
    $('#files-progressbar').progressbar();

    $('#files').fileupload('option', 'getNumberOfFiles', function() {
        return $('#advert-form .files-list .file-container').length;
    });

    $('#files').on('fileuploaddone', function (e, data) {
        if (data.result.success && data.result.file) {
            var file = data.result.file;
            var template = $($('#advert-form-img-tmpl').html());
            template.find('img.img-thumbnail').attr('src', file.url);
            template.find('.file-delete').attr('data-url', file.delete_url);
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

    $('#files').on('fileuploadprocess', function (e, data) {
        $('.file-uploaded-fail').html('').hide();
    });

    $('#files').on('fileuploadprogressall', function (e, data) {
        $('#files-progressbar').progressbar({
            value: parseInt(data.loaded / data.total * 100, 10)
        });
    });

    jQuery('#files').on('fileuploadfail', function (e, data) {
        $('#files-progressbar').progressbar({value: parseInt(0, 10)});
        alert('Ошибка загрузки файла. Пожалуйста, попробуйте еще раз');
    });

    $('#files').on('fileuploadprocessfail', function (e, data) {
        var file = data.files[0];
        if (file.error) {
            $('.file-uploaded-fail').html(file.error).show();
        }
    });

    $('#advert-form').on('click', '[data-action=file-delete]', function () {
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
                    if ($('#advert-form .files-list .file-container').length == 0) {
                        $('#advert-form .files-empty').show();
                    }
                });
            },
        });
        return false;
    });
});