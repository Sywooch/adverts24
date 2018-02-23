<?php

/**
 * @var $this yii\web\View
 * @var $model \common\modules\adverts\models\ar\Advert
 */

$this->title = \common\modules\adverts\AdvertsModule::t('Просмотр объявления');

?>

<div class="advert-view">
    <div class="advert-container">
        <?= $this->render('advert/index', [
            'model' => $model,
            'renderPartial' => false,
        ]); ?>
    </div>
</div>