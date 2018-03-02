<?php

use common\modules\core\widgets\Spaceless;
use yii\jui\ProgressBar;

/**
 * @var \common\modules\adverts\models\ar\Advert $model
 * @var \common\modules\adverts\models\ar\AdvertTemplet $templet
 * @var \common\modules\core\web\View $this
 */

?>

<div class="row mt-30">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="files-list" data-action="files-list">
            <?php
            $files = !$model->isNewRecord ? $model->files : $templet->files;
            ?>
            <?php if ($files): ?>
                <?php /** @var $file \common\modules\core\models\ar\File */ ?>
                <?php foreach ($files as $file): ?>
                    <?= $this->render('_fileupload-file-container', [
                        'model' => $file
                    ]); ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="files-empty" style="<?= $files ? 'display: none' : '' ?>"><?= Yii::t('app', 'Не загружено ни одного файла...'); ?></div>
        </div>

        <?= ProgressBar::widget([
            'options' => [
                'id' => 'files-progressbar',
                'class' => 'files-progressbar',
            ]
        ]); ?>
    </div>
</div>

<div id="advert-form-img-tmpl" style="display: none">
    <?= Spaceless::widget(['text' => $this->render('_fileupload-file-container')]); ?>
</div>