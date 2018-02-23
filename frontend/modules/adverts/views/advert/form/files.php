<?php

use common\modules\core\widgets\Spaceless;

use common\modules\core\widgets\FileUpload;

/**
 * @var \common\modules\adverts\models\ar\Advert $model
 * @var \common\modules\adverts\models\ar\AdvertTemplet $templet
 * @var \yii\web\View $this
 */

?>

<?php
    $urlParam = Yii::$app->security->generateRandomString(8);
    $deleteUrlParam = Yii::$app->security->generateRandomString(8);
    $imgTemplate = Spaceless::widget([
        'text' => $this->render('_file-container', [
            'urlParam' => $urlParam,
            'deleteUrlParam' => $deleteUrlParam
        ])
    ]);
?>

<?= FileUpload::widget([
    'model' => !$model->isNewRecord ? $model : $templet,
    'attribute' => 'files',
    'plus' => true,
    'url' => [
        'file-upload',
        'id' => !$model->isNewRecord ? $model->id : $templet->id,
        'owner' => !$model->isNewRecord ? $model::className() : $templet::className(),
    ],
    'clientOptions' => [
        'accept' => 'image/*',
        'acceptFileTypes' => '/(\.|\/)(gif|jpe?g|png)$/i',
        'dataType' => 'json',
        'getFilesFromResponse' => true,
        'maxFileSize' => 1024 * 1024 * 5,
        'multiple' => 'multiple',
        'messages' => [
            'maxNumberOfFiles' => 'Можно загрузить максимум 3 файла.',
            'acceptFileTypes' => 'Поддерживаемые форматы файлов: png, jpeg, jpg',
            'maxFileSize' => 'Загрузите файл не более 5МБайт',
        ],
    ],
    // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
    'clientEvents' => [
        'fileuploadadd' => "function(e, data) {
                    
}",
        'fileuploadprogressall' => "function(e, data) {
    $('#files-progressbar').progressbar({
        value: parseInt(data.loaded / data.total * 100, 10)
    });
}",
        'fileuploaddone' => "function(e, data) {
    if (data.result.success && data.result.file) {
        var file = data.result.file;
        var template = '{$imgTemplate}';
        template = template.replace(/{$urlParam}/g, file.url);
        template = template.replace(/{$deleteUrlParam}/g, file.deleteUrl);
        $('[data-action=files-list]').append(template);
        $('.files-list .files-empty').hide();
        $('.file-uploaded-success').css('display', 'inline').delay(4000).animate({
            opacity: 0
        }, 2000, function() {
            $('.file-uploaded-success').css('display', '')
        });
        $('.file-uploaded-fail').hide();
    } else if (data.result.errors && data.result.errors.owner_id) {
        $('.file-uploaded-fail').html(data.result.errors.owner_id).css('display', 'inline');
    }
    $('#files-progressbar').progressbar({
        value: 0
    });
}",
        'fileuploadfail' => "function(e, data) {
    $('#files-progressbar').progressbar({
        value: parseInt(0, 10)
    });
    alert('Ошибка загрузки файла. Пожалуйста, попробуйте еще раз');
}",
        'fileuploadprocess' => "function(e, data) {
    $('.file-uploaded-fail').html('').hide();
                }",
        'fileuploadprocessfail' => "function(e, data) {
    var file = data.files[0];
    if (file.error) {
        $('.file-uploaded-fail').html(file.error).show();
    }
                }",
    ],
]); ?>