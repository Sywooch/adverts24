<?php

/**
 * @var \common\modules\adverts\models\ar\Advert $model
 * @var \common\modules\adverts\models\ar\AdvertTemplet $templet
 * @var \common\modules\core\web\View $this
 */

use yii\helpers\Html;

?>

<?php if (Yii::$app->session->getFlash('success')): ?>
    <div class="alert alert-success text-center">
        Ваше объявление сохранено и будет опубликовано после одобрения в кратчайшие сроки!
        <?= Html::a('Добавить еще', '/adverts/advert/create') ?>..
    </div>
<?php else: ?>
    <?= $this->render('form/index', compact('model', 'templet')) ?>
<?php endif ?>