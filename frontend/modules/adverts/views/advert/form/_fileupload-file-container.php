<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\modules\core\models\ar\File $model
 * @var \common\modules\core\web\View $this
 */

?>

<div class="file-container" data-action="file-container">
    <?= Html::img(!isset($model) ? null : "/uploaded/{$model->file_name}", [
        'class' => 'img-thumbnail'
    ]); ?>

    <?= Html::tag('div', '<i class="glyphicon glyphicon-remove"></i>', [
        'class' => 'file-delete visible',
        'data-action' => 'file-delete',
        'data-url' => !isset($model) ? null : Url::to(['file-delete', 'id' => $model->id])
    ])?>

    <div class="file-deleting" data-action="file-deleting">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>