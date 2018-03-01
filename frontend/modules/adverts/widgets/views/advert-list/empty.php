<?php

use common\modules\adverts\widgets\AdvertList;
use common\modules\adverts\models\search\AdvertSearch;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var AdvertList $widget
 * @var string $text
 */

?>

<?= Html::beginTag($tag, $widget->options); ?>
    <div class="row">
        <div class="text-center">
            <b><?= $text ?></b>
        </div>
    </div>
<?= Html::endTag($tag); ?>