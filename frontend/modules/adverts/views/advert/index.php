<?php

use frontend\modules\adverts\widgets\AdvertList;
use frontend\modules\adverts\widgets\AdvertListLinkSorter;

use yii\widgets\Pjax;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\modules\adverts\models\search\AdvertSearch $searchModel
 * @var bool $renderFilter
 */

?>

<?php if ($renderFilter): ?>
    <?= $this->render('filter/index', [
        'model' => $searchModel,
    ]); ?>
<?php endif; ?>

<?php Pjax::begin(['id' => 'adverts-list-pjax']); ?>

    <?= AdvertList::widget([
        'id' => 'adverts-list',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'renderFilter' => $renderFilter,
        'options' => [
            'class' => !$renderFilter ? 'adverts-list' : 'adverts-list with-filter',
        ],
        'itemOptions' => [
            'class' => 'advert-container',
        ],
        'sorter' => [
            'class' => AdvertListLinkSorter::className(),
            'attributes' => [
                'created_at',
                'updated_at',
                'min_price',
            ],
        ]
    ]); ?>
<?php Pjax::end() ?>