<?php

/**
 * @var $this yii\web\View
 * @var $model \common\modules\adverts\models\ar\Advert
 */

use common\modules\adverts\AdvertsModule;

$this->title = AdvertsModule::t('Редактирование объявления');

?>

<?php if (Yii::$app->session->getFlash('success')): ?>
    <div class="alert alert-success text-center">
        <?= AdvertsModule::t('Объявление успешно изменено.'); ?>
    </div>
<?php endif ?>

<?= $this->render('_form', compact('model', 'templet')) ?>