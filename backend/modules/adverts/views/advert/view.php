<?php

/**
 * @var $this yii\web\View
 * @var $model \common\modules\adverts\models\ar\Advert
 */

$this->title = \common\modules\adverts\AdvertsModule::t('Просмотр объявления');

use common\modules\adverts\models\ar\Advert;

?>

<div class="advert-view">
    <div class="advert-container">
        <?php if ($model->status !== Advert::STATUS_ACTIVE): ?>
            <?= $this->render('_publish_button', [
                'model' => $model
            ]); ?>
        <?php endif; ?>

        <?= $this->render('@frontend/modules/adverts/views/advert/advert/index', [
            'model' => $model,
            'renderPartial' => false,
        ]); ?>
    </div>
</div>