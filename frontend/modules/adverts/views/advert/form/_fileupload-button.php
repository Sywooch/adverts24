<?php

use common\modules\adverts\models\ar\Advert;
use common\modules\core\widgets\FileUpload;

/**
 * @var \common\modules\adverts\models\ar\Advert $model
 * @var \common\modules\adverts\models\ar\AdvertTemplet $templet
 * @var \common\modules\core\web\View $this
 */

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
        'maxFileSize' => Advert::MAX_FILE_SIZE,
        'maxNumberOfFiles' => Advert::MAX_FILES,
        'multiple' => 'multiple',
        'messages' => [
            'maxNumberOfFiles' => 'Можно загрузить максимум 3 файла.',
            'acceptFileTypes' => 'Поддерживаемые форматы файлов: gif, png, jpeg, jpg',
            'maxFileSize' => 'Размер не более 5МБайт',
        ],
    ],
]); ?>

<span class="file-uploaded-success">Файл загружен</span>
<span class="file-uploaded-fail">Произошла ошибка при загрузке файла</span>